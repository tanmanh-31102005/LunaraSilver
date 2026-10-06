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

        // If file not found directly, check alternative image extensions
        if (! $file || ! is_file($file)) {
            $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
            $baseWithoutExt = pathinfo($path, PATHINFO_DIRNAME) !== '.' 
                ? pathinfo($path, PATHINFO_DIRNAME).'/'.pathinfo($path, PATHINFO_FILENAME)
                : pathinfo($path, PATHINFO_FILENAME);

            $altExtensions = match ($ext) {
                'png' => ['jpg', 'jpeg', 'webp'],
                'jpg', 'jpeg' => ['png', 'webp'],
                default => ['jpg', 'png', 'webp'],
            };

            foreach ($altExtensions as $altExt) {
                $candidate = realpath(base_path('media/'.$baseWithoutExt.'.'.$altExt));
                if ($candidate && is_file($candidate)) {
                    $file = $candidate;
                    break;
                }
            }
        }

        // Preview fallback if exists
        if ((! $file || ! is_file($file))) {
            $preview = public_path('media-previews/'.sha1('media/'.$path).'.webp');
            if (is_file($preview)) {
                return response()->file($preview, ['Cache-Control' => 'public, max-age=86400']);
            }
        }

        abort_unless(
            $root && $file && str_starts_with($file, $root.DIRECTORY_SEPARATOR)
                && is_file($file) && in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'webp', 'svg', 'mp4'], true),
            Response::HTTP_NOT_FOUND,
        );

        return response()->file($file, ['Cache-Control' => 'public, max-age=86400']);
    }
}
