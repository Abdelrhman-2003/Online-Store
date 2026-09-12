<?php

namespace App\Models;

use App\Core\Exceptions\RecordNotFoundException;
use App\Core\Model;
use App\Core\Session;

class Category extends Model
{
    protected static string $table = "categories";

    public function products(): array
    {
        return db()->fetchAll("SELECT * FROM products WHERE category_id = ? ", [$this->id], Product::class);
    }

    public static function update(array $attributes, string $extension)
    {
        static::isFoundCategory($attributes['id']);
        category()->categoryName = $attributes["category-name"];
        category()->categoryDescription = $attributes["category-desc"];
        category()->categoryImage = $attributes["category-image"] . "." . $extension;
        category()->id = $attributes["id"];
        category()->save();
    }

    public static function create(array $attributes, string $extenstion)
    {
        category()->categoryName = $attributes["category-name"];
        category()->categoryDescription = $attributes["category-desc"];
        category()->categoryImage = $attributes['category-name'] . "." . $extenstion;
        category()->save();
    }

    public static function destroy(int $id)
    {
        if (!empty(static::hasProducts($id))) {
            Session::flash("Success-Message", "You Can't Delete This Category Because Contain Some Products!");
        } else {
            category()->delete($id);
            Session::flash("Success-Message", " Deleted Successfully");
        }
    }

    public static  function getCategoryNameAndId(int $id): array
    {
        $categoryNameAndId = db()->fetch("SELECT categoryName , id FROM categories where id = ? LIMIT 1", [$id]);
        if ($categoryNameAndId === false) {
            throw new RecordNotFoundException("Category with ID {$id} not found!");
        }
        return $categoryNameAndId;
    }

    public static function getCategories()
    {
        return category()->all();
    }

    public static function isFoundCategory(int $id)
    {
        $category = db()->fetch("SELECT categoryName FROM categories where id = ? LIMIT 1", [$id]);
        if (! $category) {
            throw new RecordNotFoundException("Category with id : $id, Not found!");
        }
    }

    public static function getCategory(int $id)
    {
        return category()->findOrFail($id);
    }

    public static function hasProducts(int $id)
    {
        return static::getProducts($id);
    }

    public static function getCategoryImage(int $id)
    {
        return  db()->fetch("SELECT categoryImage FROM categories where id = ?", [$id]);
    }

    public static function getProducts(int $id)
    {
        $category = category()->find($id);
        if (! $category) {
            throw new RecordNotFoundException("Record With Id: {$id}, Not Found..!");
        }
        return $category->products();
    }
}
