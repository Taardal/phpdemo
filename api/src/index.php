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

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
$json = file_get_contents("php://input");
$request = new Request($method, $uri, $json);

$router->receive("movie", $request);
?>