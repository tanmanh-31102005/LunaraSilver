<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Coupon extends Model
{
    use HasFactory;

    public const TYPE_FIXED = 'fixed';

    public const TYPE_PERCENTAGE = 'percentage';

    public const TYPES = [
        self::TYPE_FIXED,
        self::TYPE_PERCENTAGE,
    ];

    public const TYPE_LABELS = [
        self::TYPE_FIXED => 'Số tiền cố định',
        self::TYPE_PERCENTAGE => 'Phần trăm (%)',
    ];

    protected $fillable = [
        'code',
        'type',
        'value',
        'minimum_order',
        'maximum_discount',
        'starts_at',
        'expires_at',
        'usage_limit',
        'usage_limit_per_user',
        'used_count',
        'is_active',
        'is_first_order_only',
        'applicable_categories',
        'applicable_products',
        'applicable_customer_ids',
        'applicable_customer_emails',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'minimum_order' => 'decimal:2',
        'maximum_discount' => 'decimal:2',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'usage_limit' => 'integer',
        'usage_limit_per_user' => 'integer',
        'used_count' => 'integer',
        'is_active' => 'boolean',
        'is_first_order_only' => 'boolean',
        'applicable_categories' => 'array',
        'applicable_products' => 'array',
        'applicable_customer_ids' => 'array',
        'applicable_customer_emails' => 'array',
    ];

    protected function code(): Attribute
    {
        return Attribute::make(
            set: fn (?string $value) => $value ? strtoupper(trim($value)) : null,
        );
    }

    protected function minOrderAmount(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->minimum_order,
            set: fn ($value) => ['minimum_order' => $value],
        );
    }

    protected function maxDiscountAmount(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->maximum_discount,
            set: fn ($value) => ['maximum_discount' => $value],
        );
    }

    public function usages(): HasMany
    {
        return $this->hasMany(CouponUsage::class);
    }

    public function activeUsages(): HasMany
    {
        return $this->hasMany(CouponUsage::class)->where('status', CouponUsage::STATUS_APPLIED);
    }

    public function isExpired(): bool
    {
        return $this->expires_at !== null && now()->gt($this->expires_at);
    }

    public function hasStarted(): bool
    {
        return $this->starts_at === null || now()->gte($this->starts_at);
    }

    public function isUsageLimitReached(): bool
    {
        return $this->usage_limit !== null && $this->used_count >= $this->usage_limit;
    }

    public function remainingUsage(): ?int
    {
        if ($this->usage_limit === null) {
            return null;
        }

        return max(0, $this->usage_limit - $this->used_count);
    }

    public function remainingUsageForUser(?User $user): ?int
    {
        if ($this->usage_limit_per_user === null) {
            return null;
        }

        if (! $user) {
            return $this->usage_limit_per_user;
        }

        $usedByUser = $this->activeUsages()
            ->where('user_id', $user->id)
            ->count();

        return max(0, $this->usage_limit_per_user - $usedByUser);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function isFirstOrderOnly(): bool
    {
        return (bool) $this->is_first_order_only;
    }

    public function hasProductOrCategoryRestrictions(): bool
    {
        return ! empty($this->applicable_categories) || ! empty($this->applicable_products);
    }

    public function hasCustomerRestrictions(): bool
    {
        return ! empty($this->applicable_customer_ids) || ! empty($this->applicable_customer_emails);
    }

    public function appliesToProduct(int $productId, ?int $categoryId = null): bool
    {
        if (! $this->hasProductOrCategoryRestrictions()) {
            return true;
        }

        if (! empty($this->applicable_products) && in_array($productId, $this->applicable_products, true)) {
            return true;
        }

        if ($categoryId && ! empty($this->applicable_categories) && in_array($categoryId, $this->applicable_categories, true)) {
            return true;
        }

        return false;
    }

    public function appliesToCustomer(?User $user = null, ?string $email = null): bool
    {
        if (! $this->hasCustomerRestrictions()) {
            return true;
        }

        if ($user && ! empty($this->applicable_customer_ids) && in_array($user->id, $this->applicable_customer_ids, true)) {
            return true;
        }

        $checkEmail = strtolower(trim((string) ($email ?? $user?->email)));
        if ($checkEmail !== '' && ! empty($this->applicable_customer_emails)) {
            $allowedEmails = array_map('strtolower', array_map('trim', $this->applicable_customer_emails));
            if (in_array($checkEmail, $allowedEmails, true)) {
                return true;
            }
        }

        return false;
    }
}
