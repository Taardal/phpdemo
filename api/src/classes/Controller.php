<?php
abstract class Controller {

    private $routers;

    public function __construct() {
        $this->routers = array();
        $this->registerRoutes();
    }

    public function receive($request) {
        $router = $this->routers[$request->getMethod()];
        $router->receive($request);
    }
    
    protected abstract function registerRoutes();

    protected function registerRoute($method, $route, $function) {
        if (!$this->routers[$method]) {
            $this->routers[$method] = new Router();
        }
        $router = $this->routers[$method];
        $router->add($route, $function);
    }

}