<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Intervention\Image\Laravel\Facades\Image;

// Correct Facade Import
use Illuminate\Support\Str;

class UploadService
{
    const IMAGES_PATH = '/assets/images/';

    public static function handleImageUpload(
        $image,
        $path,
        $convertTo = null,
        $quality = 80,
        $resizeWidth = null,
        $resizeHeight = null,
    )
    {
        // Get the file extension
        $extension = $image->getClientOriginalExtension();

        if ($extension !== 'svg') {
            if ($convertTo) {
                $extension = $convertTo;
            } else {
                $extension = $image->getClientOriginalExtension();
            }
        }

        $filename = time() . '_' . Str::random(10) . '.' . $extension;
        $destination = public_path(self::IMAGES_PATH . $path);

        // Ensure directory exists
        if (!is_dir($destination)) {
            mkdir($destination, 0755, true);
        }


        if ($extension === 'svg') {
            // Save original format for svg
            File::copy($image->getRealPath(), $destination . '/' . $filename);
            return self::IMAGES_PATH . $path . '/' . $filename;
        }


        // Process and save as WebP for other formats
        $imageInstance = Image::read($image->getRealPath());

        if (in_array($extension, ['svg', 'ico', 'png'])) {
            // Save original format for svg, ico, and png
            $imageInstance->save($destination . '/' . $filename);
        } else {
            // image is landscape
            $is_landscape = $imageInstance->width() > $imageInstance->height();

            if ($is_landscape && $resizeHeight) {
                $imageInstance->scale(null, $resizeHeight);
            } else if ($resizeWidth) {
                $imageInstance->scale($resizeWidth, null);
            }

            if ($convertTo) {
                if ($convertTo === 'webp') {
                    $imageInstance->toWebp();
                }

                if ($convertTo === 'jpg') {
                    $imageInstance->toJpeg();
                }

                if ($convertTo === 'png') {
                    $imageInstance->toPng();
                }

                if ($convertTo === 'gif') {
                    $imageInstance->toGif();
                }

                if ($convertTo === 'bmp') {
                    $imageInstance->toBmp();
                }

                if ($convertTo === 'tiff') {
                    $imageInstance->toTiff();
                }
            }

            $imageInstance->save($destination . '/' . $filename, $quality);
        }

        return self::IMAGES_PATH . $path . '/' . $filename;
    }
}
