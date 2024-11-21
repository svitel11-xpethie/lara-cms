<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

class LogoService
{
    public static function upload(UploadedFile $image, $path)
    {
        return UploadService::handleImageUpload(
            image: $image,
            path: $path,
            convertTo: 'webp',
            resizeWidth: 300,
            resizeHeight: 300
        );
    }

    public static function delete($path)
    {
        if ($path && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}
