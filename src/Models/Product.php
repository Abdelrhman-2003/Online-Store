<?php

namespace App\Models;

use App\Core\Exceptions\RecordNotFoundException;
use App\Core\Model;

class Product extends Model
{
    protected static string $table = "products";

    public function category()
    {
        return db()->fetch("SELECT * FROM categories where id = ? LIMIT 1 ", [$this->category_id], Category::class);
    }

    public static function create(array $attributes, string $extension)
    {
        product()->productName  = $attributes["product_name"];
        product()->productImage = $attributes["product_name"] . "." . $extension;
        product()->productDescription = $attributes["description"];
        product()->productPrice = abs($attributes["price"]);
        product()->category_id = $attributes["id"];
        product()->save();

        $lastID = db()->getLastId();

        $colors = $attributes['colors'] ?? [];
        $sizes = $attributes['sizes'] ?? [];

        foreach ($colors as $color) {
            $colorID = Color::getColorID($color);
            $productColor = new ProductColor();
            $productColor->product_id = $lastID;
            $productColor->color_id = $colorID['id'];
            $productColor->save();
        }
        foreach ($sizes as $size) {
            $sizeID = Size::getSizeID($size);
            $productSize = new ProductSize();
            $productSize->product_id = $lastID;
            $productSize->size_id = $sizeID['id'];
            $productSize->save();
        }
    }

    public static function update(array $attributes, string $extension)
    {
        product()->productName = $attributes["product_name"];
        product()->productImage = $attributes["product_name"] . "." . $extension;
        product()->productPrice = abs($attributes['price']);
        product()->productDescription = $attributes["description"];
        product()->id = $attributes["id"];
        product()->save();

        $colors = $attributes['colors'] ?? [];
        $sizes = $attributes['sizes'] ?? [];

        ProductColor::destroy($attributes['id']);

        foreach ($colors as $color) {
            $colorID = Color::getColorID($color);
            $productColor = new ProductColor;
            $productColor->product_id = $attributes['id'];
            $productColor->color_id = $colorID['id'];
            $productColor->save();
        }

        ProductSize::destory($attributes['id']);

        foreach ($sizes as $size) {
            $sizeID = Size::getSizeID($size);
            $productSize = new ProductSize;
            $productSize->product_id = $attributes['id'];
            $productSize->size_id = $sizeID['id'];
            $productSize->save();
        }
    }

    public static function destroy(int $id)
    {
        return product()->delete($id);
    }

    public static  function getProductImage(int $id): array
    {
        return db()->fetch("SELECT productImage from products where id = ? ", [$id]);
    }

    public static  function getProducts(): array
    {
        return db()->fetchAll("SELECT p.id, p.productName, p.productDescription, p.productPrice, p.productImage, c.categoryName 
        AS categoryName
        FROM products p
        JOIN categories c ON p.category_id = c.id", [], Product::class);
    }

    public static  function getProduct(int $id): array
    {
        $product = db()->fetch("SELECT p.id, p.productName, p.productDescription, p.productPrice, p.productImage, c.categoryName FROM products p
        JOIN categories c ON p.category_id = c.id  WHERE p.id = ?", [$id]);
        if ($product === false) {
            throw new RecordNotFoundException("Product with ID {$id} not found!");
        }
        return $product;
    }
    public static function getProductsWithCategoryId()
    {
        $products = product()->all();
        $productsByCategorId = [];
        foreach ($products as $product) {
            $productsByCategorId[$product->category_id][] = $product;
        }
        return $productsByCategorId;
    }
}
