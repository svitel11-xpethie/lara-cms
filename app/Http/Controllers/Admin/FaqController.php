<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FaqRequest;
use App\Http\Resources\FaqResource;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        return inertia('Faq/Index');
    }

    public function faqs()
    {
        return response()->json(
            FaqResource::collection(
                Faq::orderBy('order')->get()
            )
        );
    }

    public function store(FaqRequest $request)
    {
        try {
            $validated = $request->validated();
            Faq::create($validated);
            return response()->json([
                'message' => 'Faq data added successfully!',
                'faq' => new FaqResource(Faq::latest()->first()),
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function update(FaqRequest $request, Faq $faq)
    {
        try {
            $validated = $request->validated();
            $faq->update($validated);
            return response()->json([
                'message' => 'Faq data updated successfully!',
                'faq' => new FaqResource($faq),
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Faq $social)
    {
        $social->delete();
        return response()->json(['message' => 'Social link deleted successfully!']);
    }


    public function updateOrder(Request $request)
    {
        try {
            $orders = $request->input('order');
            foreach ($orders as $order) {
                Faq::where('id', $order['id'])->update(['order' => $order['order']]);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
