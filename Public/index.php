<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . ("/../src/Core/Function.php");

require base_path("Core/Router.php");

use App\Core\Exception\FileNotFoundException;
use App\Core\Exception\RecordNotFoundException;
use App\Core\Exception\QueryException;
use Core\Router;

$uri = parse_url($_SERVER['REQUEST_URI'])["path"];
$method = $_POST["_method"] ?? $_SERVER["REQUEST_METHOD"];

$router = new Router();

require base_path("config/routes.php");

try {
    $router->route($method, $uri);

} catch (QueryException $e) {
    serverError($e->getMessage(), $e->getFile(), $e->getLine());

} catch (RecordNotFoundException $e) {
    abort(404, $e->getMessage());

} catch (FileNotFoundException $e) {
    serverError($e->getMessage(), $e->getFile(), $e->getLine());
    
} catch (Exception $e) {
    serverError($e->getMessage(), $e->getFile(), $e->getLine());
}
