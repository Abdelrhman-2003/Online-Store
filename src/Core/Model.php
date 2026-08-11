<?php

namespace App\Core;

use App\Core\Exceptions\RecordNotFoundException;

class Model
{
    protected static string $table ;
    public  array $attributes = [];

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
        return db()->fetchAll("SELECT * FROM " . static::$table, [] , static::class);
    }

    public static function find(int $id): static | bool | null
    {
        return db()->fetch("SELECT * FROM " . static::$table . " WHERE id = ?", [$id], static::class);
    }

    public static function findOrFail(int $id): static | bool | null
    {
        $record = static::find($id);
        if ($record === null) {
            throw new RecordNotFoundException("Record With Id: {$id}, Not Found..!");
        }
        return $record;
    }

    public function delete(int $id)
    {
        return db()->execute("DELETE FROM " . static::$table . " where id = ?", [$id]);
    }

    public  function save(): void
    {
        if (! isset($this->attributes['id'])) {
            $keys = array_keys($this->attributes);

            db()->execute(
                "INSERT INTO " . static::$table . " (" . implode(', ', $keys) . ")" .
                    " VALUES (" . implode(', ', array_fill(0, count($keys), '?')) . ")",
                array_values($this->attributes)  
            );
                    $this->attributes['id'] =  db()->getLastId();
        } else {
            $keys = array_keys($this->attributes);
            $attr = $this->attributes;
            unset($attr['id']);
            $keys = array_keys($attr);
            $setWithoutId = implode(', ', array_map(fn($key) => "`$key` = ?", $keys));
            db()->execute(
                "UPDATE " . static::$table . " SET $setWithoutId WHERE id = ?",
                [...array_values($attr) , $this->attributes['id']]
            );
        }
    }
}