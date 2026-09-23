<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use InvalidArgumentException;

class Review extends Model
{
    public const STATUSES = ['pending', 'approved', 'rejected'];

    protected $fillable = ['user_id', 'product_id', 'rating', 'comment', 'status'];

    protected $casts = ['rating' => 'integer'];

    protected static function booted(): void
    {
        static::saving(function (self $review): void {
            if ($review->rating < 1 || $review->rating > 5
                || ! in_array($review->status ?? 'pending', self::STATUSES, true)) {
                throw new InvalidArgumentException('Invalid review rating or status.');
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
}
