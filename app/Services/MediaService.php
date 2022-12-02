<?php

namespace App\Services;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class MediaService
{
    public function storeFile($base64, $directory = 'uploads'): string
    {
        $timestamp = Carbon::now()->timestamp;
        $extension = explode(';base64', $base64);
        $extension = explode('/', $extension[0])[1];
        $replace = substr($base64, 0, strpos($base64, ',') + 1);
        $file = str_replace($replace, '', $base64);
        $file = str_replace(' ', '+', $file);
        $filename = "{$timestamp}.{$extension}";
        Storage::disk('public')->put("{$directory}/{$filename}", base64_decode($file));

        return "{$directory}/{$filename}";
    }

    public function deleteMedia($path): void
    {
        $fullPath = "app/public/{$path}";
        unlink(storage_path($fullPath));
    }
}