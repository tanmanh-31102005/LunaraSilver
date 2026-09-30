<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CouponService
{
    /**
     * Validate coupon code against subtotal, cart items, user and customer email.
     *
     * @return array{valid: bool, coupon: Coupon, code: string, type: string, value: float, discount: float, discount_amount: float, discount_display: string, message: string}
     *
     * @throws ValidationException
     */
    public function validate(
        ?string $code,
        float|int $subtotal,
        ?User $user = null,
        ?Cart $cart = null,
        ?string $customerEmail = null
    ): array {
        $code = trim((string) $code);
        if ($code === '') {
            throw ValidationException::withMessages(['coupon' => 'Vui lòng nhập mã ưu đãi.']);
        }

        $normalized = strtoupper($code);
        $coupon = Coupon::where('code', $normalized)->first();

        // 1. Coupon exists?
        if (! $coupon) {
            throw ValidationException::withMessages(['coupon' => 'Mã ưu đãi không tồn tại.']);
        }

        // 2. Active?
        if (! $coupon->is_active) {
            throw ValidationException::withMessages(['coupon' => 'Mã ưu đãi hiện không khả dụng.']);
        }

        // 3. Starts_at reached?
        if (! $coupon->hasStarted()) {
            throw ValidationException::withMessages(['coupon' => 'Mã ưu đãi chưa đến thời gian áp dụng.']);
        }

        // 4. Not expired?
        if ($coupon->isExpired()) {
            throw ValidationException::withMessages(['coupon' => 'Mã ưu đãi đã hết hạn sử dụng.']);
        }

        // 5. Subtotal meets minimum?
        $minOrder = (float) ($coupon->min_order_amount ?? $coupon->minimum_order ?? 0);
        if ($minOrder > 0 && $subtotal < $minOrder) {
            $formattedMin = number_format($minOrder, 0, ',', '.').' ₫';
            throw ValidationException::withMessages([
                'coupon' => "Đơn hàng tối thiểu để áp dụng mã này là {$formattedMin}.",
            ]);
        }

        // 6. Global usage limit available?
        if ($coupon->isUsageLimitReached()) {
            throw ValidationException::withMessages(['coupon' => 'Mã ưu đãi đã hết lượt sử dụng.']);
        }

        // 7. Per-user usage limit available?
        if ($coupon->usage_limit_per_user !== null) {
            if ($user) {
                $usedByUser = CouponUsage::where('coupon_id', $coupon->id)
                    ->where('user_id', $user->id)
                    ->where('status', CouponUsage::STATUS_APPLIED)
                    ->count();

                if ($usedByUser >= $coupon->usage_limit_per_user) {
                    throw ValidationException::withMessages([
                        'coupon' => 'Bạn đã sử dụng hết số lần cho phép của mã ưu đãi này.',
                    ]);
                }
            }
        }

        // 8. First-Order Only coupon restriction
        if ($coupon->isFirstOrderOnly()) {
            $hasPreviousOrder = false;
            if ($user) {
                $hasPreviousOrder = Order::where('user_id', $user->id)
                    ->whereNotIn('order_status', ['cancelled'])
                    ->exists();
            }
            $email = trim((string) ($customerEmail ?? $user?->email));
            if (! $hasPreviousOrder && $email !== '') {
                $hasPreviousOrder = Order::where('customer_email', $email)
                    ->whereNotIn('order_status', ['cancelled'])
                    ->exists();
            }

            if ($hasPreviousOrder) {
                throw ValidationException::withMessages([
                    'coupon' => 'Mã ưu đãi này chỉ áp dụng cho đơn hàng đầu tiên của khách hàng mới.',
                ]);
            }
        }

        // 9. Customer-Specific coupon restriction
        if ($coupon->hasCustomerRestrictions()) {
            if (! $coupon->appliesToCustomer($user, $customerEmail)) {
                throw ValidationException::withMessages([
                    'coupon' => 'Mã ưu đãi này chỉ dành riêng cho khách hàng được chỉ định.',
                ]);
            }
        }

        // 10. Product-Specific or Category-Specific coupon restriction
        if ($coupon->hasProductOrCategoryRestrictions() && $cart) {
            $eligible = $this->calculateEligibleSubtotal($coupon, $cart);
            if ($eligible === null || $eligible <= 0) {
                throw ValidationException::withMessages([
                    'coupon' => 'Mã ưu đãi này chỉ áp dụng cho một số sản phẩm hoặc danh mục cụ thể và giỏ hàng của bạn không có sản phẩm phù hợp.',
                ]);
            }
        }

        // 11. Calculate discount
        $discount = $this->calculateDiscount($coupon, (float) $subtotal, $cart);

        return [
            'valid' => true,
            'coupon' => $coupon,
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => (float) $coupon->value,
            'discount' => $discount,
            'discount_amount' => $discount,
            'discount_display' => '-'.number_format($discount, 0, ',', '.').' ₫',
            'message' => 'Áp dụng mã ưu đãi thành công.',
        ];
    }

    /**
     * Calculate eligible subtotal for coupons restricted to specific products or categories.
     */
    public function calculateEligibleSubtotal(Coupon $coupon, ?Cart $cart): ?float
    {
        if (! $coupon->hasProductOrCategoryRestrictions() || ! $cart) {
            return null;
        }

        $cart->loadMissing(['items.product.category']);
        $eligibleSubtotal = 0.0;
        $hasMatch = false;

        foreach ($cart->items as $item) {
            $product = $item->product;
            if (! $product) {
                continue;
            }

            $catId = $product->category_id ?? $product->category?->id;
            if ($coupon->appliesToProduct($product->id, $catId)) {
                $hasMatch = true;
                $eligibleSubtotal += ((float) $item->unit_price) * $item->quantity;
            }
        }

        return $hasMatch ? $eligibleSubtotal : 0.0;
    }

    /**
     * Calculate discount amount without exceeding subtotal or eligible portion.
     */
    public function calculateDiscount(Coupon $coupon, float $subtotal, ?Cart $cart = null): float
    {
        if ($subtotal <= 0) {
            return 0.0;
        }

        $eligibleSubtotal = $this->calculateEligibleSubtotal($coupon, $cart);
        $base = $eligibleSubtotal !== null ? $eligibleSubtotal : $subtotal;

        if ($base <= 0) {
            return 0.0;
        }

        $discount = 0.0;
        $val = (float) $coupon->value;

        if ($coupon->type === Coupon::TYPE_PERCENTAGE) {
            $discount = round($base * ($val / 100));
            $maxDiscount = (float) ($coupon->max_discount_amount ?? $coupon->maximum_discount ?? 0);
            if ($maxDiscount > 0) {
                $discount = min($discount, $maxDiscount);
            }
        } elseif ($coupon->type === Coupon::TYPE_FIXED) {
            $discount = $val;
        }

        // Never exceed base subtotal and never negative
        $discount = min($discount, $base);
        $discount = max(0.0, $discount);

        return round($discount, 2);
    }

    /**
     * Record usage when an order is successfully created.
     */
    public function recordUsage(Coupon $coupon, Order $order, ?User $user = null): CouponUsage
    {
        return DB::transaction(function () use ($coupon, $order, $user): CouponUsage {
            $userId = $user?->id ?? $order->user_id;

            $usage = CouponUsage::updateOrCreate(
                [
                    'coupon_id' => $coupon->id,
                    'order_id' => $order->id,
                ],
                [
                    'user_id' => $userId,
                    'status' => CouponUsage::STATUS_APPLIED,
                    'used_at' => now(),
                    'released_at' => null,
                ]
            );

            // Increment used_count safely
            Coupon::where('id', $coupon->id)->increment('used_count');

            return $usage;
        });
    }

    /**
     * Release coupon usage when an order is cancelled.
     */
    public function releaseUsage(Order $order): bool
    {
        return DB::transaction(function () use ($order): bool {
            $usage = CouponUsage::where('order_id', $order->id)
                ->where('status', CouponUsage::STATUS_APPLIED)
                ->first();

            if (! $usage) {
                return false;
            }

            $usage->update([
                'status' => CouponUsage::STATUS_RELEASED,
                'released_at' => now(),
            ]);

            if ($usage->coupon_id) {
                Coupon::where('id', $usage->coupon_id)
                    ->where('used_count', '>', 0)
                    ->decrement('used_count');
            }

            return true;
        });
    }

    /**
     * Get remaining global usages for a coupon.
     */
    public function remainingUsage(Coupon $coupon): ?int
    {
        return $coupon->remainingUsage();
    }

    /**
     * Get remaining usages for a specific user.
     */
    public function remainingUsageForUser(Coupon $coupon, ?User $user): ?int
    {
        return $coupon->remainingUsageForUser($user);
    }
}
