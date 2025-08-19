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
                    "products" => $category['Products'],
                    "categoryName" => $category['CategoryName'],
                    "categories" => $this->getCategories()
                ]);
                die();
            }
        }
        abort(404, "No other category found");
    }

    private function getCategories()
    {
        $config = require base_path("./config/database.php");
        $db = new Database($config['connections'][$config["default"]]);
        $categories = $db->fetchAll("SELECT * FROM categories");
        return $categories;
    }

    private function getProducts()
    {
        $config = require base_path("./config/database.php");
        $db = new Database($config['connections'][$config["default"]]);
        $products = $db->fetchAll("SELECT * FROM products");
        return $products;
    }
}
