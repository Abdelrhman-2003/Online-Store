<?php

namespace App\Core;

use App\Models\User;

class Auth
{
    public static function check(): bool
    {
        return Session::has("user_id");
    }

    public static function require()
    {
        if (! static::check()) {
            redirect('/login');
        }
    }

    public static function user(): ?User
    {
        return static::check() ? User::find(Session::get("user_id")) : null;
    }
}
