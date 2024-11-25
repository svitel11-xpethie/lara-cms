<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFormRequest;
use App\Models\FormRequest;
use Illuminate\Http\Request;

class FormRequestController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Validate standard fields
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'nullable|string|max:20',
                'message' => 'required|string',
            ]);

            // Extract additional inputs
            $standardFields = ['name', 'email', 'phone', 'message', '_token'];
            $additionalInputs = $request->except($standardFields);

            // Save to database
            FormRequest::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'message' => $validated['message'],
                'additional_inputs' => $additionalInputs, // Save extra fields as JSON
            ]);

            return response()->json([
                'message' => 'Form request submitted successfully.',
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Return validation errors
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors(), // Send validation errors back to the frontend
            ], 422); // 422 Unprocessable Entity for validation errors
        } catch (\Exception $e) {
            // Return general errors
            return response()->json([
                'message' => 'An error occurred while submitting the form request. Please try again later.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
