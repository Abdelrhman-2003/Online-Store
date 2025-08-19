<?php

namespace App\Http\Controllers;

use App\Core\Database;

require base_path("./Core/Database.php");

class CategoryController
{

    public function show(int $id)
    {
        foreach ($this->getCategories() as $category) {
            if ($category['id'] === $id) {
                view("showCategory", [
                    "products" => $this->getProducts($id),
                    "category" => $this->getCategory($id),
                    "categories" => $this->getCategories()
                ]);
                die();
            }
        }
        abort(404, "No other category found");
    }

    private function getCategories()
    {
        $categories = db()->fetchAll("SELECT * FROM categories");
        return $categories;
    }

    private function getCategory(int $id)
    {
        $category = db()->fetch("SELECT * FROM categories where id = ?", [$id]);
        return $category;
    }
    
    private function getProducts(int $id)
    {
        $products = db()->fetchAll("SELECT * FROM products where category_id = ?", [$id]);
        return $products;
    }
}
