<?php

namespace App\Core;

use App\Core\Exceptions\RecordNotFoundException;

class Model
{
    protected static string $table = "categories";
    public  array $attributes = [
        "id" => 1,
        "categoryName" => "klsdjf",
        "categoryPrice" => "565"
    ];

    public function __set($key, $value)
    {
        $this->attributes[$key] = $value;
    }

    public function __get($key)
    {
        return $this->attributes[$key] ?? null;
    }

    public static function all(): array
    {
        return db()->fetchAll("SELECT * FROM " . static::$table, static::class);
    }

    public static function find(int $id): ?static
    {
        return db()->fetch("SELECT * FROM " . static::$table . " WHERE id = ?", [$id], static::class);
    }

    public static function findOrFail(int $id): ?static
    {
        $record = db()->fetch("SELECT * FROM " . static::$table . " WHERE id = ?", [$id], static::class);
        if ($record === false) {
            throw new RecordNotFoundException("Record With Id: {$id}, Not Found..!");
        }
        return $record;
    }

    public function delete(int $id)
    {
        return db()->execute("DELETE FROM " . static::$table . " where id = ?", [$id]);
    }
}
