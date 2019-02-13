<?php
class Response {

    private $code;
    private $body;

    public function __construct($code, $body = null) {
        $this->code = $code;
        if ($body) {
            $this->body = json_encode($body);
        }
    }

    public static function ok($body = null) {
        return new Response(200, $body);
    }

    public static function badRequest() {
        return new Response(400, "Bad Request");
    }

    public static function notFound() {
        return new Response(404, "Not Found");
    }

    public static function internalServerError() {
        return new Response(500, "Internal Server Error");
    }

    public function send() {
        http_response_code($this->code);
        die($this->body);
    }

}