<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TestimonialRequest;
use App\Http\Resources\TestimonialResource;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        return inertia('Testimonials/Index');
    }

    public function testimonials()
    {
        return response()->json(
            TestimonialResource::collection(
                Testimonial::orderBy('order')->get()
            )
        );
    }

    public function store(TestimonialRequest $request)
    {
        try {
            $validated = $request->validated();
            Testimonial::create($validated);
            return response()->json([
                'message' => 'Testimonial added successfully!',
                'seo' => new TestimonialResource(Testimonial::latest()->first()),
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function update(TestimonialRequest $request, Testimonial $testimonial)
    {
        try {
            $validated = $request->validated();
            $testimonial->update($validated);
            return response()->json([
                'message' => 'Testimonial updated successfully!',
                'testimonial' => new TestimonialResource($testimonial),
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return response()->json(['message' => 'Testimonial deleted successfully!']);
    }


    public function updateOrder(Request $request)
    {
        try {
            $orders = $request->input('order');
            foreach ($orders as $order) {
                Testimonial::where('id', $order['id'])->update(['order' => $order['order']]);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
