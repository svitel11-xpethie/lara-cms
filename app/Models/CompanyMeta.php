<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyMeta extends Model
{
    use HasFactory;

    protected $fillable = ['company_id', 'key', 'value'];
}