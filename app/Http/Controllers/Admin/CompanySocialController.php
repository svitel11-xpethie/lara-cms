<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SocialRequest;
use App\Http\Resources\SocialResource;
use App\Models\CompanySocial;
use App\Services\UploadService;
use Illuminate\Http\Request;

class CompanySocialController extends Controller
{
    public function index()
    {
        return inertia('Company/Social');
    }

    public function profiles()
    {
        return response()->json(
            SocialResource::collection(
                CompanySocial::orderBy('order')->get()
            )
        );
    }

    public function store(SocialRequest $request)
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('icon')) {
                $validated['icon'] = UploadService::handleImageUpload(
                    image: $request->file('icon'),
                    path: 'companies/socials',
                    resizeWidth: 100,
                    resizeHeight: 100
                );
            } else {
                unset($data['icon']);
            }

            CompanySocial::create($data);

            return response()->json([
                'message' => 'Social link added successfully!',
                'social' => new SocialResource($social ?? CompanySocial::latest()->first()),
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    public function update(SocialRequest $request, CompanySocial $social)
    {
        try {
            $validated = $request->validated();

            if ($request->hasFile('icon')) {
                // Delete old image
                if ($social->icon) {
                    unlink(public_path($social->icon));
                }

                $validated['icon'] = UploadService::handleImageUpload(
                    image: $request->file('icon'),
                    path: 'companies/socials',
                    resizeWidth: 100,
                    resizeHeight: 100
                );
            } else {
                unset($validated['icon']);
            }

            $social->update($validated);

            return response()->json([
                'message' => 'Social link updated successfully!',
                'social' => new SocialResource($social),
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    public function destroy(CompanySocial $social)
    {
        $social->delete();
        return response()->json(['message' => 'Social link deleted successfully!']);
    }


    public function updateOrder(Request $request)
    {
        try {
            $orders = $request->input('order');
            foreach ($orders as $order) {
                CompanySocial::where('id', $order['id'])->update(['order' => $order['order']]);
            }

            return response()->json(['message' => 'Order updated successfully!']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

}
