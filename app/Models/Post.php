<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    public const STATUS_DRAFT = 'draft';

    public const STATUS_PUBLISHED = 'published';

    protected $fillable = [
        'post_category_id',
        'author_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'image_url',
        'cover_image_url',
        'cloudinary_public_id',
        'is_published',
        'status',
        'is_featured',
        'reading_time_minutes',
        'seo_title',
        'seo_description',
        'published_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
        'reading_time_minutes' => 'integer',
    ];

    protected static function booted(): void
    {
        static::saving(function (self $post) {
            // Keep status and is_published in sync
            if ($post->status === self::STATUS_PUBLISHED) {
                $post->is_published = true;
                if (! $post->published_at) {
                    $post->published_at = now();
                }
            } elseif ($post->status === self::STATUS_DRAFT) {
                $post->is_published = false;
            }

            // Estimate reading time if not explicitly provided
            if (empty($post->reading_time_minutes) && ! empty($post->content)) {
                $wordCount = str_word_count(strip_tags($post->content));
                $post->reading_time_minutes = max(1, (int) ceil($wordCount / 200));
            }
        });
    }

    /**
     * Get route key name for implicit binding.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Category relation.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(PostCategory::class, 'post_category_id');
    }

    /**
     * Author relation.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Scope for published posts visible to public.
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where(function ($q) {
            $q->where('status', self::STATUS_PUBLISHED)
                ->orWhere('is_published', true);
        })->whereNotNull('published_at')->where('published_at', '<=', now());
    }

    /**
     * Scope for featured posts.
     */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope for search keyword.
     */
    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        $clean = trim((string) $term);
        if ($clean === '') {
            return $query;
        }

        return $query->where(function (Builder $sub) use ($clean) {
            $sub->where('title', 'like', "%{$clean}%")
                ->orWhere('excerpt', 'like', "%{$clean}%")
                ->orWhere('content', 'like', "%{$clean}%");
        });
    }

    /**
     * Accessor for cover image with real system media fallback.
     */
    public function getCoverImageAttribute(): string
    {
        $raw = $this->cover_image_url ?: $this->image_url;

        if (empty($raw)) {
            return route('media.show', ['path' => 'banner.jpg']);
        }

        if (str_starts_with($raw, 'http://') || str_starts_with($raw, 'https://')) {
            return $raw;
        }

        if (str_starts_with($raw, 'media-previews/')) {
            return asset($raw);
        }

        if (str_starts_with($raw, 'media/')) {
            $preview = 'media-previews/'.sha1($raw).'.webp';
            if (is_file(public_path($preview))) {
                return asset($preview);
            }

            $altRaw = str_ends_with($raw, '.png') 
                ? substr($raw, 0, -4).'.jpg' 
                : (str_ends_with($raw, '.jpg') ? substr($raw, 0, -4).'.png' : null);
            if ($altRaw) {
                $altPreview = 'media-previews/'.sha1($altRaw).'.webp';
                if (is_file(public_path($altPreview))) {
                    return asset($altPreview);
                }
            }

            return route('media.show', ['path' => substr($raw, strlen('media/'))]);
        }

        if (str_starts_with($raw, '/media/')) {
            return route('media.show', ['path' => substr($raw, strlen('/media/'))]);
        }

        if (str_starts_with($raw, 'storage/') || str_starts_with($raw, '/storage/')) {
            return asset(ltrim($raw, '/'));
        }

        if (file_exists(base_path('media/'.ltrim($raw, '/')))) {
            return route('media.show', ['path' => ltrim($raw, '/')]);
        }

        return route('media.show', ['path' => 'banner.jpg']);
    }

    /**
     * Reading time accessor.
     */
    public function getReadingTimeAttribute(): int
    {
        if ($this->reading_time_minutes && $this->reading_time_minutes > 0) {
            return $this->reading_time_minutes;
        }

        $wordCount = str_word_count(strip_tags((string) $this->content));

        return max(1, (int) ceil($wordCount / 200));
    }

    /**
     * Check if post is currently published and public.
     */
    public function isPublished(): bool
    {
        $statusOk = ($this->status === self::STATUS_PUBLISHED || $this->is_published);

        return $statusOk && $this->published_at !== null && $this->published_at->lte(now());
    }

    /**
     * Sanitize HTML content to prevent XSS while allowing editorial styling.
     */
    public static function sanitizeHtml(?string $html): string
    {
        if ($html === null || trim($html) === '') {
            return '';
        }

        // 1. Remove dangerous script and iframe tags completely along with content
        $cleaned = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $html);
        $cleaned = preg_replace('#<iframe(.*?)>(.*?)</iframe>#is', '', (string) $cleaned);
        $cleaned = preg_replace('#<style(.*?)>(.*?)</style>#is', '', (string) $cleaned);
        $cleaned = preg_replace('#<object(.*?)>(.*?)</object>#is', '', (string) $cleaned);
        $cleaned = preg_replace('#<embed(.*?)>(.*?)</embed>#is', '', (string) $cleaned);

        // 2. Remove inline event handlers (onclick, onload, onerror, etc.)
        $cleaned = preg_replace('/on[a-zA-Z]+\s*=\s*(["\']).*?\1/i', '', (string) $cleaned);
        $cleaned = preg_replace('/on[a-zA-Z]+\s*=\s*[^ >]+/i', '', (string) $cleaned);

        // 3. Remove javascript: pseudo-protocols
        $cleaned = preg_replace('/href\s*=\s*(["\'])\s*javascript:[^"\']*\1/i', 'href="#"', (string) $cleaned);
        $cleaned = preg_replace('/src\s*=\s*(["\'])\s*javascript:[^"\']*\1/i', 'src=""', (string) $cleaned);

        // 4. Allowed tags whitelist
        $allowedTags = '<p><h2><h3><h4><h5><h6><strong><b><em><i><u><s><ul><ol><li><a><blockquote><code><pre><hr><br><img><figure><figcaption><table><thead><tbody><tr><th><td><div><span>';

        return strip_tags((string) $cleaned, $allowedTags);
    }

    /**
     * Get safe sanitized content for blade rendering.
     */
    public function getSanitizedContentAttribute(): string
    {
        return self::sanitizeHtml($this->content);
    }
}
