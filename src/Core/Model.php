<?php

namespace App\Core;

class Model
{
    protected static string $table ;

    public static function all() : array
    {
        return db()->fetchAll("SELECT * FROM " . static::$table, static::class);
    }
}
