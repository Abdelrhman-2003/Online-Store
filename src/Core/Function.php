<?php

use App\Core\Database;

function dd($value)
{
    echo "<pre>";
    echo var_dump($value);
    echo "</pre>";
    die();
}

function stringToArray(string $seprator, string $string)
{
    return explode($seprator, $string);
}

function base_path(string $path)
{
    return __DIR__ . '/../' . $path;
}

function view(string $path, array $attributes = [])
{
    extract($attributes);
    require base_path("Views/Template/{$path}.phtml");
}

function abort(int $code, string $message)
{
    http_response_code($code);

    view(
        "statusCode",
        [
            "message" => $message,
            "code" => $code
        ]
    );
    die();
}

function db(){
    static $database = null;
    if($database === null){
        $config = require base_path("./config/database.php");
        $database = new Database($config['connections'][$config['default']]);
    }
    return $database;
}