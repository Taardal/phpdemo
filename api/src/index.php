<?php
require_once 'autoload.php';
require_once 'globals.php';

header("Content-Type: application/json");
header("Accept: application/json");

$router = new Router();
$dataSource = new DataSource();

$router->addResource(MovieController::RESOURCE, function ($request) use ($dataSource) {
    $movieRepository = new MovieRepository($dataSource);
    $movieController = new MovieController($movieRepository);
    $movieController->receive($request);
});

$router->receive(Request::createFromGlobals());
