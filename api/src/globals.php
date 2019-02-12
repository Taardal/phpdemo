<?php

function println($variable) {
    print_r($variable);
    echo("\n");
}

function isNumeric($string) {
    return $string != null && strlen($string) > 0 && ctype_digit($string);
}
