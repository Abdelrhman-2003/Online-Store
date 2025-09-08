<?php

namespace App\Http\Controllers;

use App\Core\Exception\RecordNotFoundException;
use App\Http\Validation\FormValidation;

require base_path("./Core/Exceptions/RecordNotFoundException.php");
require base_path("Http/Validation/FormValidation.php");
require "Controller.php";

class CategoryController extends Controller
{
    public function show(int $id)
    {
    if ($this->getCategory($id) != false) {
            $this->render("Category/show", [
                "categories" => $this->getCategories(),
                "category" => $this->getCategory($id),
                "products" => $this->getProducts($id)
            ]);
        }
    }

    public function index()
    {
        $this->render("Categories/index", [
            "categories" => $this->getCategories(),
        ]);
    }

    public function create()
    {
        $this->render("Categories/index", [
            "categories" => $this->getCategories(),
        ]);
    }

    public function store(array $attributes)
    {
        $validated = new FormValidation($attributes);

        if (!empty($validated->errors)) {
            $this->render("Categories/create", [
                "categories" => $this->getCategories(),
                "errors" => $validated->errors
            ]);
        }

        db()->execute("INSERT INTO categories (categoryName , description , image) 
        VALUE (?, ?, ?)", [
            $attributes['category-name'],
            $attributes["category-desc"],
            $attributes['category-img']
        ]);
        $_SESSION["_flash"]['addedSuccess'] = $attributes['category-name'];
        redirect("/categories");
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
