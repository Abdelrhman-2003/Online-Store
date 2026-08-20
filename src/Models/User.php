<?php

namespace App\Models;

use App\Core\Model;

class User extends Model
{
    protected static  string $table = "users";

    public static function findByEmail(string $email): static | bool | null
    {
        return db()->fetch("SELECT * FROM users where email = ?", [$email], static::class);
    }
}
