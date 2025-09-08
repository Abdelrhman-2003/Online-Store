<?php

namespace App\Http\Controllers;

abstract class Controller{

    protected function render( string $viewPath ,  array $attributes = []){
        view($viewPath , $attributes);
        unset($_SESSION['_flash']);   
        die();
    }
}