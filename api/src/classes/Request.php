<?php
class Request {

    private const PATH_SEPARATOR = "/";

    private $method;
    private $url;
    private $pathParameters;
    private $body;

    public function __construct() {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->url = parse_url($_SERVER['REQUEST_URI']);
        $this->pathParameters = $this->parsePathParameters();
        $this->body = $this->parseBody();
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

    private function parseBody() {
        if ($this->method == "POST" || $this->method == "PUT") {
            $json = file_get_contents("php://input");
            if ($json != null && strlen($json) > 0) {
                return json_decode($json);
            }
        }
        return array();
    }

}