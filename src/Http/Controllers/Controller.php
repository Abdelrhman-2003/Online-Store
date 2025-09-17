<?php

namespace App\Http\Controllers;

use App\Core\Session;

abstract class Controller{

    protected function render( string $viewPath ,  array $attributes = []){
        view($viewPath , $attributes);
        Session::unflash(); 
        die();
    }
}