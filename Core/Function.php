<?php

function dd($value){
    echo "<pre>";
    echo var_dump($value);
    echo "</pre>";
    die();
}

function base_path($path) {
    return __DIR__ . '/../' . $path;
}

function view($path , $attributes = []){
    extract($attributes);
    require base_path("Views/{$path}");
}