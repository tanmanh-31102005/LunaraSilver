<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    protected $fillable = [
        'post_category_id', 'title', 'slug', 'excerpt', 'content', 'image_url', 'is_published', 'published_at',
    ];

    protected $casts = ['is_published' => 'boolean', 'published_at' => 'datetime'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(PostCategory::class, 'post_category_id');
    }
}
