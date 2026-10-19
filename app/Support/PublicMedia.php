<?php

namespace App\Support;

class PublicMedia
{
    public static function url(?string $path): ?string
    {
        $path = self::normalize($path);

        if ($path === null) {
            return null;
        }

        self::publish($path);

        $file = public_path('storage/'.$path);
        $version = is_file($file) ? filemtime($file) : null;

        return url('storage/'.$path).($version ? '?v='.$version : '');
    }

    public static function publish(string $path): void
    {
        $path = self::normalize($path);

        if ($path === null) {
            return;
        }

        $target = public_path('storage/'.$path);

        if (is_file($target)) {
            return;
        }

        $source = storage_path('app/public/'.$path);

        if (! is_file($source)) {
            return;
        }

        $directory = dirname($target);

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        copy($source, $target);
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
