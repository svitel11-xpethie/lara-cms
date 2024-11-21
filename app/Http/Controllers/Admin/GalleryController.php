<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\GalleryRequest;
use App\Http\Resources\GalleryCollection;
use App\Models\Gallery;
use App\Services\UploadService;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        return inertia('Gallery/Index');
    }

    public function images()
    {
        $galleries = Gallery::orderBy('order')->get();
        return GalleryCollection::collection($galleries);
    }

    public function create()
    {
        return inertia('Gallery/Create');
    }

    public function show(Gallery $gallery)
    {
        return inertia('Gallery/Show', [
            'gallery' => $gallery,
        ]);
    }

    public function store(GalleryRequest $request)
    {
        try {
            $data = $request->validated();
            $image = $request->file('image');

            // Handle Image Upload
            $data['image'] = UploadService::handleImageUpload(
                image: $image,
                path: 'galleries/full',
                convertTo: 'webp',
                resizeWidth: 1500,
                resizeHeight: 1500,
            );
            $data['image_thumb'] = UploadService::handleImageUpload(
                image: $image,
                path: 'galleries/thumb',
                convertTo: 'webp',
                resizeWidth: 300,
                resizeHeight: 300,
            );
            $data['orientation'] = \App\Services\ImageService::getOrientation($image);

            // add height and width to the data
            list($width, $height) = getimagesize(public_path($data['image']));
            $data['width'] = $width;
            $data['height'] = $height;

            Gallery::create($data);

            return response()->json([
                'message' => 'Image uploaded successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }

    }

    public function updateOrder(Request $request)
    {
        $order = $request->input('order');
        foreach ($order as $position => $id) {
            Gallery::where('id', $id)->update(['order' => $position]);
        }

        return response()->json(['message' => 'Order updated successfully']);
    }

    public function destroy(Gallery $gallery)
    {
        if (file_exists(public_path($gallery->image))) {
            unlink(public_path($gallery->image));
        }
        if (file_exists(public_path($gallery->image_thumb))) {
            unlink(public_path($gallery->image_thumb));
        }

        $gallery->delete();

        return response()->json([
            'message' => 'Image deleted successfully'
        ]);
    }

    public function edit(Gallery $gallery)
    {
        return inertia('Gallery/Edit', ['gallery' => $gallery]);
    }

    public function update(GalleryRequest $request, Gallery $gallery)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            // Delete old images if they exist
            if (file_exists(public_path($gallery->image))) {
                unlink(public_path($gallery->image));
            }
            if (file_exists(public_path($gallery->image_thumb))) {
                unlink(public_path($gallery->image_thumb));
            }

            $data['image'] = UploadService::handleImageUpload(
                image: $image,
                path: 'galleries/full',
                convertTo: 'webp',
                resizeWidth: 1500,
                resizeHeight: 1500,
            );
            $data['image_thumb'] = UploadService::handleImageUpload(
                image: $image,
                path: 'galleries/thumb',
                convertTo: 'webp',
                resizeWidth: 300,
                resizeHeight: 300,
            );
            $data['orientation'] = \App\Services\ImageService::getOrientation($image);

            // add height and width to the data
            list($width, $height) = getimagesize(public_path($data['image']));
            $data['width'] = $width;
            $data['height'] = $height;
        } else {
            unset($data['image']);
            unset($data['image_thumb']);
        }

        $gallery->update($data);

        return response()->json(['message' => 'Gallery updated successfully!']);
    }

}
