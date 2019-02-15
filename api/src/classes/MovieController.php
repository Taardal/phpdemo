<?php
class MovieController {

    private $movieRepository;

    public function __construct($movieRepository) {
        parent::__construct();
        $this->movieRepository = $movieRepository;
    }

    public function getMultiple() {
        try {
            $movies = $this->movieRepository->findAll();
            return Response::ok($movies);
        } catch (Exception $e) {
            return Response::internalServerError();
        }   
    }

    public function getById($id) {
        try {
            $movie = $this->movieRepository->findById($id);
            return $movie ? Response::ok($movie) : Response::notFound();    
        } catch (Exception $e) {
            return Response::internalServerError();
        }
    }

    public function createSingle($movie) {
        try {
            $id = $this->movieRepository->insert($movie);
            if ($id) {
                $location = $request->getPath() . "/$id";
                return Response::created($location);
            } else {
                return Response::badRequest();
            }
        } catch (Exception $e) {
            return Response::internalServerError();
        }
    }

    public function updateSingle($movie, $id) {
        try {
            $updated = $this->movieRepository->updateById($movie, $id);
            return $updated ? Response::ok() : Response::badRequest();
        } catch (Exception $e) {
            return Response::internalServerError();
        }
    }

    public function deleteSingle($id) {
        try {
            $deleted = $this->movieRepository->deleteById($id);
            return $deleted ? Response::ok() : Response::badRequest();
        } catch (Exception $e) {
            return Response::internalServerError();
        }
    }

}
