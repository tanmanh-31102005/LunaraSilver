<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use InvalidArgumentException;

class ProductImage extends Model
{
    public const ROLES = ['primary', 'hover', 'gallery'];

    protected $fillable = ['product_id', 'cloudinary_public_id', 'image_url', 'image_role', 'sort_order', 'alt_text'];

    protected $casts = ['sort_order' => 'integer'];

    protected static function booted(): void
    {
        static::saving(function (self $image): void {
            if (! in_array($image->image_role, self::ROLES, true)) {
                throw new InvalidArgumentException('Invalid image role.');
            }
        });
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Determine if this image is hosted on Cloudinary.
     */
    public function isCloudinary(): bool
    {
        return ! empty($this->cloudinary_public_id);
    }

    /**
     * Return the best available URL for this image.
     * Priority: Cloudinary secure URL -> local preview -> local media route -> placeholder.
     */
    public function displayUrl(?string $transformation = null): string
    {
        // 1. Cloudinary or absolute external URL
        if ($this->isCloudinary() || str_starts_with($this->image_url, 'https://') || str_starts_with($this->image_url, 'http://')) {
            if ($this->isCloudinary() && $transformation !== null && str_contains($this->image_url, '/upload/')) {
                return str_replace('/upload/', "/upload/{$transformation}/", $this->image_url);
            }

            return $this->image_url;
        }

        // 2. Local optimized preview (WebP)
        $preview = 'media-previews/'.sha1($this->image_url).'.webp';
        if (is_file(public_path($preview))) {
            return asset($preview);
        }

        // 3. Legacy local media route
        if (str_starts_with($this->image_url, 'media/')) {
            return route('media.show', ['path' => substr($this->image_url, strlen('media/'))]);
        }

        if (! empty($this->image_url)) {
            return route('media.show', ['path' => $this->image_url]);
        }

        // 4. Default placeholder fallback
        return route('media.show', ['path' => 'placeholder.png']);
    }
}
