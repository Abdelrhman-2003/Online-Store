<?php

namespace App\Models;

use App\Core\Model;

class Size extends Model
{
    protected static string $table = "sizes";

    public static  function getSizes(): array
    {
        return size()->all();
    }

    public static  function getSizeID(string $sizeName): array
    {
        return db()->fetch("SELECT id FROM sizes where sizeName = ? LIMIT 1", ["$sizeName"]);
    }
}
