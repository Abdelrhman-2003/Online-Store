<?php

namespace App\Http\Controllers;

use App\Core\Session;
use App\Http\Validation\ProductValidation;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductSize;
use App\Models\Size;

class ProductController extends Controller
{
    public function index(): void
    {
        $this->render("Products/index", [
            "products" => Product::getProducts(),
            "categories" => Category::getCategories()
        ]);
    }

    public function show(int $id): void
    {
        $this->render("Products/show", [
            "categories" => Category::getCategories(),
            "product" => Product::getProduct($id),
            "productColor" => ProductColor::getProductColors($id),
            "productSize" => ProductSize::getProductSizes($id)
        ]);
    }

    public function create(int $id): void
    {
        $this->render("Products/create", [
            "errors" => $this->validated->errors ?? null,
            "category" => Category::getCategoryNameAndId($id),
            "categories" => Category::getCategories(),
            "colors" => Color::getColors(),
            "sizes" => Size::getSizes()
        ]);
    }

    public function edit(int $id)
    {
        $this->render("Products/edit", [
            "errors" => $this->validated->errors ?? null,
            "categories" => Category::getCategories(),
            "product" => Product::getProduct($id),
            "colors" => Color::getColors(),
            "sizes" => Size::getSizes(),
            "productColor" => ProductColor::getProductColors($id),
            "productSize" => ProductSize::getProductSizes($id)
        ]);
    }

    public function indexCards(): void
    {
        $this->render("Products/indexCards", [
            "categories" => Category::getCategories()
        ]);
    }

    public function store(array $attributes): void
    {
        $this->validated = new ProductValidation($attributes, $_FILES);
        if (! empty($this->validated->errors)) {
            $this->create($attributes['id']);
            die();
        }
        $extenstion = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
        Product::create($attributes, $extenstion);
        Session::flash("Success-Message", $attributes['product_name'] . " Added Successfuly!");
        redirect("/products");
    }

    public function update(array $attributes)
    {
        $this->validated = new ProductValidation($attributes, $_FILES);
        if (! empty($this->validated->errors)) {
            $this->edit($attributes['id']);
            die();
        }
        $oldImage = Product::getProductImage($attributes['id']);
        $extension = checkImage($_FILES, $oldImage['productImage']);
        Product::update($attributes, $extension);
        Session::flash("Success-Message", $attributes['product_name'] . " Updated Successfully!");
        redirect("/products");
    }

    public function destroy(int $id)
    {
        Product::destroy($id);
        Session::flash("Success-Message", "Product Deleted Successfully");
        redirect("/products");
    }
}
