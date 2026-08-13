<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        $this->render("home", [
            "categories" => $this->getCategories(),
            "products" => $this->getProducts()
        ]);
    }

    private function getCategories()
    {
        return category()->all();
    }

    private function getProducts()
    {
        $products = product()->all();
        $productsByCategorId = [];
        foreach ($products as $product) {
            $productsByCategorId[$product->category_id][] = $product;
        }
        return $productsByCategorId;
    }
}
