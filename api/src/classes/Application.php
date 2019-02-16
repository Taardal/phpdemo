<?php
class Application {

    private $router;
    private $dataSource;

    public function __construct() {
        $this->router = new Router();
        $this->dataSource = new DataSource();
        $this->addResources();
    }

    public function receive($request) {
        $this->router->receive($request);
    }

    private function addResources() {
        $this->router->addResource(MovieController::RESOURCE, function ($request) {
            $this->getMovieController()->receive($request);
        });
        $this->router->addResource(GenreController::RESOURCE, function ($request) {
            $this->getGenreController()->receive($request);
        });
    }

    private function getMovieController() {
        $genreRepository = new GenreRepository($this->dataSource);
        $movieRepository = new MovieRepository($this->dataSource);
        $movieService = new MovieService($movieRepository, $genreRepository);
        return new MovieController($movieService);
    }

    private function getGenreController() {
        $genreRepository = new GenreRepository($this->dataSource);
        return new GenreController($genreRepository);
    }

}