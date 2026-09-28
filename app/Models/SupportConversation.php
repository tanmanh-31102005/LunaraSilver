<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class SupportConversation extends Model
{
    use HasFactory;

    public const STATUS_OPEN = 'open';

    public const STATUS_ASSIGNED = 'assigned';

    public const STATUS_RESOLVED = 'resolved';

    public const STATUS_CLOSED = 'closed';

    public const STATUSES = [
        self::STATUS_OPEN,
        self::STATUS_ASSIGNED,
        self::STATUS_RESOLVED,
        self::STATUS_CLOSED,
    ];

    public const STATUS_LABELS = [
        self::STATUS_OPEN => 'Chờ hỗ trợ',
        self::STATUS_ASSIGNED => 'Đang trao đổi',
        self::STATUS_RESOLVED => 'Đã giải quyết',
        self::STATUS_CLOSED => 'Đã đóng',
    ];

    protected $fillable = [
        'reference',
        'user_id',
        'guest_token',
        'customer_name',
        'customer_email',
        'status',
        'assigned_to',
        'last_message_at',
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (SupportConversation $conversation) {
            if (empty($conversation->reference)) {
                $conversation->reference = static::generateReference();
            }
        });
    }

    public static function generateReference(): string
    {
        do {
            $ref = 'CHAT-'.now()->format('Ymd').'-'.strtoupper(Str::random(6));
        } while (static::where('reference', $ref)->exists());

        return $ref;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(SupportMessage::class, 'conversation_id');
    }

    public function unreadCustomerMessagesCount(): int
    {
        return $this->messages()
            ->where('sender_type', 'customer')
            ->whereNull('read_at')
            ->count();
    }

    public function unreadAdminMessagesCount(): int
    {
        return $this->messages()
            ->where('sender_type', 'admin')
            ->whereNull('read_at')
            ->count();
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->whereIn('status', [self::STATUS_OPEN, self::STATUS_ASSIGNED]);
    }
}
