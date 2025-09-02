<?php

require __DIR__ . ("/../src/Core/Function.php");

require base_path("Core/Router.php");

use App\Core\PDOErrors;
use Core\Router;

$uri = parse_url($_SERVER['REQUEST_URI'])["path"];
$method = $_POST["_method"] ?? $_SERVER["REQUEST_METHOD"];

$router = new Router();

require base_path("config/routes.php");

try {
    $router->route($method, $uri);
} catch (PDOException $e) {

    error_log($e->getMessage() . "\n", 3, __DIR__ . "/../logs/error.log");

    abort(500 , "Something went wrong, please try again later.");
}
