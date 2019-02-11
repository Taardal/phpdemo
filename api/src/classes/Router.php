<?php

class Router {

    private $routes = array();

    public function add($route, $function) {
        $this->routes[$route] = $function;
    }

    public function receive($route, $request) {
        if (array_key_exists($route, $this->routes)) {
            $this->routes[$route]($request);
        }
    } 

}