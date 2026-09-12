<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $this->render("home", [
            "categories" => Category::getCategories(),
            "products" => Product::getProductsWithCategoryId()
        ]);
    }
}
