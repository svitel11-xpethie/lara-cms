<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
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
                    'phone_website' => '',
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
                'phone_website',
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
            'phone_website' => 'nullable|string|max:20',
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
