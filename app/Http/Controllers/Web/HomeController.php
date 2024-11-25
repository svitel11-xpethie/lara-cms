<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Faq;
use App\Models\Gallery;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $gallery_images = Gallery::orderBy('order', 'ASC')->take(6)->get();

        $blog_posts = Blog::take(3)
            ->orderBy('id', 'DESC')
            ->get() // Fetch the collection first
            ->map(function ($blog) {
                $blog->description = strlen(strip_tags($blog->content)) > 150
                    ? substr(strip_tags($blog->content), 0, 150) . '...'
                    : strip_tags($blog->content);
                return $blog;
            });

        $services = Service::take(6)
            ->orderBy('order', 'ASC')
            ->get() // Fetch the collection first
            ->map(function ($blog) {
                $blog->description = strlen(strip_tags($blog->content)) > 150
                    ? substr(strip_tags($blog->content), 0, 150) . '...'
                    : strip_tags($blog->content);
                return $blog;
            });

        $testimonials = Testimonial::take(6)
            ->orderBy('order', 'ASC')
            ->get();


        $faqs = Faq::take(6)
            ->orderBy('order', 'ASC')
            ->get();

        return view('web.pages.home.index', [
            'gallery_images' => $gallery_images,
            'blog_posts' => $blog_posts,
            'services' => $services,
            'testimonials' => $testimonials,
            'faqs' => $faqs,
        ]);
    }
}
