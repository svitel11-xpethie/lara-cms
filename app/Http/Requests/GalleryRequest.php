<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GalleryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'tags' => 'nullable|string|max:555',
            'alt' => 'nullable|string|max:255',
            'height' => 'nullable|integer',
            'width' => 'nullable|integer',
            'image' => $this->isMethod('post')
                ? 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10048'
                : 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10048'
        ];
    }
}
