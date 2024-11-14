<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $gallery_images = [
            ['src' => '/assets/images/gallery/full/image1.jpg', 'thumb' => '/assets/images/gallery/thumb/image1.jpg', 'caption' => 'Caption 1', 'width' => 1400, 'height' => 800],
            ['src' => '/assets/images/gallery/full/image2.jpg', 'thumb' => '/assets/images/gallery/thumb/image2.jpg', 'caption' => 'Caption 2', 'width' => 1400, 'height' => 800],
            ['src' => '/assets/images/gallery/full/image3.jpg', 'thumb' => '/assets/images/gallery/thumb/image3.jpg', 'caption' => 'Caption 3', 'width' => 1400, 'height' => 800],
        ];

        return view('web.pages.home.index', [
            'gallery_images' => $gallery_images
        ]);
    }
}
