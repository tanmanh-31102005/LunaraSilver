<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'title', 'subtitle', 'image_url', 'cloudinary_public_id', 'button_text',
        'link', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];

    public function isCloudinary(): bool
    {
        return ! empty($this->cloudinary_public_id);
    }

    public function displayUrl(): string
    {
        if (! empty($this->image_url)) {
            if ($this->isCloudinary() || str_starts_with($this->image_url, 'http://') || str_starts_with($this->image_url, 'https://')) {
                return $this->image_url;
            }

            if (file_exists(public_path($this->image_url))) {
                return asset($this->image_url);
            }
        }

        return asset('media-previews/hero.webp');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('id', 'asc');
    }
}
