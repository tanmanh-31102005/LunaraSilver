<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CouponUsage extends Model
{
    use HasFactory;

    public const STATUS_APPLIED = 'applied';

    public const STATUS_RELEASED = 'released';

    public const STATUS_LABELS = [
        self::STATUS_APPLIED => 'Đã áp dụng',
        self::STATUS_RELEASED => 'Đã hoàn lại',
    ];

    protected $fillable = [
        'coupon_id',
        'user_id',
        'order_id',
        'status',
        'used_at',
        'released_at',
    ];

    protected $casts = [
        'used_at' => 'datetime',
        'released_at' => 'datetime',
    ];

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function isApplied(): bool
    {
        return $this->status === self::STATUS_APPLIED;
    }

    public function isReleased(): bool
    {
        return $this->status === self::STATUS_RELEASED;
    }
}
