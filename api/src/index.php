<?php
require_once 'autoload.php';
require_once 'globals.php';

try {
    $router = new Router();
    $dataSource = new DataSource();

    $router->addResource(MovieController::RESOURCE, function ($request) use ($dataSource) {
        $genreRepository = new GenreRepository($dataSource);
        $movieRepository = new MovieRepository($dataSource);
        $movieService = new MovieService($movieRepository, $genreRepository);
        $movieController = new MovieController($movieService);
        $movieController->receive($request);
    });
    $router->addResource(GenreController::RESOURCE, function ($request) use ($dataSource) {
        $genreRepository = new GenreRepository($dataSource);
        $genreController = new GenreController($genreRepository);
        $genreController->receive($request);
    });

    $router->receive(Request::createFromGlobals());

} catch (Throwable $e) {
    error_log($e);
    Response::internalServerError()->send();
}
