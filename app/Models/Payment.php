<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use InvalidArgumentException;

class Payment extends Model
{
    public const STATUSES = ['pending', 'paid', 'failed', 'cancelled', 'refunded'];

    protected $fillable = [
        'order_id', 'provider', 'transaction_id', 'amount', 'status', 'request_data', 'response_data', 'paid_at',
    ];

    protected static function booted(): void
    {
        static::saving(function (self $payment): void {
            if (! in_array($payment->provider, Order::PAYMENT_METHODS, true)
                || ! in_array($payment->status ?? 'pending', self::STATUSES, true)) {
                throw new InvalidArgumentException('Invalid payment provider or status.');
            }
        });
    }

    protected $casts = [
        'amount' => 'decimal:2',
        'request_data' => 'array',
        'response_data' => 'array',
        'paid_at' => 'datetime',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
