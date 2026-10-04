<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use InvalidArgumentException;

class Order extends Model
{
    public const STATUS_PENDING = 'pending';

    public const STATUS_CONFIRMED = 'confirmed';

    public const STATUS_PROCESSING = 'processing';

    public const STATUS_SHIPPING = 'shipping';

    public const STATUS_COMPLETED = 'completed';

    public const STATUS_CANCELLED = 'cancelled';

    public const STATUSES = ['pending', 'confirmed', 'processing', 'shipping', 'completed', 'cancelled'];

    public const PAYMENT_STATUSES = ['pending', 'paid', 'failed', 'cancelled', 'refund_pending', 'partially_refunded', 'refunded'];

    public const PAYMENT_METHODS = ['cod', 'bank_transfer', 'vnpay'];

    public const STATUS_LABELS = [
        'pending' => 'Chờ xác nhận',
        'confirmed' => 'Đã xác nhận',
        'processing' => 'Đang xử lý',
        'shipping' => 'Đang giao hàng',
        'completed' => 'Hoàn thành',
        'cancelled' => 'Đã hủy',
    ];

    public const PAYMENT_STATUS_LABELS = [
        'pending' => 'Chờ thanh toán',
        'paid' => 'Đã thanh toán',
        'failed' => 'Thanh toán thất bại',
        'cancelled' => 'Đã hủy',
        'refund_pending' => 'Chờ hoàn tiền',
        'partially_refunded' => 'Hoàn tiền một phần',
        'refunded' => 'Đã hoàn tiền',
    ];

    protected $fillable = [
        'user_id', 'order_code', 'customer_name', 'customer_email', 'customer_phone',
        'shipping_address', 'shipping_city', 'shipping_note', 'shipping_method',
        'subtotal', 'coupon_code', 'discount_amount', 'shipping_fee', 'grand_total',
        'payment_method', 'payment_status', 'order_status', 'inventory_restored_at',
        'customer_note', 'placed_at',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'shipping_fee' => 'decimal:2',
        'grand_total' => 'decimal:2',
        'placed_at' => 'datetime',
        'inventory_restored_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::saving(function (self $order): void {
            if (! in_array($order->payment_method, self::PAYMENT_METHODS, true)
                || ! in_array($order->payment_status ?? 'pending', self::PAYMENT_STATUSES, true)
                || ! in_array($order->order_status ?? 'pending', self::STATUSES, true)) {
                throw new InvalidArgumentException('Invalid order or payment status.');
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class)->orderBy('id', 'desc');
    }

    public function latestPayment(): HasOne
    {
        return $this->hasOne(Payment::class)->latestOfMany();
    }

    public function payment(): HasOne
    {
        return $this->latestPayment();
    }

    public function refunds(): HasMany
    {
        return $this->hasMany(PaymentRefund::class)->orderBy('id', 'desc');
    }

    public function statusHistories(): HasMany
    {
        return $this->hasMany(OrderStatusHistory::class)->orderBy('id', 'desc');
    }

    public function couponUsage(): HasOne
    {
        return $this->hasOne(CouponUsage::class);
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class, 'coupon_code', 'code');
    }

    public function isCancellable(): bool
    {
        return in_array($this->order_status, ['pending', 'confirmed', 'processing'], true);
    }

    public function canRetryPayment(): bool
    {
        return $this->payment_method === 'vnpay'
            && ! in_array($this->order_status, ['cancelled', 'completed'], true)
            && in_array($this->payment_status, ['pending', 'failed'], true);
    }

    public function canRefund(): bool
    {
        return $this->payment_method === 'vnpay'
            && in_array($this->payment_status, ['paid', 'partially_refunded', 'refund_pending'], true)
            && $this->remainingRefundableAmount() > 0;
    }

    public function remainingRefundableAmount(): float
    {
        $paid = (float) $this->payments()->where('status', Payment::STATUS_PAID)->sum('amount');
        if ($paid <= 0 && $this->payment_status === 'paid') {
            $paid = (float) $this->grand_total;
        }

        $succeededRefunds = (float) $this->refunds()
            ->where('status', PaymentRefund::STATUS_SUCCEEDED)
            ->sum('amount');
        $processingRefunds = (float) $this->refunds()
            ->whereIn('status', [PaymentRefund::STATUS_REQUESTED, PaymentRefund::STATUS_PROCESSING])
            ->sum('amount');

        return max(0.0, round($paid - $succeededRefunds - $processingRefunds, 2));
    }

    public function getOrderStatusLabelAttribute(): string
    {
        return match ($this->order_status) {
            'pending' => 'Chờ xác nhận',
            'confirmed' => 'Đã xác nhận',
            'processing' => 'Đang xử lý',
            'shipping' => 'Đang giao hàng',
            'completed' => 'Hoàn thành',
            'cancelled' => 'Đã hủy',
            default => $this->order_status ?? 'Chờ xác nhận',
        };
    }

    public function getPaymentStatusLabelAttribute(): string
    {
        return match ($this->payment_status) {
            'pending' => 'Chờ thanh toán',
            'paid' => 'Đã thanh toán',
            'failed' => 'Thanh toán thất bại',
            'cancelled' => 'Đã hủy',
            'refund_pending' => 'Chờ hoàn tiền',
            'partially_refunded' => 'Hoàn tiền một phần',
            'refunded' => 'Đã hoàn tiền',
            default => $this->payment_status ?? 'Chờ thanh toán',
        };
    }

    public function getPaymentMethodLabelAttribute(): string
    {
        return match ($this->payment_method) {
            'cod' => 'Thanh toán khi nhận hàng (COD)',
            'vnpay' => 'VNPay',
            'bank_transfer' => 'Chuyển khoản',
            default => $this->payment_method ?? 'COD',
        };
    }

    public function getSubtotalDisplayAttribute(): string
    {
        return number_format((float) $this->subtotal, 0, ',', '.').' ₫';
    }

    public function getDiscountAmountDisplayAttribute(): string
    {
        return '-'.number_format((float) $this->discount_amount, 0, ',', '.').' ₫';
    }

    public function getShippingFeeDisplayAttribute(): string
    {
        return number_format((float) $this->shipping_fee, 0, ',', '.').' ₫';
    }

    public function getGrandTotalDisplayAttribute(): string
    {
        return number_format((float) $this->grand_total, 0, ',', '.').' ₫';
    }
}
