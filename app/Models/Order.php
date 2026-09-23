<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use InvalidArgumentException;

class Order extends Model
{
    public const STATUSES = ['pending', 'confirmed', 'processing', 'shipping', 'completed', 'cancelled'];

    public const PAYMENT_STATUSES = ['pending', 'paid', 'failed', 'cancelled', 'refunded'];

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
        'refunded' => 'Đã hoàn tiền',
    ];

    protected $fillable = [
        'user_id', 'order_code', 'customer_name', 'customer_email', 'customer_phone',
        'shipping_address', 'shipping_city', 'shipping_note', 'shipping_method',
        'subtotal', 'discount_amount', 'shipping_fee', 'grand_total',
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

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function statusHistories(): HasMany
    {
        return $this->hasMany(OrderStatusHistory::class)->orderBy('id', 'desc');
    }

    public function isCancellable(): bool
    {
        return in_array($this->order_status, ['pending', 'confirmed', 'processing'], true);
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
}
