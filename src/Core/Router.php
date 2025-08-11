<?php

namespace Core;

use Http\Controllers\HomeControllers;

class Router
{
    public $routes = [];

    public function add($method, $uri, $controllers)
    {
        $this->routes[] = [
            "method" => $method,
            "uri" => $uri,
            "controllers" => $controllers
        ];
    }

    public function get($uri, $controllers)
    {
        $this->add("GET", $uri, $controllers);
    }

    public function post($uri, $controllers)
    {
        $this->add("POST", $uri, $controllers);
    }

    public function delete($uri, $controllers)
    {
        $this->add("DELETE", $uri, $controllers);
    }

    public function patch($uri, $controllers)
    {
        $this->add("PATCH", $uri, $controllers);
    }

    public function route($method, $uri)
    {
        foreach ($this->routes as $routes) {
            if (strtoupper($method) === $routes['method'] && $uri === $routes['uri']) {
                [$className , $methodName] = stringToArray("::" , $routes["controllers"]);
                require base_path("Http/Controllers/{$className}.php");
                $className = "\App\Http\Controllers\\" . $className;
                (new $className)->$methodName();
                exit();
            }
        }
        abort();
    }
}
