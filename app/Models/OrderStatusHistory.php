<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderStatusHistory extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'from_status',
        'to_status',
        'changed_by',
        'note',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function changedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by');
    }

    public function getFromStatusLabelAttribute(): string
    {
        return $this->from_status ? (Order::STATUS_LABELS[$this->from_status] ?? $this->from_status) : 'Khởi tạo';
    }

    public function getToStatusLabelAttribute(): string
    {
        return Order::STATUS_LABELS[$this->to_status] ?? $this->to_status;
    }
}
