<?php
require_once 'datasources/data_source.php';
require_once 'repositories/movie_repository.php';
require_once 'controllers/movie_controller.php';
require_once 'routers/router.php';
require_once 'requests/request.php';

header("Content-Type: application/json");
header("Accept: application/json");

$router = new Router();
$router->add("movie", function($request) {
    $dataSource = new DataSource();
    $movieRepository = new MovieRepository($dataSource);
    $movieController = new MovieController($movieRepository);
    $movieController->receive($request);
});

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
$json = file_get_contents("php://input");
$request = new Request($method, $uri, $json);

$router->receive($request);

function println($text) {
    print_r($text);
    echo("\n");
}

?>