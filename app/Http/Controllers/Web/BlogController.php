<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        return view('web.pages.blogs.index', []);
    }


    public function show($id, $slug)
    {
        return view('web.pages.blogs.blog.index', []);
    }
}
