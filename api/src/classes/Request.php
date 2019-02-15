<?php
class Request {

    private $method;
    private $body;
    private $uri;
    private $url;
    private $path;
    private $query;
    private $pathParameters;
    private $queryParameters;

    private function __construct($method, $uri, $body = null) {
        $this->method = $method;
        $this->uri = $uri;
        $this->body = $body;
        if ($uri) {
            $this->url = parse_url($uri);
            $this->path = $this->url['path'];
            $this->query = $this->url['query'];
            $this->pathParameters = $this->parsePathParameters();
            $this->queryParameters = $this->parseQueryParameters();
        }
    }

    public static function createFromGlobals() {
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

    public function getBody() {
        return $this->body;
    }

    public function getUri() {
        return $this->uri;
    }

    public function getUrl() {
        return $this->url;
    }

    public function getPath() {
        return $this->path;
    }

    public function getQuery() {
        return $this->query;
    }

    public function getPathParameters() {
        return $this->pathParameters;
    }

    public function getQueryParameters() {
        return $this->queryParameters;
    }

    private function parsePathParameters() {
        $pathParameters = [];
        $path = $this->getPath();
        if ($path) {
            if (str_begins_with("/", $path)) {
                $path = substr($path, 1);
            }
            if (str_ends_with("/", $path)) {
                $path = substr($path, 0, -1);
            }
            $pathParameters = explode("/", $path);
        }
        return $pathParameters;
    }

    private function parseQueryParameters() {
        $queryParameters = [];
        $query = $this->getQuery();
        if ($query) {
            $pairs = explode("&", $query);
            foreach ($pairs as $pair) {
                $keyValue = explode("=", $pair);
                $queryParameters[$keyValue[0]] = $keyValue[1];
            }
        }
        return $queryParameters;
    }

}