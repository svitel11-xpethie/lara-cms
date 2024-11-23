<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SocialRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => 'nullable|exists:company_socials,id', // For updates
            'platform' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'icon' => $this->hasFile('icon')
                ? 'file|image|mimes:jpeg,png,jpg,svg,webp|max:2048'
                : 'nullable',
        ];
    }
}
