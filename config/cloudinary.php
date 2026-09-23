<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Cloudinary Configuration
    |--------------------------------------------------------------------------
    |
    | Credentials and default settings for Cloudinary image management.
    |
    */

    'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
    'api_key' => env('CLOUDINARY_API_KEY'),
    'api_secret' => env('CLOUDINARY_API_SECRET'),
    'secure' => (bool) env('CLOUDINARY_SECURE', true),
    'folder_prefix' => env('CLOUDINARY_FOLDER_PREFIX', 'lunara'),
];
