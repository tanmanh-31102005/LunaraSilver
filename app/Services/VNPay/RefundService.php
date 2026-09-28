<?php

namespace App\Services\VNPay;

use App\Models\Order;
use App\Models\OrderStatusHistory;
use App\Models\Payment;
use App\Models\PaymentRefund;
use App\Models\User;
use App\Services\OrderInventoryService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class RefundService
{
    public function __construct(
        private VNPayService $vnpayService,
        private OrderInventoryService $inventoryService
    ) {}

    /**
     * Process full or partial refund for a paid order via VNPay WebAPI.
     *
     * @throws ValidationException
     */
    public function processRefund(
        Order $order,
        float $amount,
        string $reason,
        string $requestedBy,
        string $ipAddress = '127.0.0.1'
    ): PaymentRefund {
        if ($amount <= 0) {
            throw ValidationException::withMessages([
                'amount' => 'Số tiền hoàn phải lớn hơn 0.',
            ]);
        }

        // Find the successful paid payment attempt
        /** @var Payment|null $payment */
        $payment = $order->payments()->where('status', Payment::STATUS_PAID)->latest()->first();

        if (! $payment) {
            throw ValidationException::withMessages([
                'order' => 'Đơn hàng này chưa có giao dịch thanh toán thành công nào để hoàn tiền.',
            ]);
        }

        $remaining = $order->remainingRefundableAmount();
        if ($amount > $remaining) {
            throw ValidationException::withMessages([
                'amount' => 'Số tiền yêu cầu hoàn ('.number_format($amount).' đ) vượt quá số tiền có thể hoàn còn lại ('.number_format($remaining).' đ).',
            ]);
        }

        $refundType = (abs($amount - $remaining) < 0.01 && $order->refunds()->where('status', PaymentRefund::STATUS_SUCCEEDED)->count() === 0)
            ? PaymentRefund::TYPE_FULL
            : PaymentRefund::TYPE_PARTIAL;

        $requestId = (string) Str::uuid();

        // Create requested refund record
        $refund = PaymentRefund::create([
            'payment_id' => $payment->id,
            'order_id' => $order->id,
            'request_id' => $requestId,
            'refund_type' => $refundType,
            'amount' => $amount,
            'status' => PaymentRefund::STATUS_REQUESTED,
            'reason' => $reason,
            'requested_by' => $requestedBy,
            'requested_at' => now(),
            'request_payload' => [
                'txn_ref' => $payment->txn_ref,
                'amount' => $amount,
                'refund_type' => $refundType,
                'reason' => $reason,
            ],
        ]);

        // Call VNPay Refund API
        $refundResult = $this->vnpayService->refund(
            payment: $payment,
            amount: $amount,
            refundType: $refundType,
            createBy: $requestedBy,
            reason: $reason,
            ipAddress: $ipAddress
        );

        return DB::transaction(function () use ($refund, $refundResult, $order, $amount): PaymentRefund {
            /** @var PaymentRefund $lockedRefund */
            $lockedRefund = PaymentRefund::query()->where('id', $refund->id)->lockForUpdate()->firstOrFail();
            /** @var Order $lockedOrder */
            $lockedOrder = Order::query()->where('id', $order->id)->lockForUpdate()->firstOrFail();

            $lockedRefund->vnp_transaction_no = $refundResult->vnpTransactionNo;
            $lockedRefund->vnp_response_code = $refundResult->responseCode;
            $lockedRefund->vnp_transaction_status = $refundResult->vnpTransactionStatus;
            $lockedRefund->response_payload = $refundResult->rawPayload;
            $lockedRefund->processed_at = now();

            if ($refundResult->isAccepted()) {
                $lockedRefund->status = PaymentRefund::STATUS_SUCCEEDED;
                $lockedRefund->save();

                // Recalculate remaining
                $remainingAfter = $lockedOrder->remainingRefundableAmount();
                if ($remainingAfter <= 0) {
                    $lockedOrder->payment_status = 'refunded';
                } else {
                    $lockedOrder->payment_status = 'partially_refunded';
                }
                $lockedOrder->save();

                OrderStatusHistory::create([
                    'order_id' => $lockedOrder->id,
                    'from_status' => $lockedOrder->order_status,
                    'to_status' => $lockedOrder->order_status,
                    'changed_by' => auth()->id(),
                    'note' => 'Hoàn tiền VNPay thành công: '.number_format($amount)." đ ({$lockedRefund->type_label}). Trạng thái thanh toán: {$lockedOrder->payment_status_label}.",
                ]);
            } else {
                $lockedRefund->status = PaymentRefund::STATUS_FAILED;
                $lockedRefund->save();

                OrderStatusHistory::create([
                    'order_id' => $lockedOrder->id,
                    'from_status' => $lockedOrder->order_status,
                    'to_status' => $lockedOrder->order_status,
                    'changed_by' => auth()->id(),
                    'note' => "Yêu cầu hoàn tiền VNPay thất bại: {$refundResult->message} (Mã lỗi: {$refundResult->responseCode}).",
                ]);
            }

            return $lockedRefund;
        });
    }

    /**
     * Cancel an order with automated refund if paid via VNPay.
     *
     * @return array{order: Order, refund: ?PaymentRefund, warning: ?string}
     *
     * @throws ValidationException
     */
    public function cancelOrderWithRefund(
        Order $order,
        string $reason,
        ?User $adminUser = null,
        string $ipAddress = '127.0.0.1'
    ): array {
        return DB::transaction(function () use ($order, $reason, $adminUser, $ipAddress): array {
            /** @var Order $lockedOrder */
            $lockedOrder = Order::query()->where('id', $order->id)->lockForUpdate()->firstOrFail();

            if (! $lockedOrder->isCancellable()) {
                throw ValidationException::withMessages([
                    'order' => 'Không thể hủy đơn hàng đang ở trạng thái '.$lockedOrder->order_status_label,
                ]);
            }

            // Restore component inventory safely
            $restoreResult = $this->inventoryService->restoreInventory($lockedOrder);

            $oldOrderStatus = $lockedOrder->order_status;
            $lockedOrder->order_status = 'cancelled';

            $refundRecord = null;

            if ($lockedOrder->payment_method === 'vnpay' && $lockedOrder->payment_status === 'paid') {
                $lockedOrder->payment_status = 'refund_pending';
                $lockedOrder->save();

                OrderStatusHistory::create([
                    'order_id' => $lockedOrder->id,
                    'from_status' => $oldOrderStatus,
                    'to_status' => 'cancelled',
                    'changed_by' => $adminUser?->id,
                    'note' => "Đơn hàng đã hủy. Chuyển sang chờ hoàn tiền VNPay. Lý do: {$reason}",
                ]);

                // Trigger refund for full refundable amount
                $refundableAmount = $lockedOrder->remainingRefundableAmount();
                if ($refundableAmount > 0) {
                    $requestedBy = $adminUser ? $adminUser->name : 'System';
                    try {
                        $refundRecord = $this->processRefund(
                            order: $lockedOrder,
                            amount: $refundableAmount,
                            reason: 'Hủy đơn hàng: '.$reason,
                            requestedBy: $requestedBy,
                            ipAddress: $ipAddress
                        );
                    } catch (\Throwable $e) {
                        // Keep order in refund_pending for manual admin handling
                    }
                }
            } elseif ($lockedOrder->payment_method === 'cod') {
                $lockedOrder->payment_status = 'cancelled';
                if ($lockedOrder->payment) {
                    $lockedOrder->payment->update(['status' => 'cancelled']);
                }
                $lockedOrder->save();

                OrderStatusHistory::create([
                    'order_id' => $lockedOrder->id,
                    'from_status' => $oldOrderStatus,
                    'to_status' => 'cancelled',
                    'changed_by' => $adminUser?->id,
                    'note' => "Hủy đơn hàng COD. Lý do: {$reason}",
                ]);
            } else {
                $lockedOrder->payment_status = 'cancelled';
                if ($lockedOrder->payment) {
                    $lockedOrder->payment->update(['status' => 'cancelled']);
                }
                $lockedOrder->save();

                OrderStatusHistory::create([
                    'order_id' => $lockedOrder->id,
                    'from_status' => $oldOrderStatus,
                    'to_status' => 'cancelled',
                    'changed_by' => $adminUser?->id,
                    'note' => "Hủy đơn hàng. Lý do: {$reason}",
                ]);
            }

            return [
                'order' => $lockedOrder->fresh(),
                'refund' => $refundRecord,
                'warning' => $restoreResult['warning'] ?? null,
            ];
        });
    }
}
