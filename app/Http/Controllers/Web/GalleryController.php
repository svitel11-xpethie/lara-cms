<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $gallery_images = Gallery::orderBy('order', 'ASC')->get();
        $testimonials = Testimonial::take(6)
            ->orderBy('order', 'ASC')
            ->get();

        return view('web.pages.gallery.index', compact('gallery_images', 'testimonials'));
    }
}
