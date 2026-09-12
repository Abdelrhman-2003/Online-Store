<?php

namespace App\Models;

use App\Core\Model;

class ProductColor extends Model
{
    protected static string $table = "product_color";

    public static  function getProductColors(int $id): array
    {
        return db()->fetchAll(
            "SELECT c.colorName FROM product_color pc JOIN colors c ON pc.color_id = c.id WHERE pc.product_id = ?",
            [$id]
        );
    }

    public static function destroy(int $id)
    {
       return db()->execute("DELETE FROM product_color WHERE product_id = ?", [$id]);
    }
}
