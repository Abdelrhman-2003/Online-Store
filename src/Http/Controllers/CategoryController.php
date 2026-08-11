<?php

namespace App\Http\Controllers;

use App\Core\Session;
use App\Http\Validation\CategoryValidation;
use App\Models\Category;

class CategoryController extends Controller
{
    public function show(int $id)
    {
        $this->render("Category/show", [
            "products" => $this->getProducts($id),
            "category" => $this->getCategory($id),
            "categories" => $this->getCategories()
        ]);
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
        $validated = new CategoryValidation($attributes, $_FILES);

        if (!empty($validated->errors)) {
            $this->render("Categories/create", [
                "categories" => $this->getCategories(),
                "errors" => $validated->errors
            ]);
        }
        $extenstion = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);

        category()->categoryName = $attributes["category-name"];
        category()->categoryDescription = $attributes["category-desc"];
        category()->categoryImage = $attributes['category-name'] . "." . $extenstion;
        category()->save();

        Session::flash("Success-Message", $attributes['category-name'] . " Added Successfully");
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
        $validated = new CategoryValidation($attributes, $_FILES);

        if (! empty($validated->errors)) {
            $this->render("Categories/edit", [
                "categories" => $this->getCategories(),
                "category" => $this->getCategory($attributes['id']),
                "error" => $validated->errors
            ]);
        }
        category()->categoryName = $attributes["category-name"];
        category()->categoryDescription = $attributes["category-desc"];
        category()->categoryImage = $attributes["category-image"];
        category()->id = $attributes["id"];
        category()->save();

        Session::flash("Success-Message", $attributes['category-name'] . " Updated Successfully");
        redirect("/categories");
    }

    public function destroy(array $attributes)
    {

        if (!empty($this->isCategoryHaveProducts($attributes['id']))) {
            Session::flash("Success-Message", "You Can't Delete This Category Because Contain Some Products!");
        } else {
            category()->delete($attributes['id']);
            Session::flash("Success-Message", " Deleted Successfully");
        }

        redirect("/categories");
    }

    private function getCategories()
    {
        return category()->all();
    }

    private function getCategory(int $id)
    {
        return category()->findOrFail($id);
    }

    private function isCategoryHaveProducts(int $id)
    {
        return product()->find($id);
    }

    private function getCategoryImage(int $id)
    {
        return  db()->fetch("SELECT categoryImage FROM categories where id = ?", [$id]);
    }

    private function getProducts(int $id)
    {
        return db()->fetchAll("SELECT * FROM products where category_id = ?" , [$id]);
    }
}
