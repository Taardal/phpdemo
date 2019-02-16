<?php
class Response implements JsonSerializable {

    private $code;
    private $text;
    private $data;
    private $headers;

    private function __construct($code, $text, $data = null) {
        $this->code = $code;
        $this->text = $text;
        $this->data = $data;
        $this->headers = [
            "Content-Type" => "application/json", 
            "Charset" => "UTF-8"
        ];
    }

    public static function ok($data = null) {
        return new Response(200, "OK", $data);
    }

    public static function created($location) {
        $response = new Response(201, "Created");
        $response->addHeader("Location", $location);
        return $response;
    }

    public static function badRequest() {
        return new Response(400, "Bad Request");
    }

    public static function notFound() {
        return new Response(404, "Not Found");
    }

    public static function notAllowed() {
        return new Response(405, "Not Allowed");
    }

    public static function internalServerError() {
        return new Response(500, "Internal Server Error");
    }

    public function addHeader($key, $value) {
        if (!array_key_exists($key, $this->headers)) {
            $this->headers[$key] = $value;
        }
    }

    public function send() {
        http_response_code($this->code);
        foreach ($this->headers as $key => $value) {
            header("$key: $value");
        }
        die(json_encode($this));
    }

    public function jsonSerialize() {
        $content =  [
            "code" => $this->code,
            "message" => $this->text
        ];
        if ($this->data !== null) {
            $content["data"] = $this->data;
        }
        return $content;
    }

}