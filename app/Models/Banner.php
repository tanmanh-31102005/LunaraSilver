<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'title', 'subtitle', 'image_url', 'cloudinary_public_id', 'button_text',
        'link', 'sort_order', 'is_active',
    ];

    protected $casts = ['sort_order' => 'integer', 'is_active' => 'boolean'];
}
