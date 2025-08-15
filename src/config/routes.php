<?php

$router->get("/" , "HomeController::index");
$router->get("/category/{id}/products" , "CategoryController::show");