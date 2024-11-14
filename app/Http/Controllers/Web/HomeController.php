<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $gallery_images = [
            ['src' => '/images/gallery/image1.jpg', 'thumbnail' => '/images/gallery/thumb1.jpg', 'caption' => 'Caption 1'],
            ['src' => '/images/gallery/image2.jpg', 'thumbnail' => '/images/gallery/thumb2.jpg', 'caption' => 'Caption 2'],
            ['src' => '/images/gallery/image3.jpg', 'thumbnail' => '/images/gallery/thumb3.jpg', 'caption' => 'Caption 3'],
        ];

        return view('web.pages.home.index', [
            'gallery_images' => $gallery_images
        ]);
    }
}
