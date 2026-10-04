<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoRedirect extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'old_path',
        'new_path',
        'status_code',
        'created_at',
    ];

    protected $casts = [
        'status_code' => 'integer',
        'created_at' => 'datetime',
    ];

    /**
     * Normalize a path for redirect storage and lookup.
     */
    public static function normalizePath(string $path): string
    {
        $parsed = parse_url($path, PHP_URL_PATH) ?? $path;
        $clean = '/'.ltrim(rtrim($parsed, '/'), '/');

        return $clean === '' ? '/' : $clean;
    }

    /**
     * Register a 301 redirect with loop prevention and chain collapsing.
     */
    public static function registerRedirect(string $oldPath, string $newPath, int $statusCode = 301): ?self
    {
        $normalizedOld = self::normalizePath($oldPath);
        $normalizedNew = self::normalizePath($newPath);

        // Safety 1: Never redirect to oneself
        if ($normalizedOld === $normalizedNew) {
            return null;
        }

        // Safety 2: Loop prevention (A -> B while B -> A exists)
        // If there is an existing redirect from new to old, remove it to prevent endless loop
        self::query()->where('old_path', $normalizedNew)->where('new_path', $normalizedOld)->delete();

        // Safety 3: Chain collapsing (If A -> B existed, and now B -> C is added, update A -> C)
        self::query()
            ->where('new_path', $normalizedOld)
            ->where('old_path', '!=', $normalizedNew)
            ->update(['new_path' => $normalizedNew, 'status_code' => $statusCode]);

        // Upsert the redirect from old to new
        return self::query()->updateOrCreate(
            ['old_path' => $normalizedOld],
            [
                'new_path' => $normalizedNew,
                'status_code' => $statusCode,
                'created_at' => now(),
            ]
        );
    }
}
