<?php

namespace App\Models;

use App\Core\Model;

class Color extends Model
{
    protected static string $table = "colors";


    public static  function getColors(): array
    {
        return color()->all();
    }

    public static  function getColorID(string $colorName): array
    {
        return db()->fetch("SELECT id from colors where colorName = ? LIMIT 1", ["$colorName"]);
    }
}
