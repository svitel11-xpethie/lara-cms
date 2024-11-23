<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequest;
use App\Http\Resources\ServicesResource;
use App\Models\Service;
use App\Services\UploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServicesController extends Controller
{
    public function index()
    {
        return inertia('Services/Index');
    }

    public function services()
    {
        return ServicesResource::collection(
            Service::orderBy('order')->get()
        );
    }

    public function create()
    {
        return inertia('Services/Create');
    }

    public function store(ServiceRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($request->title);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $data['image'] = UploadService::handleImageUpload(image:$image, path:'services/full', convertTo: 'webp');
            $data['image_thumb'] = UploadService::handleImageUpload(image:$image, path: 'services/thumbs', convertTo: 'webp', resizeWidth: 300);
        }

        Service::create($data);
        return redirect()->route('admin.services.index')->with('success', 'Service created successfully!');
    }

    public function edit(Service $service)
    {
        return inertia('Services/Edit', compact('service'));
    }

    public function update(ServiceRequest $request, Service $service)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $data['image'] = UploadService::handleImageUpload(image:$image, path:'services/full', convertTo: 'webp');
            $data['image_thumb'] = UploadService::handleImageUpload(image:$image, path: 'services/thumbs', convertTo: 'webp', resizeWidth: 300);

            // Delete old images if they exist
            if ($service->image && file_exists(public_path($service->image))) {
                unlink(public_path($service->image));
                unlink(public_path($service->image_thumb));
            }
        }

        $service->update($data);

        return redirect()->route('admin.services.index')->with('success', 'Service updated successfully!');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return response()->json(['message' => 'Service deleted successfully']);
    }

    public function updateOrder(Request $request)
    {
        try {
            $orders = $request->input('order');
            foreach ($orders as $order) {
                Service::where('id', $order['id'])->update(['order' => $order['order']]);
            }

            return response()->json(['message' => 'Order updated successfully!']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
