<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use InvalidArgumentException;

class BundleItem extends Pivot
{
    public $incrementing = true;

    protected $table = 'bundle_items';

    protected $fillable = ['bundle_product_id', 'component_product_id', 'quantity', 'sort_order'];

    protected $casts = ['quantity' => 'integer', 'sort_order' => 'integer'];

    protected static function booted(): void
    {
        static::saving(function (self $item): void {
            if ($item->bundle_product_id !== null
                && (int) $item->bundle_product_id === (int) $item->component_product_id) {
                throw new InvalidArgumentException('A bundle cannot contain itself.');
            }
        });
    }

    public function bundle(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'bundle_product_id');
    }

    public function component(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'component_product_id');
    }
}
