<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver as GdDriver; // GD Driver
use Intervention\Image\Drivers\Imagick\Driver as ImagickDriver; // Imagick Driver

class BlogController extends Controller
{
    protected $imageManager;

    public function __construct()
    {
        $this->imageManager = new ImageManager(new GdDriver());
    }

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
        $data['slug'] = \Str::slug($request->title);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $data['image'] = $this->handleImageUpload($image, 'blogs');
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
            $data['image'] = $this->handleImageUpload($image, 'blogs');
            $data['image_thumb'] = $this->handleImageUpload($image, 'blogs/thumbs', 300);
        }

        $blog->update($data);
        return redirect()->route('blogs.index')->with('success', 'Blog updated successfully!');
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();
        return redirect()->route('blogs.index')->with('success', 'Blog deleted successfully!');
    }

    private function handleImageUpload($image, $path)
    {
        $filename = time() . '.' . $image->getClientOriginalExtension();
        $destination = public_path('uploads/' . $path);

        if (!is_dir($destination)) {
            mkdir($destination, 0755, true);
        }

        $this->imageManager->make($image->getRealPath())
            ->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->save($destination . '/' . $filename);

        return 'uploads/' . $path . '/' . $filename;
    }
}
