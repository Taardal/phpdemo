<?php
class Router {

    private $routes = array();

    public function add($route, $function) {
        $this->routes[$route] = $function;
    }

    public function receive($request) {
        $route = $this->getRoute($request);
        if ($route) {
            $this->routes[$route]($request);
        } else {
            Response::notFound()->send();
        }
    }

    public function getRoute($request) {
        foreach(array_keys($this->routes) as $route) {
            if (preg_match("/" . $route . "/", $request->getPath())) {
                return $route;
            }
        }
        return null;
    }

}