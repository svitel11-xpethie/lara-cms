<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TestimonialRequest extends FormRequest
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
        if ($this->has('is_active')) {
            $this->merge([
                'is_active' => filter_var($this->is_active, FILTER_VALIDATE_BOOLEAN),
            ]);
        }

        if (!$this->hasFile('image')) {
            $this->merge([
                'image' => null,
            ]);
        }

        return [
            'name' => 'required|string|max:255',
            'content' => 'required|string',
            'position' => 'nullable|string|max:255',
            'image' => $this->hasFile('image')
                ? 'file|image|mimes:jpeg,png,jpg,svg,webp|max:2048'
                : 'nullable',
            'is_active' => 'boolean',
        ];
    }
}
