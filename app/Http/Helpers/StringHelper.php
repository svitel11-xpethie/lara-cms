<?php

namespace App\Http\Helpers;

class StringHelper
{
    public static function nullStrToNull($value): ?string
    {
        return $value === 'null' ? null : $value;
    }
}
