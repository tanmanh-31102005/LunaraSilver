<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItemComponent extends Model
{
    protected $fillable = [
        'order_item_id',
        'product_id',
        'product_sku',
        'product_name',
        'quantity_per_item',
        'total_quantity',
    ];

    protected $casts = [
        'quantity_per_item' => 'integer',
        'total_quantity' => 'integer',
    ];

    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }
}
