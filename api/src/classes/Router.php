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

    private function getAction($request) {
        foreach($this->routes as $route => $action) {
            if ($this->matches($route, $request->getPath())) {
                return $action;
            }
        }
        return null;
    }

    private function matches($regex, $path) {
        return preg_match("/" . $regex . "/", $request->getPath());
    }

}