<?php

namespace App\Models;

use App\Core\Model;

class ProductSize extends Model
{
    protected static string $table = "product_size";

    public static  function getProductSizes(int $id): array
    {
        return db()->fetchAll(
            "SELECT s.sizeName FROM product_size pc JOIN sizes s ON pc.size_id = s.id WHERE pc.product_id = ?",
            [$id] 
        );
    }

    public static function destory(int $id)
    {
        return db()->execute("DELETE FROM product_size where product_id = ?", [$id]);
    }
}
