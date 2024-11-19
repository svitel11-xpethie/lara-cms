<?php

namespace App\Services;

use Intervention\Image\Laravel\Facades\Image as ImageIntervention;


class Image
{
    public static function getOrientation($image)
    {
        $imageInstance = ImageIntervention::read($image->getRealPath());
        return $imageInstance->width() > $imageInstance->height() ? 'landscape' : 'portrait';
    }
}
