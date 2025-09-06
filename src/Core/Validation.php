<?php

namespace App\Core;

class Validation
{
    public static function textValidate(string $value, int $min = 5, int $max = 100): bool
    {
        $value = trim($value);
        $value = stripslashes($value);
        return strlen($value) >= $min && strlen($value) <= $max;
    }
}
