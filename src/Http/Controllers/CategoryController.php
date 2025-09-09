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
        $this->render("Categories/create", [
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
        $_SESSION["_flash"]['AddedSuccess'] = $attributes['category-name'] . " Added Successfully";
        redirect("/categories");
    }

    public function edit(int $id)
    {
        $this->render("Categories/edit", [
            "category" => $this->getCategory($id),
            "categories" => $this->getCategories()
        ]);
    }

    public function update(array $attributes)
    {
        $validated = new FormValidation($attributes);

        if (! empty($validated->errors)) {
            $this->render("Categories/edit", [
                "categories" => $this->getCategories(),
                "category" => $this->getCategory($attributes['id']),
                "error" => $validated->errors
            ]);
        }

        db()->execute("UPDATE categories set categoryName = ? , description = ? , image = ? where id = ?", [
            $attributes['category-name'],
            $attributes['category-desc'],
            $attributes['category-img'],
            $attributes['id']
        ]);
        $_SESSION['_flash']['UpdatedSuccess'] = $attributes['category-name'] . " Updated Successfully";
        redirect("/categories");
    }

    public function destroy(array $attributes)
    {
        db()->execute("DELETE From categories where id = ?", [$attributes['id']]);
        $_SESSION['_flash']['DeletedSuccess'] = $attributes['category-name'] . " Deleted Successfully";
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
