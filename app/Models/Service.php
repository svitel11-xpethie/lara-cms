<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'slug',
        'image',
        'image_thumb',
        'order',
        'views',
        'meta_tags',
        'meta_data',
    ];

    protected $casts = [
        'meta_tags' => 'array',
    ];
}
