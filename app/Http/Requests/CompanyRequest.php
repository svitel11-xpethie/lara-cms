<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'ceo' => 'nullable|string|max:255',
            'registration_number' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255',
            'website' => 'nullable|string|max:255',
            'about_us' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
            'socials' => 'nullable|array',
            'socials.*.platform' => 'required|string|max:255',
            'socials.*.url' => 'nullable|string|max:255',
            'members' => 'nullable|array',
            'members.*.name' => 'required|string|max:255',
            'members.*.role' => 'nullable|string|max:255',
            'members.*.contact' => 'nullable|string|max:255',
        ];
    }
}
