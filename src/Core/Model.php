<?php

namespace App\Core;

use App\Core\Exceptions\RecordNotFoundException;

class Model
{
    protected static string $table = "categories";

    public static function all(): array
    {
        return db()->fetchAll("SELECT * FROM " . static::$table, static::class);
    }

    public static function find(int $id): ?static
    {
        return db()->fetch("SELECT * FROM " . static::$table . " WHERE id = ?", [$id], static::class);
    }

    public static function findOrFail(int $id) : ?static{
        $record = db()->fetch("SELECT * FROM " . static::$table . " WHERE id = ?", [$id], static::class);
                if($record === false){
                    throw new RecordNotFoundException("Record With Id: {$id}, Not Found..!");   
                }
        return $record;
        }
}
