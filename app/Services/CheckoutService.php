<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemComponent;
use App\Models\OrderStatusHistory;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CheckoutService
{
    public function __construct(private CartService $cartService) {}

    /**
     * Process checkout in a strict database transaction with pessimistic row locking.
     *
     * @param  array{customer_name: string, customer_email: string, customer_phone: string, shipping_address: string, shipping_city: string, shipping_note?: ?string, customer_note?: ?string, payment_method: string}  $customerData
     *
     * @throws ValidationException
     */
    public function processCheckout(Cart $cart, User $user, array $customerData): Order
    {
        $cart->load(['items.product.images', 'items.product.bundleItems.component']);

        if ($cart->items->isEmpty()) {
            throw ValidationException::withMessages(['cart' => 'Giỏ hàng của bạn đang trống.']);
        }

        // Refresh prices before creating order snapshot
        $this->cartService->refreshPrices($cart);
        $cart->load('items.product');

        // Build aggregate inventory requirements using the shared CartService API
        $requirements = $this->cartService->buildInventoryRequirements($cart);

        return DB::transaction(function () use ($cart, $user, $customerData, $requirements): Order {
            $componentIds = array_keys($requirements);
            sort($componentIds, SORT_NUMERIC);

            // Row-level lock on single product component rows in ascending ID order to prevent deadlocks
            $lockedComponents = Product::query()
                ->whereIn('id', $componentIds)
                ->orderBy('id', 'asc')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            // Re-validate stock under row lock
            foreach ($requirements as $componentId => $req) {
                /** @var Product|null $component */
                $component = $lockedComponents->get($componentId);
                $required = $req['required'];

                if (! $component || ! $component->is_active) {
                    throw ValidationException::withMessages([
                        'cart' => 'Sản phẩm '.($component?->sku ?? "ID {$componentId}").' không còn khả dụng.',
                    ]);
                }

                if ($component->stock_quantity < $required) {
                    throw ValidationException::withMessages([
                        'cart' => 'Không đủ tồn kho cho '.$component->sku.' (yêu cầu '.$required.', còn '.$component->stock_quantity.').',
                    ]);
                }
            }

            // Calculate exact totals using integer cents
            $subtotalCents = 0;
            foreach ($cart->items as $item) {
                $unitCents = $this->cents($item->unit_price);
                $subtotalCents += $unitCents * $item->quantity;
            }

            $subtotalDecimal = $this->decimal($subtotalCents);
            $shippingFeeDecimal = '0.00';
            $discountDecimal = '0.00';
            $grandTotalDecimal = $this->decimal($subtotalCents);

            // Generate unique, readable order code
            $orderCode = $this->generateOrderCode();

            // Create Order record
            $order = Order::create([
                'user_id' => $user->id,
                'order_code' => $orderCode,
                'customer_name' => $customerData['customer_name'],
                'customer_email' => $customerData['customer_email'],
                'customer_phone' => $customerData['customer_phone'],
                'shipping_address' => $customerData['shipping_address'],
                'shipping_city' => $customerData['shipping_city'],
                'shipping_note' => $customerData['shipping_note'] ?? null,
                'shipping_method' => 'standard',
                'subtotal' => $subtotalDecimal,
                'discount_amount' => $discountDecimal,
                'shipping_fee' => $shippingFeeDecimal,
                'grand_total' => $grandTotalDecimal,
                'payment_method' => 'cod',
                'payment_status' => 'pending',
                'order_status' => 'pending',
                'customer_note' => $customerData['customer_note'] ?? null,
                'placed_at' => now(),
            ]);

            // Record initial order status history
            OrderStatusHistory::create([
                'order_id' => $order->id,
                'from_status' => null,
                'to_status' => 'pending',
                'changed_by' => null,
                'note' => 'Đơn hàng được khởi tạo thành công qua checkout COD.',
            ]);

            // Create OrderItem snapshots and detailed component snapshots
            foreach ($cart->items as $item) {
                $unitCents = $this->cents($item->unit_price);
                $lineCents = $unitCents * $item->quantity;

                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'product_sku' => $item->product->sku,
                    'unit_price' => $item->unit_price,
                    'quantity' => $item->quantity,
                    'subtotal' => $this->decimal($lineCents),
                ]);

                // Snapshot components for exact inventory restoration
                if ($item->product->isBundle()) {
                    foreach ($item->product->bundleItems as $bundleItem) {
                        $comp = $bundleItem->component;
                        OrderItemComponent::create([
                            'order_item_id' => $orderItem->id,
                            'product_id' => $bundleItem->component_id,
                            'product_sku' => $comp?->sku ?? "COMP-{$bundleItem->component_id}",
                            'product_name' => $comp?->name ?? 'Linh kiện bundle',
                            'quantity_per_item' => $bundleItem->quantity,
                            'total_quantity' => $bundleItem->quantity * $item->quantity,
                        ]);
                    }
                } else {
                    OrderItemComponent::create([
                        'order_item_id' => $orderItem->id,
                        'product_id' => $item->product_id,
                        'product_sku' => $item->product->sku,
                        'product_name' => $item->product->name,
                        'quantity_per_item' => 1,
                        'total_quantity' => $item->quantity,
                    ]);
                }
            }

            // Create COD Payment record
            Payment::create([
                'order_id' => $order->id,
                'provider' => 'cod',
                'transaction_id' => null,
                'amount' => $grandTotalDecimal,
                'status' => 'pending',
                'request_data' => null,
                'response_data' => null,
                'paid_at' => null,
            ]);

            // Decrement aggregate component stocks and update single stock_status
            // Note: collections & gifts have virtual inventory and their stock_quantity is NEVER touched
            foreach ($requirements as $componentId => $req) {
                /** @var Product $component */
                $component = $lockedComponents->get($componentId);
                $required = $req['required'];

                $component->stock_quantity -= $required;
                $component->stock_status = $component->stock_quantity > 0 ? 'in_stock' : 'out_of_stock';
                $component->save();
            }

            // Clear cart items after successful order creation
            $this->cartService->clear($cart);

            return $order;
        });
    }

    public function generateOrderCode(): string
    {
        do {
            $code = 'LNS-'.date('Ymd').'-'.strtoupper(Str::random(6));
        } while (Order::query()->where('order_code', $code)->exists());

        return $code;
    }

    private function cents(string $amount): int
    {
        return (int) str_replace('.', '', $amount);
    }

    private function decimal(int $cents): string
    {
        return intdiv($cents, 100).'.'.str_pad((string) ($cents % 100), 2, '0', STR_PAD_LEFT);
    }
}
