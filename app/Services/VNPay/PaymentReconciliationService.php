<?php

namespace App\Services\VNPay;

use App\Models\Order;
use App\Models\OrderStatusHistory;
use App\Models\Payment;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentReconciliationService
{
    public function __construct(private VNPayService $vnpayService) {}

    /**
     * Reconcile a VNPay payment attempt with VNPay QueryDr.
     *
     * @param bool $force Bypass cooldown throttle
     * @return array{success: bool, status: string, changed: bool, message: string, payment: Payment}
     */
    public function reconcileVNPayPayment(Payment $payment, string $ipAddress = '127.0.0.1', bool $force = false): array
    {
        if (! $payment->isVNPay() || empty($payment->txn_ref)) {
            return [
                'success' => false,
                'status' => $payment->status,
                'changed' => false,
                'message' => 'Không phải giao dịch VNPay hợp lệ để đối soát.',
                'payment' => $payment,
            ];
        }

        // Throttle cooldown unless forced
        $cooldown = (int) config('vnpay.query_cooldown_seconds', 15);
        if (! $force && $payment->last_queried_at && Carbon::parse($payment->last_queried_at)->addSeconds($cooldown)->isFuture()) {
            return [
                'success' => true,
                'status' => $payment->status,
                'changed' => false,
                'message' => "Vừa đối soát gần đây. Vui lòng chờ {$cooldown} giây trước khi đối soát lại.",
                'payment' => $payment,
            ];
        }

        if (empty($payment->vnp_create_date)) {
            $payment->vnp_create_date = $payment->created_at
                ? $payment->created_at->timezone('Asia/Ho_Chi_Minh')->format('YmdHis')
                : Carbon::now('Asia/Ho_Chi_Minh')->format('YmdHis');
            $payment->save();
        }

        $queryResult = $this->vnpayService->queryTransaction($payment, $ipAddress);

        return DB::transaction(function () use ($payment, $queryResult): array {
            /** @var Payment $lockedPayment */
            $lockedPayment = Payment::query()->where('id', $payment->id)->lockForUpdate()->firstOrFail();
            /** @var Order $lockedOrder */
            $lockedOrder = Order::query()->where('id', $lockedPayment->order_id)->lockForUpdate()->firstOrFail();

            $initialStatus = $lockedPayment->status;
            $changed = false;

            $lockedPayment->query_count = ($lockedPayment->query_count ?? 0) + 1;
            $lockedPayment->last_queried_at = now();

            if ($queryResult->isPaid()) {
                // Transaction was confirmed successful by VNPay
                if ($lockedPayment->status !== Payment::STATUS_PAID) {
                    $lockedPayment->status = Payment::STATUS_PAID;
                    $lockedPayment->vnp_transaction_no = $queryResult->vnpTransactionNo;
                    $lockedPayment->vnp_bank_code = $queryResult->bankCode;
                    $lockedPayment->vnp_card_type = $queryResult->cardType;
                    $lockedPayment->vnp_pay_date = $queryResult->payDate;
                    $lockedPayment->paid_at = now();
                    $lockedPayment->response_data = $queryResult->rawPayload;
                    $lockedPayment->save();
                    $changed = true;

                    // Update order payment status
                    $oldPaymentStatus = $lockedOrder->payment_status;
                    $lockedOrder->payment_status = 'paid';

                    // If order is pending, transition to confirmed
                    $oldOrderStatus = $lockedOrder->order_status;
                    if ($lockedOrder->order_status === 'pending') {
                        $lockedOrder->order_status = 'confirmed';
                    }
                    $lockedOrder->save();

                    // Audit log
                    OrderStatusHistory::create([
                        'order_id' => $lockedOrder->id,
                        'from_status' => $oldOrderStatus,
                        'to_status' => $lockedOrder->order_status,
                        'changed_by' => auth()->id(),
                        'note' => "VNPay QueryDr xác nhận thanh toán thành công (Mã GD VNPay: {$queryResult->vnpTransactionNo}). Trạng thái thanh toán: '{$oldPaymentStatus}' -> 'paid'.",
                    ]);
                } else {
                    // Update metadata if missing
                    if (! empty($queryResult->vnpTransactionNo) && empty($lockedPayment->vnp_transaction_no)) {
                        $lockedPayment->vnp_transaction_no = $queryResult->vnpTransactionNo;
                        $lockedPayment->vnp_bank_code = $queryResult->bankCode;
                        $lockedPayment->vnp_card_type = $queryResult->cardType;
                        $lockedPayment->vnp_pay_date = $queryResult->payDate;
                        $lockedPayment->save();
                    }
                }

                return [
                    'success' => true,
                    'status' => Payment::STATUS_PAID,
                    'changed' => $changed,
                    'message' => $queryResult->getHumanMessage(),
                    'payment' => $lockedPayment,
                ];
            }

            if ($queryResult->isFailed()) {
                if ($lockedPayment->status === Payment::STATUS_PENDING) {
                    $lockedPayment->status = Payment::STATUS_FAILED;
                    $lockedPayment->failure_reason = $queryResult->getHumanMessage();
                    $lockedPayment->response_data = $queryResult->rawPayload;
                    $lockedPayment->save();
                    $changed = true;

                    // Only update order to failed if no other attempt is paid
                    $hasPaid = Payment::query()
                        ->where('order_id', $lockedOrder->id)
                        ->where('status', Payment::STATUS_PAID)
                        ->exists();

                    if (! $hasPaid && $lockedOrder->payment_status === 'pending') {
                        $lockedOrder->payment_status = 'failed';
                        $lockedOrder->save();
                    }
                }

                return [
                    'success' => true,
                    'status' => $lockedPayment->status,
                    'changed' => $changed,
                    'message' => 'Giao dịch thất bại hoặc đã bị hủy trên cổng VNPay: ' . $queryResult->getHumanMessage(),
                    'payment' => $lockedPayment,
                ];
            }

            if ($queryResult->isNotFound()) {
                $lockedPayment->response_data = $queryResult->rawPayload;
                $lockedPayment->save();

                return [
                    'success' => false,
                    'is_not_found' => true,
                    'status' => $lockedPayment->status,
                    'changed' => false,
                    'message' => $queryResult->getHumanMessage(),
                    'payment' => $lockedPayment,
                ];
            }

            if ($queryResult->isDuplicate()) {
                $lockedPayment->response_data = $queryResult->rawPayload;
                $lockedPayment->save();

                return [
                    'success' => false,
                    'is_duplicate' => true,
                    'status' => $lockedPayment->status,
                    'changed' => false,
                    'message' => $queryResult->getHumanMessage(),
                    'payment' => $lockedPayment,
                ];
            }

            // Still pending or unknown code
            $lockedPayment->response_data = $queryResult->rawPayload;
            $lockedPayment->save();

            return [
                'success' => $queryResult->isSuccess,
                'status' => $lockedPayment->status,
                'changed' => $changed,
                'message' => $queryResult->getHumanMessage(),
                'payment' => $lockedPayment,
            ];
        });
    }
}
