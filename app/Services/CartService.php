<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CartService
{
    public function resolveCart(?User $user = null, ?string $sessionId = null, bool $create = false): ?Cart
    {
        if ($user) {
            $query = Cart::query()->where('user_id', $user->id);

            return $create ? $query->firstOrCreate(['user_id' => $user->id]) : $query->first();
        }

        if (! $sessionId) {
            return null;
        }

        $query = Cart::query()->where('session_id', $sessionId);

        return $create ? $query->firstOrCreate(['session_id' => $sessionId]) : $query->first();
    }

    public function currentCart(?User $user = null, ?string $sessionId = null, bool $create = false): ?Cart
    {
        return $this->resolveCart($user, $sessionId, $create);
    }

    public function add(Cart $cart, int $productId, int $quantity): array
    {
        $product = Product::query()->active()->find($productId);
        if (! $product) {
            throw ValidationException::withMessages(['product_id' => 'Sản phẩm không tồn tại hoặc đã ngừng bán.']);
        }

        return DB::transaction(function () use ($cart, $product, $quantity): array {
            Cart::query()->whereKey($cart->id)->lockForUpdate()->firstOrFail();
            $quantities = $cart->items()->lockForUpdate()->pluck('quantity', 'product_id')->all();
            $quantities[$product->id] = ($quantities[$product->id] ?? 0) + $quantity;
            $this->validateCartInventory($quantities);

            $cart->items()->updateOrCreate(
                ['product_id' => $product->id],
                ['quantity' => $quantities[$product->id], 'unit_price' => $this->currentPrice($product)]
            );
            $this->refreshPrices($cart);

            return $this->summary($cart);
        });
    }

    public function update(Cart $cart, int $itemId, int $quantity): array
    {
        return DB::transaction(function () use ($cart, $itemId, $quantity): array {
            Cart::query()->whereKey($cart->id)->lockForUpdate()->firstOrFail();
            $item = $cart->items()->lockForUpdate()->findOrFail($itemId);
            $quantities = $cart->items()->lockForUpdate()->pluck('quantity', 'product_id')->all();
            $quantities[$item->product_id] = $quantity;
            $this->validateCartInventory($quantities);
            $item->update(['quantity' => $quantity]);
            $this->refreshPrices($cart);

            return $this->summary($cart);
        });
    }

    public function remove(Cart $cart, int $itemId): array
    {
        return DB::transaction(function () use ($cart, $itemId): array {
            Cart::query()->whereKey($cart->id)->lockForUpdate()->firstOrFail();
            $cart->items()->lockForUpdate()->findOrFail($itemId)->delete();

            return $this->summary($cart);
        });
    }

    public function clear(?Cart $cart = null): array
    {
        if ($cart) {
            DB::transaction(function () use ($cart): void {
                Cart::query()->whereKey($cart->id)->lockForUpdate()->firstOrFail();
                $cart->items()->lockForUpdate()->delete();
            });
        }

        return ['success' => true, 'message' => 'Đã làm trống giỏ hàng.'] + $this->summary($cart?->fresh());
    }

    public function mergeGuestCart(User $user, ?string $token): ?string
    {
        if (! $token) {
            return null;
        }

        return DB::transaction(function () use ($user, $token): ?string {
            $guest = Cart::query()->where('session_id', $token)->lockForUpdate()->first();
            if (! $guest) {
                return null;
            }

            $cart = Cart::query()->firstOrCreate(['user_id' => $user->id]);
            Cart::query()->whereKey($cart->id)->lockForUpdate()->firstOrFail();
            $quantities = $cart->items()->lockForUpdate()->pluck('quantity', 'product_id')->all();
            foreach ($guest->items as $item) {
                $quantities[$item->product_id] = ($quantities[$item->product_id] ?? 0) + $item->quantity;
            }

            $warning = null;
            try {
                $this->validateCartInventory($quantities);
            } catch (ValidationException $exception) {
                // Preserve every guest item; the cart page asks the user to reduce quantities.
                $warning = 'Giỏ hàng đã được gộp, nhưng số lượng hiện vượt tồn kho. Vui lòng điều chỉnh trước khi mua.';
            }

            foreach ($guest->items as $item) {
                $cart->items()->updateOrCreate(
                    ['product_id' => $item->product_id],
                    ['quantity' => $quantities[$item->product_id], 'unit_price' => $item->unit_price]
                );
            }
            $this->refreshPrices($cart);
            $guest->delete();

            return $warning;
        });
    }

    /**
     * Build an aggregate map of required component product quantities.
     *
     * @param  Cart|array<int, int>  $cartOrQuantities
     * @return array<int, array{component: Product, required: int}>
     *
     * @throws ValidationException
     */
    public function buildInventoryRequirements(Cart|array $cartOrQuantities): array
    {
        $quantities = $cartOrQuantities instanceof Cart
            ? $cartOrQuantities->items()->pluck('quantity', 'product_id')->all()
            : $cartOrQuantities;

        if (empty($quantities)) {
            return [];
        }

        $products = Product::query()->with('bundleItems.component')->whereKey(array_keys($quantities))->get()->keyBy('id');
        $requirements = [];

        foreach ($quantities as $productId => $quantity) {
            $product = $products->get($productId);
            if (! $product || ! $product->is_active) {
                throw ValidationException::withMessages(['product_id' => 'Có sản phẩm không còn khả dụng trong giỏ hàng.']);
            }
            if ($quantity < 1) {
                throw ValidationException::withMessages(['quantity' => 'Số lượng phải từ 1 trở lên.']);
            }

            if ($product->product_type === 'single') {
                $componentId = $product->id;
                $current = $requirements[$componentId]['required'] ?? 0;
                $requirements[$componentId] = [
                    'component' => $product,
                    'required' => $current + $quantity,
                ];

                continue;
            }

            if ($product->bundleItems->isEmpty()) {
                throw ValidationException::withMessages(['quantity' => 'Bộ sản phẩm '.$product->sku.' chưa có thành phần hợp lệ.']);
            }

            foreach ($product->bundleItems as $item) {
                $component = $item->component;
                if (! $component || ! $component->is_active || $component->product_type !== 'single' || $item->quantity < 1) {
                    throw ValidationException::withMessages(['quantity' => 'Thành phần của '.$product->sku.' không còn hợp lệ.']);
                }

                $componentId = $component->id;
                $current = $requirements[$componentId]['required'] ?? 0;
                $requirements[$componentId] = [
                    'component' => $component,
                    'required' => $current + ($quantity * $item->quantity),
                ];
            }
        }

        return $requirements;
    }

    /**
     * Validate that aggregate component demand does not exceed available inventory.
     *
     * @param  Cart|array<int, int>  $cartOrQuantities
     *
     * @throws ValidationException
     */
    public function validateCartInventory(Cart|array $cartOrQuantities): void
    {
        $requirements = $this->buildInventoryRequirements($cartOrQuantities);

        foreach ($requirements as $requirement) {
            /** @var Product $component */
            $component = $requirement['component'];
            $requiredQuantity = $requirement['required'];

            if ($requiredQuantity > $component->availableQuantity()) {
                throw ValidationException::withMessages(['quantity' => 'Không đủ tồn kho cho '.$component->sku.'.']);
            }
        }
    }

    public function summary(?Cart $cart): array
    {
        if (! $cart) {
            return ['items' => [], 'cart_count' => 0, 'subtotal' => '0.00', 'subtotal_display' => '0 ₫'];
        }

        $cart->load(['items' => fn ($query) => $query->orderByDesc('id'), 'items.product.images', 'items.product.bundleItems.component']);
        $items = [];
        $subtotalCents = 0;
        $cartCount = 0;

        foreach ($cart->items as $item) {
            $product = $item->product;
            $image = $product->images->firstWhere('image_role', 'primary') ?: $product->images->first();
            $unitCents = $this->cents($item->unit_price);
            $lineCents = $unitCents * $item->quantity;
            $subtotalCents += $lineCents;
            $cartCount += $item->quantity;
            $items[] = [
                'id' => $item->id,
                'product_id' => $product->id,
                'slug' => $product->slug,
                'url' => route('products.show', $product->slug),
                'name' => $product->name,
                'sku' => $product->sku,
                'type' => $product->product_type,
                'quantity' => $item->quantity,
                'unit_price' => $item->unit_price,
                'unit_price_display' => $this->formatVnd($unitCents),
                'line_subtotal' => $this->decimal($lineCents),
                'line_subtotal_display' => $this->formatVnd($lineCents),
                'image_url' => $image?->displayUrl(),
            ];
        }

        return [
            'items' => $items,
            'cart_count' => $cartCount,
            'subtotal' => $this->decimal($subtotalCents),
            'subtotal_display' => $this->formatVnd($subtotalCents),
        ];
    }

    public function refreshPrices(Cart $cart): bool
    {
        $changed = false;
        foreach ($cart->items()->with('product')->get() as $item) {
            $price = $this->currentPrice($item->product);
            if ($item->unit_price !== $price) {
                $item->update(['unit_price' => $price]);
                $changed = true;
            }
        }

        return $changed;
    }

    private function currentPrice(Product $product): string
    {
        return $product->hasValidSalePrice() ? $product->sale_price : $product->regular_price;
    }

    private function cents(string $amount): int
    {
        return (int) str_replace('.', '', $amount);
    }

    private function decimal(int $cents): string
    {
        return intdiv($cents, 100).'.'.str_pad((string) ($cents % 100), 2, '0', STR_PAD_LEFT);
    }

    private function formatVnd(int $cents): string
    {
        return number_format(intdiv($cents, 100), 0, ',', '.').' ₫';
    }
}
