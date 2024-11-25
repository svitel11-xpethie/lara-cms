<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormRequest extends Model
{
    protected $table = 'form_requests';
    protected $guarded = [];

    protected $casts = [
        'additional_inputs' => 'array', // Automatically cast JSON to an array
        'email_sent' => 'boolean',
        'sms_sent' => 'boolean',
        'whatsapp_sent' => 'boolean',
    ];
}
