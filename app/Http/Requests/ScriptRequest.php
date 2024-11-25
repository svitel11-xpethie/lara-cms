<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScriptRequest extends FormRequest
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
        //if is_active is string, it will be converted to boolean
        if ($this->has('is_active')) {
            $this->merge([
                'is_active' => filter_var($this->is_active, FILTER_VALIDATE_BOOLEAN),
            ]);
        }

        return [
            'name' => 'required|string|max:255',
            'script' => 'required|string',
            'position' => 'required|in:head,bodyTop,bodyBottom,footer',
            'is_active' => 'boolean',
            'image' => $this->hasFile('image')
                ? 'file|image|mimes:jpeg,png,jpg,svg,webp|max:2048'
                : 'nullable',
        ];
    }
}
//<script> console.log('TEST SCRIPT'); </script>
