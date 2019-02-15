<?php
abstract class Controller {

    private $router;

    public function __construct() {
        $this->router = $this->getRouter();
    }

    public function receive($request) {
        $this->router->receive($request);
    }

    protected abstract function getResources();

    private function getRouter() {
        $router = new Router();
        foreach ($this->getResources() as $resource => $actions) {
            $router->addResource($resource, function ($request) use ($actions) {
                $action = $actions[$request->getMethod()];
                $response = $action ? $action($request) : Response::notAllowed();
                $response->send();
            });
        }
        return $router;
    }

}