<?php

$router->get("/", "HomeController::index");
$router->get("/category/{id}/products", "CategoryController::show");

// Categories
$router->get("/categories", "CategoryController::index");
$router->get("/categories/create", "CategoryController::create");
$router->post("/categories/store", "CategoryController::store");
$router->get("/categories/edit/{id}", "CategoryController::edit");
$router->put("/categories/update", "CategoryController::update");
$router->delete("/categories/destroy", "CategoryController::destroy");