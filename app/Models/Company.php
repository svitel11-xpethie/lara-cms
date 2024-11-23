<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'ceo', 'registration_number', 'address',
        'phone', 'email', 'website', 'about_us', 'logo'
    ];
}
