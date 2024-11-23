<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SeoRequest;
use App\Http\Resources\SeoResource;
use App\Models\CompanySeo;
use App\Models\CompanySocial;
use Illuminate\Http\Request;

class CompanySeoController extends Controller
{
    public function index()
    {
        return inertia('Company/Seo');
    }

    public function metas()
    {
        return response()->json(
            SeoResource::collection(
                CompanySeo::orderBy('order')->get()
            )
        );
    }

    public function store(SeoRequest $request)
    {
        try {
            $validated = $request->validated();
            CompanySeo::create($validated);
            return response()->json([
                'message' => 'SEO data added successfully!',
                'seo' => new SeoResource(CompanySeo::latest()->first()),
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function update(SeoRequest $request, CompanySeo $seo)
    {
        try {
            $validated = $request->validated();
            $seo->update($validated);
            return response()->json([
                'message' => 'SEO data updated successfully!',
                'seo' => new SeoResource($seo),
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
                CompanySeo::where('id', $order['id'])->update(['order' => $order['order']]);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
