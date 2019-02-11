<?php
require_once 'autoload.php';
require_once 'print.php';

header("Content-Type: application/json");
header("Accept: application/json");

$router = new Router();
$dataSource = new DataSource();

$router->add("movie", function($request) use ($dataSource) {
    $movieRepository = new MovieRepository($dataSource);
    $movieController = new MovieController($movieRepository);
    $movieController->receive($request);
});

$request = new Request();
$router->receive("movie", $request);