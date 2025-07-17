<?php

require __DIR__ . ("/../src/Core/Function.php");

require base_path("Core/Router.php");

use Core\Router;

$uri = parse_url($_SERVER['REQUEST_URI'])["path"];
$method = $_POST["_method"] ?? $_SERVER["REQUEST_METHOD"];

$router = new Router();

require base_path("config/routes.php");

$router->route($method, $uri);
