<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;

class OrderInventoryService
{
    /**
     * Safely restore inventory for an order based on order_item_components snapshot.
     * Prevents double-restoration, locks single product rows in ascending order,
     * updates stock_status to in_stock when positive, and never touches bundle stored stock.
     *
     * @return array{restored: bool, message?: string, warning?: ?string}
     */
    public function restoreInventory(Order $order): array
    {
        if ($order->inventory_restored_at !== null) {
            return [
                'restored' => false,
                'message' => 'Tồn kho của đơn hàng này đã được hoàn lại trước đó.',
                'warning' => null,
            ];
        }

        $order->load(['items.components']);

        $quantitiesToRestore = [];
        $warning = null;

        foreach ($order->items as $item) {
            if ($item->components->isNotEmpty()) {
                foreach ($item->components as $componentSnapshot) {
                    if ($componentSnapshot->product_id) {
                        $pId = (int) $componentSnapshot->product_id;
                        $quantitiesToRestore[$pId] = ($quantitiesToRestore[$pId] ?? 0) + $componentSnapshot->total_quantity;
                    }
                }
            } else {
                // Backward compatibility for legacy orders created before component snapshotting
                // If the product is a bundle (collection/gift), DO NOT guess composition from current DB state
                $product = $item->product_id ? Product::find($item->product_id) : null;
                if ($product && in_array($product->product_type, ['collection', 'gift'], true)) {
                    $warning = 'Đơn hàng cũ chứa bundle chưa có snapshot linh kiện; linh kiện bundle không tự động hoàn kho để tránh sai lệch.';
                } elseif ($product && $product->product_type === 'single') {
                    $pId = $product->id;
                    $quantitiesToRestore[$pId] = ($quantitiesToRestore[$pId] ?? 0) + $item->quantity;
                }
            }
        }

        if (! empty($quantitiesToRestore)) {
            $componentIds = array_keys($quantitiesToRestore);
            sort($componentIds, SORT_NUMERIC);

            // Row-level locking on single product components in ascending ID order
            $lockedProducts = Product::query()
                ->whereIn('id', $componentIds)
                ->orderBy('id', 'asc')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            foreach ($quantitiesToRestore as $productId => $qty) {
                /** @var Product|null $product */
                $product = $lockedProducts->get($productId);
                if ($product && $product->product_type === 'single') {
                    $product->stock_quantity += $qty;
                    if ($product->stock_quantity > 0 && $product->stock_status === 'out_of_stock') {
                        $product->stock_status = 'in_stock';
                    }
                    $product->save();
                }
            }
        }

        $order->inventory_restored_at = now();
        $order->save();

        return [
            'restored' => true,
            'warning' => $warning,
        ];
    }
}
