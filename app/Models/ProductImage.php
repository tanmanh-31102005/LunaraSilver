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

    public function displayUrl(): string
    {
        if (str_starts_with($this->image_url, 'https://') || str_starts_with($this->image_url, 'http://')) {
            return $this->image_url;
        }

        $preview = 'media-previews/'.sha1($this->image_url).'.webp';
        if (is_file(public_path($preview))) {
            return asset($preview);
        }

        return route('media.show', ['path' => substr($this->image_url, strlen('media/'))]);
    }
}
