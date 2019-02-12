<?php
require_once 'autoload.php';
require_once 'globals.php';

header("Content-Type: application/json");
header("Accept: application/json");

$router = new Router();
$dataSource = new DataSource();

$router->add(MovieController::ROUTE, function($request) use ($dataSource) {
    $movieController = new MovieController(new MovieRepository($dataSource));
    $movieController->receive($request);
});

$router->receive(new Request());