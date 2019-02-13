<?php
class Router {

    private const PATH_SEPARATOR = "/";
    private $routes = array();

    public function add($route, $function) {
        $this->routes[$route] = $function;
    }

    public function receive($request) {
        $route = $request->getPathParameters()[0];
        if ($this->isValidRoute($route)) {
            $this->routes[$route]($request);
        } else {
            Response::notFound()->send();
        }
    }

    private function isValidRoute($route) {
        return $route != null && strlen($route) > 0 && array_key_exists($route, $this->routes);
    }

}