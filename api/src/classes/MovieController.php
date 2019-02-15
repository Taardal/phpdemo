<?php
class MovieController {

    private $movieRepository;

    public function __construct($movieRepository) {
        $this->movieRepository = $movieRepository;
    }

    public function getMultiple() {
        $movies = $this->movieRepository->findAll();
        return Response::ok($movies);
    }

    public function getById($id) {
        $movie = $this->movieRepository->findById($id);
        return $movie ? Response::ok($movie) : Response::notFound();
    }

    public function createSingle($movie) {
        $id = $this->movieRepository->insert($movie);
        if ($id) {
            $location = $request->getPath() . "/$id";
            return Response::created($location);
        } else {
            return Response::badRequest();
        }
    }

    public function updateSingle($movie, $id) {
        $updated = $this->movieRepository->updateById($movie, $id);
        return $updated ? Response::ok() : Response::badRequest();
    }

    public function deleteSingle($id) {
        $deleted = $this->movieRepository->deleteById($id);
        return $deleted ? Response::ok() : Response::badRequest();
    }

}
