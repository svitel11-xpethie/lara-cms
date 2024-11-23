<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberRequest extends FormRequest
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
            'id' => 'nullable|exists:company_members,id',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:5555',
            'role' => 'nullable|string|max:255',
            'order' => 'nullable|default:0',
            'is_active' => 'nullable|boolean',
            'photo' => $this->hasFile('photo')
                ? 'file|image|mimes:jpeg,png,jpg,svg,webp|max:2048'
                : 'nullable',
        ];
    }
}
