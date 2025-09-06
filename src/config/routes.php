<?php

$router->get("/" , "HomeController::index");
$router->get("/category/{id}/products" , "CategoryController::show");

// Categories
$router->get("/categories" , "CategoryController::index");
$router->get("/categories/create" , "CategoryController::create");