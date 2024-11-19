<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Gallery;
use App\Models\Service;
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
            ->orderBy('id', 'DESC')
            ->get() // Fetch the collection first
            ->map(function ($blog) {
                $blog->description = strlen(strip_tags($blog->content)) > 150
                    ? substr(strip_tags($blog->content), 0, 150) . '...'
                    : strip_tags($blog->content);
                return $blog;
            });

        return view('web.pages.home.index', [
            'gallery_images' => $gallery_images,
            'blog_posts' => $blog_posts,
            'services' => $services,
        ]);
    }
}
