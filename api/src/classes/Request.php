<?php
class Request {

    private $method;
    private $uri;
    private $url;
    private $body;

    public function __construct() {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->url = parse_url($this->uri);
        $this->body = $this->parseBody();
    }

    public function getMethod() {
        return $this->method;
    }

    public function getUri() {
        return $this->uri;
    }

    public function getUrl() {
        return $this->uri;
    }

    public function getPath() {
        return $this->url['path'];
    }

    public function getPathParameters() {
        return array_slice(explode("/", $this->getPath()), 1);
    }

    public function getQuery() {
        return $this->url['query'];
    }

    public function getBody() {
        return $this->body;
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