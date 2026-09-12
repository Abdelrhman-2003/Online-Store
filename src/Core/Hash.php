<?php

namespace App\Core;

class Hash
{

    public static function make(string $value): string
    {
        return password_hash($value, PASSWORD_BCRYPT);
    }

    public static function check(string $value, string $hash): bool
    {
        return password_verify($value, $hash);
    }
}
