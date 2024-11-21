<?php

namespace App\Services;

use Intervention\Image\Laravel\Facades\Image as ImageIntervention;


class ImageService
{
    public static function getOrientation($image)
    {
        $imageInstance = ImageIntervention::read($image->getRealPath());
        return $imageInstance->width() > $imageInstance->height() ? 'landscape' : 'portrait';
    }
}
