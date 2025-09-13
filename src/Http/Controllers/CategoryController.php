<?php

namespace App\Http\Controllers;

use App\Core\Exception\RecordNotFoundException;

require base_path("./Core/Exceptions/RecordNotFoundException.php");

class CategoryController
{
    public function show(int $id)
    {
            view("showCategory", [
                "products" => $this->getProducts($id),
                "category" => $this->getCategory($id),
                "categories" => $this->getCategories()
            ]);
            die();
    }

    private function getCategories()
    {
        return db()->fetchAll("SELECT * FROM categories");
    }

    private function getCategory(int $id)
    {
        $category = db()->fetch("SELECT * FROM categories where id = ? LIMIT 1 ", [$id]) ?? null;

        if ($category === false) {
            throw new RecordNotFoundException("Category with ID {$id} not found!");
        }
        return $category;
    }

    private function getProducts(int $id)
    {
        return db()->fetchAll("SELECT * FROM products where category_id = ?", [$id]);
    }
}
