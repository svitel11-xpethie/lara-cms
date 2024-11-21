<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanyMember;
use App\Models\CompanySocial;
use App\Services\UploadService;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function profile()
    {
        $company = Company::first();

        if (!$company) {
            // Provide default empty values for adding a new company
            return inertia('Company/Profile', [
                'company' => [
                    'name' => '',
                    'ceo' => '',
                    'registration_number' => '',
                    'address' => '',
                    'phone' => '',
                    'phone_on_website' => '',
                    'email' => '',
                    'website' => '',
                    'about_us' => '',
                    'logo' => null,
                ],
            ]);
        }

        return inertia('Company/Profile', [
            'company' => $company->only([
                'name',
                'ceo',
                'registration_number',
                'address',
                'phone',
                'phone_on_website',
                'email',
                'website',
                'about_us',
                'logo',
            ]),
        ]);
    }


    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'ceo' => 'nullable|string|max:255',
            'registration_number' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'phone_on_website' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'about_us' => 'nullable|string',
            'logo' => $request->hasFile('logo')
                ? 'file|image|mimes:jpeg,png,jpg,svg,webp|max:2048'
                : 'nullable',
        ]);

        $company = Company::first();

        if ($request->hasFile('logo')) {
            $validated['logo'] = UploadService::handleImageUpload(
                image: $request->file('logo'),
                path: 'companies/logos',
                convertTo: 'webp',
                resizeWidth: 400,
                resizeHeight: 400
            );
        }

        if (!$company) {
            Company::create($validated);
        } else {
            $company->update($validated);
        }

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }


    public function team()
    {
        return inertia('Company/Team');
    }

    public function teamMembers()
    {
        return response()->json(CompanyMember::orderBy('id')->get());
    }

    public function storeMember(Request $request)
    {
        try {
            // Validate input
            $validated = $request->validate([
                'id' => 'nullable|exists:company_members,id', // For updates
                'name' => 'required|string|max:255',
                'role' => 'nullable|string|max:255',
                'photo' => $request->hasFile('photo')
                    ? 'file|image|mimes:jpeg,png,jpg,svg,webp|max:2048'
                    : 'nullable',
                'description' => 'nullable|string',
            ]);

            $validated['company_id'] = Company::first()->id;

            // Handle photo upload
            if ($request->hasFile('photo')) {
                $validated['photo'] = UploadService::handleImageUpload(
                    image: $request->file('photo'),
                    path: 'companies/team',
                    convertTo: 'webp',
                    resizeWidth: 500,
                    resizeHeight: 500
                );
            } else {
                unset($validated['photo']);
            }

            // Check if it's an update or create request
            if (!empty($validated['id'])) {
                $member = CompanyMember::findOrFail($validated['id']);
                $member->update($validated);
                $message = 'Team member updated successfully!';
            } else {
                CompanyMember::create($validated);
                $message = 'Team member added successfully!';
            }

            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function deleteMember(CompanyMember $member)
    {
        $member->delete();
        return response()->json(['message' => 'Team member deleted successfully!']);
    }


    public function social()
    {
        $socials = CompanySocial::orderBy('id')->get();
        return inertia('Company/Social', ['socials' => $socials]);
    }

    public function socialProfiles()
    {
        return response()->json(CompanySocial::orderBy('id')->get());
    }

    public function storeSocial(Request $request)
    {
        $validated = $request->validate([
            'id' => 'nullable|exists:company_socials,id', // For updates
            'platform' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'icon' => $request->hasFile('icon')
                ? 'file|image|mimes:jpeg,png,jpg,svg,webp|max:2048'
                : 'nullable',
        ]);

        // Handle icon upload
        if ($request->hasFile('icon')) {
            $validated['icon'] = UploadService::handleImageUpload(
                image: $request->file('icon'),
                path: 'companies/socials',
                resizeWidth: 100,
                resizeHeight: 100
            );
        } else {
            unset($validated['icon']);
        }


        // Check if it's an update or create request
        if (!empty($validated['id'])) {
            $social = CompanySocial::findOrFail($validated['id']);
            $social->update($validated);
            $message = 'Social link updated successfully!';
        } else {
            $validated['company_id'] = Company::first()->id;
            CompanySocial::create($validated);
            $message = 'Social link added successfully!';
        }

        return response()->json(['message' => $message]);
    }


    public function meta()
    {
        $meta = Company::firstOrFail()->meta;
        return inertia('Company/Meta', ['meta' => $meta]);
    }

    public function updateMeta(Request $request)
    {
        $validated = $request->validate([
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:500',
            'seo_keywords' => 'nullable|string|max:500',
        ]);

        $company = Company::firstOrFail();
        $company->update(['meta' => $validated]);

        return redirect()->back()->with('success', 'SEO data updated successfully!');
    }
}
