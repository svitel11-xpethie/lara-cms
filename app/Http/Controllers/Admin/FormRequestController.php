<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\FormRequestResource;
use App\Models\FormRequest;
use Illuminate\Http\Request;

class FormRequestController extends Controller
{
    public function index()
    {
        $formRequests = FormRequest::orderBy('created_at', 'desc')->get();
        return inertia('FormRequests/Index', [
            'formRequests' => FormRequestResource::collection($formRequests),
        ]);
    }

    public function messages()
    {
        $formRequests = FormRequest::orderBy('created_at', 'desc')->get();
        return response()->json(FormRequestResource::collection($formRequests));
    }

    public function show(FormRequest $formRequest)
    {
        return inertia('FormRequests/Show', [
            'formRequest' => new FormRequestResource($formRequest),
        ]);
    }

    public function sendEmail(FormRequest $formRequest)
    {
        // Mock Email Sending (replace with actual implementation)
        $formRequest->update(['email_sent' => true]);

        return response()->json(['message' => 'Email sent successfully!']);
    }

    public function sendWhatsApp(FormRequest $formRequest)
    {
        // Mock WhatsApp Sending (replace with actual implementation)
        $formRequest->update(['whatsapp_sent' => true]);

        return response()->json(['message' => 'WhatsApp message sent successfully!']);
    }

    public function destroy(FormRequest $formRequest)
    {
        $formRequest->delete();
        return response()->json(['message' => 'Request deleted successfully!']);
    }
}

?>
