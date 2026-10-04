<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use InvalidArgumentException;

class Review extends Model
{
    public const STATUSES = ['pending', 'approved', 'rejected'];

    protected $fillable = [
        'user_id',
        'product_id',
        'order_item_id',
        'rating',
        'title',
        'content',
        'comment',
        'status',
        'verified_purchase',
        'admin_reply',
        'admin_replied_at',
        'admin_replied_by',
        'rejection_reason',
    ];

    protected $casts = [
        'rating' => 'integer',
        'verified_purchase' => 'boolean',
        'admin_replied_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::saving(function (self $review): void {
            if ($review->rating < 1 || $review->rating > 5
                || ! in_array($review->status ?? 'pending', self::STATUSES, true)) {
                throw new InvalidArgumentException('Invalid review rating or status.');
            }

            // Sync content and comment if one is provided
            if (empty($review->content) && ! empty($review->comment)) {
                $review->content = $review->comment;
            } elseif (! empty($review->content) && empty($review->comment)) {
                $review->comment = $review->content;
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function repliedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_replied_by');
    }

    public function media(): HasMany
    {
        return $this->hasMany(ReviewMedia::class)->orderBy('sort_order');
    }

    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', 'approved');
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    public function scopeRejected(Builder $query): Builder
    {
        return $query->where('status', 'rejected');
    }

    public function scopeVerified(Builder $query): Builder
    {
        return $query->where('verified_purchase', true);
    }

    /**
     * Get privacy-masked display name (e.g. "Nguyễn M." or "Mạnh N."). Never exposes email.
     */
    public function getMaskedUserNameAttribute(): string
    {
        $rawName = trim((string) ($this->user?->name ?? ''));

        if ($rawName === '') {
            return 'Khách hàng Lunara';
        }

        $parts = preg_split('/\s+/u', $rawName);
        if (count($parts) <= 1) {
            $single = $parts[0];
            if (mb_strlen($single) <= 2) {
                return $single.'*';
            }

            return mb_substr($single, 0, 1).str_repeat('*', max(1, mb_strlen($single) - 2)).mb_substr($single, -1);
        }

        $first = $parts[0];
        $lastInitial = mb_strtoupper(mb_substr(end($parts), 0, 1));

        return $first.' '.$lastInitial.'.';
    }

    public function getEffectiveContentAttribute(): string
    {
        return (string) ($this->content ?: $this->comment ?: '');
    }
}
