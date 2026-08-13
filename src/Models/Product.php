<?php

namespace App\Models;

use App\Core\Model;

class Product extends Model
{
    protected static string $table = "products";

    public function category()
    {
        return db()->fetch("SELECT * FROM categories where id = ? LIMIT 1 ", [$this->category_id], Category::class);
    }
}
