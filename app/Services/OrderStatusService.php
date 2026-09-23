<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderStatusHistory;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderStatusService
{
    public function __construct(private OrderInventoryService $inventoryService) {}

    /**
     * Allowed forward and cancellation transitions.
     */
    public const TRANSITIONS = [
        'pending' => ['confirmed', 'cancelled'],
        'confirmed' => ['processing', 'cancelled'],
        'processing' => ['shipping', 'cancelled'],
        'shipping' => ['completed'],
        'completed' => [],
        'cancelled' => [],
    ];

    /**
     * Get list of allowed next statuses for a given status.
     *
     * @return array<int, string>
     */
    public function getAllowedTransitions(string $currentStatus): array
    {
        return self::TRANSITIONS[$currentStatus] ?? [];
    }

    /**
     * Check if transition from one status to another is valid.
     */
    public function canTransition(string $fromStatus, string $toStatus): bool
    {
        return in_array($toStatus, $this->getAllowedTransitions($fromStatus), true);
    }

    /**
     * Update order status with transition validation, row locking, and COD payment sync.
     *
     * @throws ValidationException
     */
    public function updateStatus(Order $order, string $newStatus, ?User $adminUser = null, ?string $note = null): Order
    {
        if ($newStatus === 'cancelled') {
            return $this->cancelOrder($order, $adminUser, $note)['order'];
        }

        return DB::transaction(function () use ($order, $newStatus, $adminUser, $note): Order {
            /** @var Order $lockedOrder */
            $lockedOrder = Order::query()->where('id', $order->id)->lockForUpdate()->firstOrFail();

            if (! $this->canTransition($lockedOrder->order_status, $newStatus)) {
                $fromLabel = Order::STATUS_LABELS[$lockedOrder->order_status] ?? $lockedOrder->order_status;
                $toLabel = Order::STATUS_LABELS[$newStatus] ?? $newStatus;

                throw ValidationException::withMessages([
                    'order_status' => "Không thể chuyển trạng thái đơn hàng từ '{$fromLabel}' sang '{$toLabel}'.",
                ]);
            }

            $fromStatus = $lockedOrder->order_status;
            $lockedOrder->order_status = $newStatus;

            // When completing a COD order, mark payment as paid
            if ($newStatus === 'completed' && $lockedOrder->payment_method === 'cod') {
                $lockedOrder->payment_status = 'paid';
                if ($lockedOrder->payment) {
                    $lockedOrder->payment->update([
                        'status' => 'paid',
                        'paid_at' => now(),
                    ]);
                }
            }

            $lockedOrder->save();

            // Record audit history
            OrderStatusHistory::create([
                'order_id' => $lockedOrder->id,
                'from_status' => $fromStatus,
                'to_status' => $newStatus,
                'changed_by' => $adminUser?->id,
                'note' => $note,
                'created_at' => now(),
            ]);

            return $lockedOrder;
        });
    }

    /**
     * Cancel order safely in a transaction:
     * Validates status, restores component inventory via OrderInventoryService,
     * updates COD payment to cancelled, and creates audit log.
     *
     * @return array{order: Order, warning: ?string}
     *
     * @throws ValidationException
     */
    public function cancelOrder(Order $order, ?User $adminUser = null, ?string $note = null): array
    {
        return DB::transaction(function () use ($order, $adminUser, $note): array {
            /** @var Order $lockedOrder */
            $lockedOrder = Order::query()->where('id', $order->id)->lockForUpdate()->firstOrFail();

            if (! $lockedOrder->isCancellable()) {
                $currentLabel = Order::STATUS_LABELS[$lockedOrder->order_status] ?? $lockedOrder->order_status;

                throw ValidationException::withMessages([
                    'order_status' => "Không thể hủy đơn hàng đang ở trạng thái '{$currentLabel}'.",
                ]);
            }

            // Restore component inventory safely
            $restoreResult = $this->inventoryService->restoreInventory($lockedOrder);

            $fromStatus = $lockedOrder->order_status;
            $lockedOrder->order_status = 'cancelled';

            // If COD order, mark payment as cancelled
            if ($lockedOrder->payment_method === 'cod') {
                $lockedOrder->payment_status = 'cancelled';
                if ($lockedOrder->payment) {
                    $lockedOrder->payment->update([
                        'status' => 'cancelled',
                        'paid_at' => null,
                    ]);
                }
            }

            $lockedOrder->save();

            // Record audit history
            OrderStatusHistory::create([
                'order_id' => $lockedOrder->id,
                'from_status' => $fromStatus,
                'to_status' => 'cancelled',
                'changed_by' => $adminUser?->id,
                'note' => $note ?: 'Admin hủy đơn hàng.',
                'created_at' => now(),
            ]);

            return [
                'order' => $lockedOrder,
                'warning' => $restoreResult['warning'] ?? null,
            ];
        });
    }
}
