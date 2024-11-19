<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CloudRequest extends FormRequest
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
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'order' => 'nullable|numeric|min:0',
            'is_active' => 'nullable|boolean',

            'meta_tags' => 'nullable|array',
            'meta_tags.seo_title' => 'nullable|string|max:255',
            'meta_tags.seo_description' => 'nullable|string|max:1555',
            'meta_tags.facebook_title' => 'nullable|string|max:255',
            'meta_tags.facebook_description' => 'nullable|string|max:1555',
            'meta_tags.twitter_title' => 'nullable|string|max:255',
            'meta_tags.twitter_description' => 'nullable|string|max:1555',

            'meta_data' => 'nullable|array',
            'meta_data.*' => 'nullable|string|max:1555',
        ];
    }
}
