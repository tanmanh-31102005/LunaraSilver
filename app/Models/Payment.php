<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use InvalidArgumentException;

class Payment extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_PAID = 'paid';
    public const STATUS_FAILED = 'failed';
    public const STATUS_CANCELLED = 'cancelled';
    public const STATUS_EXPIRED = 'expired';
    public const STATUS_REFUNDED = 'refunded';

    public const STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_PAID,
        self::STATUS_FAILED,
        self::STATUS_CANCELLED,
        self::STATUS_EXPIRED,
        self::STATUS_REFUNDED,
    ];

    public const STATUS_LABELS = [
        self::STATUS_PENDING => 'Chờ thanh toán',
        self::STATUS_PAID => 'Đã thanh toán',
        self::STATUS_FAILED => 'Thất bại',
        self::STATUS_CANCELLED => 'Đã hủy',
        self::STATUS_EXPIRED => 'Đã hết hạn',
        self::STATUS_REFUNDED => 'Đã hoàn tiền',
    ];

    protected $fillable = [
        'order_id',
        'provider',
        'transaction_id',
        'txn_ref',
        'vnp_transaction_no',
        'vnp_bank_code',
        'vnp_card_type',
        'vnp_pay_date',
        'vnp_create_date',
        'amount',
        'status',
        'request_data',
        'response_data',
        'paid_at',
        'last_queried_at',
        'query_count',
        'failure_reason',
    ];

    protected static function booted(): void
    {
        static::saving(function (self $payment): void {
            if (! in_array($payment->provider, Order::PAYMENT_METHODS, true)
                || ! in_array($payment->status ?? self::STATUS_PENDING, self::STATUSES, true)) {
                throw new InvalidArgumentException('Invalid payment provider or status.');
            }
        });
    }

    protected $casts = [
        'amount' => 'decimal:2',
        'request_data' => 'array',
        'response_data' => 'array',
        'paid_at' => 'datetime',
        'last_queried_at' => 'datetime',
        'query_count' => 'integer',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function refunds(): HasMany
    {
        return $this->hasMany(PaymentRefund::class)->orderBy('id', 'desc');
    }

    public function isPaid(): bool
    {
        return $this->status === self::STATUS_PAID;
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isFailed(): bool
    {
        return $this->status === self::STATUS_FAILED;
    }

    public function isCancelled(): bool
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    public function isExpired(): bool
    {
        return $this->status === self::STATUS_EXPIRED;
    }

    public function isVNPay(): bool
    {
        return $this->provider === 'vnpay';
    }

    /**
     * Check if payment attempt can be queried via QueryDr.
     * Only VNPay attempts with txn_ref and vnp_create_date can be queried.
     */
    public function canBeQueried(): bool
    {
        return $this->isVNPay()
            && ! empty($this->txn_ref)
            && ! empty($this->vnp_create_date);
    }

    /**
     * Total amount of successful refunds for this payment.
     */
    public function successfulRefundsAmount(): float
    {
        return (float) $this->refunds()
            ->where('status', PaymentRefund::STATUS_SUCCEEDED)
            ->sum('amount');
    }

    /**
     * Total amount of currently processing/requested refunds for this payment.
     */
    public function processingRefundsAmount(): float
    {
        return (float) $this->refunds()
            ->whereIn('status', [PaymentRefund::STATUS_REQUESTED, PaymentRefund::STATUS_PROCESSING])
            ->sum('amount');
    }

    /**
     * Remaining refundable amount (Paid - Successful - Processing).
     */
    public function remainingRefundableAmount(): float
    {
        if (! $this->isPaid()) {
            return 0.0;
        }

        $paid = (float) $this->amount;
        $refunded = $this->successfulRefundsAmount();
        $processing = $this->processingRefundsAmount();

        return max(0.0, round($paid - $refunded - $processing, 2));
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_LABELS[$this->status] ?? $this->status;
    }
}
