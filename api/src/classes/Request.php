<?php
class Request {

    private $headers;
    private $method;
    private $body;
    private $uri;
    private $url;
    private $pathParameters;
    private $queryParameters;

    private function __construct() {
        $this->headers = getallheaders();
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->uri = $_SERVER['REQUEST_URI'];
        if ($this->uri) {
            $this->url = parse_url($this->uri);
            $this->pathParameters = $this->parsePathParameters();
            $this->queryParameters = $this->parseQueryParameters();
        }
        if ($this->method == POST || $this->method == PUT) {
            $this->body = file_get_contents("php://input");
        }
    }

    public static function createFromGlobals() {
        return new Request();
    }

    public function getHeaders() {
        return $this->headers;
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
        return $this->url['path'];
    }

    public function getQuery() {
        return $this->url['query'];
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