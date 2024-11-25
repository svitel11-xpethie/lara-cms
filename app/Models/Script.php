<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Script extends Model
{
    protected $guarded = [];

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
}
