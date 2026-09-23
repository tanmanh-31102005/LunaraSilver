<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class MediaController extends Controller
{
    public function __invoke(string $path): BinaryFileResponse
    {
        $root = realpath(base_path('media'));
        $file = realpath(base_path('media/'.$path));

        abort_unless(
            $root && $file && str_starts_with($file, $root.DIRECTORY_SEPARATOR)
                && is_file($file) && in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'webp', 'svg'], true),
            Response::HTTP_NOT_FOUND,
        );

        return response()->file($file, ['Cache-Control' => 'public, max-age=86400']);
    }
}
