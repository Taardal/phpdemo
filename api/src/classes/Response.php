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
        $this->headers = [];
    }

    public static function ok($data = null) {
        return new Response(200, "OK", $data);
    }

    public static function created($location) {
        $response = new Response(201, "Created");
        $response->addHeader("Location: $location");
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

    public function addHeader($header) {
        $this->headers[] = $header;
    }

    public function send() {
        http_response_code($this->code);
        foreach ($this->headers as $header) {
            header($header);
        }
        die(json_encode($this));
    }

    public function jsonSerialize() {
        $toBeSerialized =  [
            "code" => $this->code,
            "message" => $this->text
        ];
        if ($this->data) {
            $toBeSerialized["data"] = $this->data;
        }
        return $toBeSerialized;
    }

}