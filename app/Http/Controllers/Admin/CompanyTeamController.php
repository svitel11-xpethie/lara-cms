<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MemberRequest;
use App\Http\Resources\MemberResource;
use App\Models\CompanyMember;
use App\Services\UploadService;
use Illuminate\Http\Request;

class CompanyTeamController extends Controller
{
    public function index()
    {
        return inertia('Company/Team');
    }

    public function members()
    {
        return response()->json(
            MemberResource::collection(
                CompanyMember::orderBy('order', 'ASC')->orderBy('id', 'DESC')->get()
            )
        );
    }

    public function store(MemberRequest $request)
    {
        try {
            $data = $request->validated();

            // Handle photo upload
            if ($request->hasFile('photo')) {
                $data['photo'] = UploadService::handleImageUpload(
                    image: $request->file('photo'),
                    path: 'companies/team',
                    convertTo: 'webp',
                    resizeWidth: 500,
                    resizeHeight: 500
                );
            }

            CompanyMember::create($data);

            return response()->json([
                'message' => 'Team member added successfully!',
                'member' => new MemberResource(CompanyMember::latest()->first()),
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    public function update(MemberRequest $request, CompanyMember $member)
    {
        try {
            $data = $request->validated();
            // Handle photo upload
            if ($request->hasFile('photo')) {
                // Delete old photo
                if ($member->photo && file_exists(public_path($member->photo))) {
                    unlink(public_path($member->photo));
                }

                $data['photo'] = UploadService::handleImageUpload(
                    image: $request->file('photo'),
                    path: 'companies/team',
                    convertTo: 'webp',
                    resizeWidth: 500,
                    resizeHeight: 500
                );
            } else {
                unset($data['photo']);
            }

            $member->update($data);

            return response()->json([
                'message' => 'Team member updated successfully!',
                'member' => new MemberResource($member),
            ]);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    public function destroy(CompanyMember $team)
    {
        try {
            $team->delete();

            return response()->json(['message' => 'Team member deleted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    public function updateOrder(Request $request)
    {
        try {
            $orders = $request->input('order');
            foreach ($orders as $order) {
                CompanyMember::where('id', $order['id'])->update(['order' => $order['order']]);
            }

            return response()->json(['message' => 'Order updated successfully!']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

}
