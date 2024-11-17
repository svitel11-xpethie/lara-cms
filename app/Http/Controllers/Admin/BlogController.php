<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use App\Services\Upload;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::orderBy('order')->get();
        return inertia('Blogs/Index', compact('blogs'));
    }

    public function create()
    {
        return inertia('Blogs/Create');
    }

    public function store(BlogRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($request->title);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $data['image'] = Upload::handleImageUpload(image:$image, path:'blogs/full', convertTo: 'webp');
            $data['image_thumb'] = Upload::handleImageUpload(image:$image, path: 'blogs/thumbs', convertTo: 'webp', resizeWidth: 300);
        }

        Blog::create($data);
        return redirect()->route('admin.blogs.index')->with('success', 'Blog created successfully!');
    }

    public function edit(Blog $blog)
    {
        return inertia('Blogs/Edit', compact('blog'));
    }

    public function update(BlogRequest $request, Blog $blog)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $data['image'] = Upload::handleImageUpload(image:$image, path:'blogs/full', convertTo: 'webp');
            $data['image_thumb'] = Upload::handleImageUpload(image:$image, path: 'blogs/thumbs', convertTo: 'webp', resizeWidth: 300);

            // Delete old images if they exist
            if ($blog->image && file_exists(public_path($blog->image))) {
                unlink(public_path($blog->image));
                unlink(public_path($blog->image_thumb));
            }
        }

        $blog->update($data);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog updated successfully!');
    }



    public function destroy(Blog $blog)
    {
        $blog->delete();
        //return redirect()->route('admin.blogs.index')->with('success', 'Blog deleted successfully!');
    }


    /*public function generateMetaFromContent($content)
    {
        // Extract meta description
        $metaDescription = substr(strip_tags($content), 0, 150) . '...';

        // Extract simple keywords
        $words = array_count_values(str_word_count(strip_tags($content), 1));
        arsort($words);
        $keywords = implode(', ', array_slice(array_keys($words), 0, 10));

        return [
            'seo_title' => substr($content, 0, 60),
            'seo_description' => $metaDescription,
            'keywords' => $keywords,
        ];
    }*/
}
