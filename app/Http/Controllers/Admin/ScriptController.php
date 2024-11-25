<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ScriptRequest;
use App\Http\Resources\ScriptResource;
use App\Models\Script;
use App\Services\UploadService;
use Illuminate\Http\Request;

class ScriptController extends Controller
{
    public function index()
    {
        return inertia('Scripts/Index');
    }


    public function scripts()
    {
        return ScriptResource::collection(
            Script::orderBy('order')->get()
        );
    }


    public function store(ScriptRequest $request)
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('image')) {
                $data['image'] = UploadService::handleImageUpload(
                    image: $request->file('image'),
                    path: 'scripts',
                    resizeWidth: 100,
                    resizeHeight: 100
                );
            } else {
                unset($data['image']);
            }

            Script::create($data);

            return response()->json([
                'message' => 'Social link added successfully!',
                'script' => new ScriptResource(Script::latest()->first()),
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    public function update(ScriptRequest $request,  Script $script)
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('image')) {
                // Delete old image
                if (file_exists(public_path($script->image))) {
                    unlink(public_path($script->image));
                }

                $data['image'] = UploadService::handleImageUpload(
                    image: $request->file('image'),
                    path: 'scripts',
                    resizeWidth: 100,
                    resizeHeight: 100
                );
            } else {
                unset($data['image']);
            }

            $script->update($data);

            return response()->json([
                'message' => 'Script updated successfully!',
                'social' => new ScriptResource($script),
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    public function destroy(Script $script)
    {
        $script->delete();

        return response()->json(['message' => 'Script deleted successfully!']);
    }

    public function updateOrder(Request $request)
    {
        $data = $request->validate([
            'order' => 'required|array',
        ]);

        foreach ($data['order'] as $order => $id) {
            Script::where('id', $id)->update(['order' => $order]);
        }

        return response()->json(['message' => 'Scripts order updated successfully!']);
    }
}
