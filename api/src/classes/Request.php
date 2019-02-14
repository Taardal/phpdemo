<?php
class Request {

    private $method;
    private $uri;
    private $url;
    private $pathParameters;
    private $body;

    private function __construct($method, $uri, $body = null) {
        $this->method = $method;
        $this->uri = $uri;
        $this->body = $body;
        if ($this->uri) {
            $this->url = parse_url($uri);
            $this->pathParameters = $this->parsePathParameters();
        }
    }

    public static function get() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];
        if ($method == HTTP_POST || $method == HTTP_PUT) {
            $body = file_get_contents("php://input");
        }
        return new Request($method, $uri, $body);
    }

    public function getMethod() {
        return $this->method;
    }

    public function getPath() {
        return $this->url['path'];
    }

    public function getPathParameters() {
        return $this->pathParameters;
    }

    public function getQuery() {
        return $this->url['query'];
    }

    public function getBody() {
        return $this->body;
    }

    private function parsePathParameters() {
        $path = $this->getPath();
        if ($path) {
            if (str_begins_with("/", $path)) {
                $path = substr($path, 1);
            }
            if (str_ends_with("/", $path)) {
                $path = substr($path, 0, -1);
            }
            return explode("/", $path);
        }
        return array();
    }

}