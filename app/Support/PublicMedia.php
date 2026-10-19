<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

class PublicMedia
{
    public static function url(?string $path): ?string
    {
        $path = self::normalize($path);

        if ($path === null) {
            return null;
        }

        $version = Storage::disk('public')->exists($path)
            ? Storage::disk('public')->lastModified($path)
            : null;

        return url('media/'.$path).($version ? '?v='.$version : '');
    }

    public static function normalize(?string $path): ?string
    {
        if (! is_string($path)) {
            return null;
        }

        $path = ltrim(str_replace('\\', '/', $path), '/');

        if ($path === '' || str_contains($path, '..') || str_contains($path, "\0")) {
            return null;
        }

        return $path;
    }
}
