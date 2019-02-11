<?php
class Request {

    private $method;
    private $uri;
    private $body;

    public function __construct() {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->body = $this->parseJson();
    }

    public function getMethod() {
        return $this->method;
    }

    public function getUri() {
        return $this->uri;
    }

    public function getBody() {
        return $this->body;
    }

    private function parseJson() {
        if ($this->method == "POST" || $this->method == "PUT") {
            $json = file_get_contents("php://input");
            if ($json != null && strlen($json) > 0) {
                return json_decode($json);
            }
        }
        return array();
    }

}