<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PostCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Get route key name for implicit binding.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Posts associated with this category.
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'post_category_id');
    }

    /**
     * Published posts associated with this category.
     */
    public function publishedPosts(): HasMany
    {
        return $this->posts()->where(function ($q) {
            $q->where('status', 'published')
                ->orWhere('is_published', true);
        })->whereNotNull('published_at')->where('published_at', '<=', now());
    }

    /**
     * Scope active categories.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope ordered categories.
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('name', 'asc');
    }
}
