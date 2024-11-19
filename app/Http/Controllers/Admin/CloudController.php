<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\CloudResource;
use App\Models\Cloud;
use App\Services\Image;
use App\Services\Upload;
use Illuminate\Http\Request;

class CloudController extends Controller
{
    public function index()
    {
        return inertia('Cloud/Index');
    }

    public function upload(Request $request)
    {
        try {
            // upload full image
            $image_full = Upload::handleImageUpload(
                image: $request->file('image'),
                path: 'cloud/full',
                convertTo: 'webp',
                resizeWidth: 2000,
                resizeHeight: 2000,
            );

            // upload thumbnail
            $image_thumb = Upload::handleImageUpload(
                image: $request->file('image'),
                path: 'cloud/thumbs',
                convertTo: 'webp',
                resizeWidth: 300
            );

            $file = Cloud::create([
                'name' => $request->file('image')->getClientOriginalName(),
                'alt' => $request->input('alt') ?? $request->file('image')->getClientOriginalName(),
                'image' => $image_full,
                'image_thumb' => $image_thumb,
                'type' => 'webp',
                'size' => $request->file('image')->getSize(),
                'orientation' => Image::getOrientation($request->file('image'))
            ]);

            return new CloudResource($file);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'No file uploaded',
                'error' => $e->getMessage()
            ], $e->getCode());
        }


    }


    public function delete($id)
    {
        $file = Cloud::find($id);
        if (file_exists(public_path('cloud/thumb/' . $file->slug))) {
            unlink(public_path('cloud/thumb/' . $file->slug));
            unlink(public_path('cloud/full/' . $file->slug));
        }
        $file->delete();

        return response()->json(['message' => 'File deleted successfully']);
    }


    public function images()
    {
        return CloudResource::collection(Cloud::all());
    }
}
