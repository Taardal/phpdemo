<?php
class Router {

    private $routes = [];

    public function add($route, $action) {
        $this->routes[$route] = $action;
    }

    public function receive($request) {
        $action = $this->getAction($request);
        if ($action) {
            $action($request);
        } else {
            Response::notFound()->send();
        }
    }

    public function getAction($request) {
        foreach($this->routes as $route => $action) {
            if (preg_match("/" . $route . "/", $request->getPath())) {
                return $action;
            }
        }
        return null;
    }

}