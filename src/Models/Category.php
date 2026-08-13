<?php

namespace App\Models;

use App\Core\Model;

class Category extends Model
{
    protected static string $table = "categories";

    public function products() : array
    {
        return db()->fetchAll("SELECT * FROM products WHERE category_id = ? ", [$this->id], Product::class);
    }
}
