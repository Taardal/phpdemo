<?php
require_once 'autoload.php';
require_once 'globals.php';

try {
    $application = new Application();
    $application->receive(Request::createFromGlobals());
} catch (Throwable $e) {
    error_log($e);
    Response::internalServerError()->send();
}
