<?php
class Router {

    private $resources = [];

    public function addResource($resource, $action) {
        $this->resources[$resource] = $action;
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
        foreach($this->resources as $resource => $action) {
            if ($this->matches($resource, $request->getPath())) {
                return $action;
            }
        }
        return null;
    }

    private function matches($regex, $path) {
        if (!str_begins_with("/", $regex)) {
            $regex = "/$regex"; 
        }
        if (!str_ends_with("/", $regex)) {
            $regex = "$regex/";
        }
        return preg_match($regex, $path);
    }

}