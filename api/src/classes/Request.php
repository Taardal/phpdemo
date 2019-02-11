<?php

class Request {

    private $method;
    private $uri;
    private $body;

    public function __construct($method, $uri, $json) {
        $this->method = $method;
        $this->uri = $uri;
        $this->body = $this->parseJson($json);
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

    private function parseJson($json) {
        if ($this->method == "POST" || $this->method == "PUT") {
            if ($json != null && strlen($json) > 0) {
                return json_decode($json);
            }
        }
        return array();
    }

}