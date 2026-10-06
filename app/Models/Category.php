<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'parent_id', 'name', 'slug', 'description', 'is_active', 'sort_order',
        'seo_title', 'seo_description', 'seo_intro',
    ];

    protected $casts = ['is_active' => 'boolean', 'sort_order' => 'integer'];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get rich SEO display name with silver terminology.
     */
    public function getSeoDisplayNameAttribute(): string
    {
        return match ($this->slug) {
            'day-chuyen' => 'Dây chuyền bạc',
            'nhan' => 'Nhẫn bạc 925 & Nhẫn đôi',
            'vong-tay' => 'Vòng tay & Lắc tay bạc',
            'bo-trang-suc' => 'Bộ trang sức bạc 925',
            'set-qua-tang' => 'Set quà tặng trang sức bạc',
            default => str_contains(mb_strtolower($this->name), 'bạc') ? $this->name : $this->name.' Bạc',
        };
    }

    /**
     * Get popular SEO keywords for this category.
     */
    public function getPopularKeywordsAttribute(): array
    {
        return match ($this->slug) {
            'day-chuyen' => ['dây chuyền bạc', 'dây chuyền bạc nữ', 'dây chuyền bạc 925', 'dây chuyền bạc nam', 'dây chuyền bạc nữ sợi nhỏ'],
            'nhan' => ['nhẫn bạc', 'nhẫn bạc 925', 'nhẫn bạc nữ', 'nhẫn bạc đôi', 'nhẫn cặp bạc', 'nhẫn bạc nam'],
            'vong-tay' => ['vòng tay bạc', 'vòng tay bạc nữ đẹp', 'lắc tay bạc', 'lắc chân bạc nữ', 'vòng bạc đôi', 'lắc tay nam bạc'],
            'bo-trang-suc' => ['bộ trang sức bạc', 'bộ trang sức bạc nữ', 'bộ trang sức bạc 925 cao cấp', 'trang sức bạc top 1'],
            'set-qua-tang' => ['set quà tặng trang sức bạc', 'quà tặng bạc 925', 'hộp quà tặng trang sức'],
            default => ['trang sức bạc 925'],
        };
    }
}
