<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentRefund extends Model
{
    public const STATUS_REQUESTED = 'requested';

    public const STATUS_PROCESSING = 'processing';

    public const STATUS_SUCCEEDED = 'succeeded';

    public const STATUS_FAILED = 'failed';

    public const STATUS_REJECTED = 'rejected';

    public const STATUSES = [
        self::STATUS_REQUESTED,
        self::STATUS_PROCESSING,
        self::STATUS_SUCCEEDED,
        self::STATUS_FAILED,
        self::STATUS_REJECTED,
    ];

    public const TYPE_FULL = 'full';

    public const TYPE_PARTIAL = 'partial';

    public const TYPES = [
        self::TYPE_FULL,
        self::TYPE_PARTIAL,
    ];

    public const STATUS_LABELS = [
        self::STATUS_REQUESTED => 'Đang yêu cầu',
        self::STATUS_PROCESSING => 'Đang xử lý tại ngân hàng',
        self::STATUS_SUCCEEDED => 'Hoàn tiền thành công',
        self::STATUS_FAILED => 'Hoàn tiền thất bại',
        self::STATUS_REJECTED => 'Bị từ chối hoàn tiền',
    ];

    protected $fillable = [
        'payment_id',
        'order_id',
        'request_id',
        'refund_type',
        'amount',
        'status',
        'reason',
        'requested_by',
        'vnp_transaction_no',
        'vnp_response_code',
        'vnp_transaction_status',
        'request_payload',
        'response_payload',
        'requested_at',
        'processed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'request_payload' => 'array',
        'response_payload' => 'array',
        'requested_at' => 'datetime',
        'processed_at' => 'datetime',
    ];

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function isSuccessful(): bool
    {
        return $this->status === self::STATUS_SUCCEEDED;
    }

    public function isProcessing(): bool
    {
        return in_array($this->status, [self::STATUS_REQUESTED, self::STATUS_PROCESSING], true);
    }

    public function isFailed(): bool
    {
        return in_array($this->status, [self::STATUS_FAILED, self::STATUS_REJECTED], true);
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_LABELS[$this->status] ?? $this->status;
    }

    public function getTypeLabelAttribute(): string
    {
        return match ($this->refund_type) {
            self::TYPE_FULL => 'Hoàn toàn bộ',
            self::TYPE_PARTIAL => 'Hoàn một phần',
            default => $this->refund_type,
        };
    }
}
