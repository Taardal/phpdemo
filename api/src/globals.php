<?php
const HTTP_GET = "GET";
const HTTP_POST = "POST";
const HTTP_PUT = "PUT";
const HTTP_DELETE = "DELETE";
const RX_SLASH = "\\/";
const RX_OPTIONAL_SLASH = "(" . RX_SLASH . ")?";
const RX_URL_END = RX_OPTIONAL_SLASH . "$";
const RX_LETTERS_OR_NUMBERS = "([A-Za-z0-9]+)";

function println($variable) {
    print_r($variable);
    echo("\n");
}

function str_numeric($string) {
    return $string && strlen($string) > 0 && ctype_digit($string);
}

function str_begins_with($target, $string) {
    $start = 0;
    $end = $start + strlen($target);
    return $string && strlen($string) > 0 && substr($string, $start, $end) === $target;
}

function str_ends_with($target, $string) {
    return $string && strlen($string) > 0 && substr($string, -strlen($target)) === $target;
}
