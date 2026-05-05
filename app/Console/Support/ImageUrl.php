<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

class ImageUrl
{
    public static function make(?string $path, string $fallback = 'placeholder.png'): string
    {
        if (!$path) {
            return asset($fallback);
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return Storage::disk('s3')->url($path);
    }
}