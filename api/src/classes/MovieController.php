<?php
class MovieController extends Controller {
    
    public const RESOURCE = RX_SLASH . "movies";
    private const COLLECTION_RESOURCE = self::RESOURCE . RX_URL_END;
    private const SPECIFIC_RESOURCE = self::RESOURCE . RX_SLASH . RX_NUMBERS . RX_URL_END;
    
    private $movieRepository;

    public function __construct($movieRepository) {
        parent::__construct();
        $this->movieRepository = $movieRepository;
    }

    protected function getResources() {
        return [
            self::COLLECTION_RESOURCE => [
                GET => function($request) {
                    return $this->getMultiple($request);
                },
                POST => function($request) {
                    return $this->insertSingle($request);
                },
                PUT => function($request) {
                    return $this->updateMultiple($request);
                },
                DELETE => function($request) {
                    return $this->deleteMultiple($request);
                }
            ],
            self::SPECIFIC_RESOURCE => [
                GET => function($request) {
                    return $this->getSingle($request);
                },
                PUT => function($request) {
                    return $this->updateSingle($request);
                },
                DELETE => function($request) {
                    return $this->deleteSingle($request);
                }
            ]
        ];
    }

    private function getMultiple($request) {
        $movies = $this->movieRepository->findAll();
        return Response::ok($movies ?: []);
    }

    private function getSingle($request) {
        $id = end($request->getPathParameters());
        $movie = $this->movieRepository->findById($id);
        return $movie ? Response::ok($movie) : Response::notFound();
    }
    
    private function insertSingle($request) {
        $movie = Movie::jsonDeserialize($request->getBody());
        $id = $this->movieRepository->insert($movie);
        if ($id > 0) {
            $location = $request->getPath() . "/$id";
            return Response::created($location);
        } else {
            return Response::badRequest();
        }
    }

    private function updateMultiple($request) {
        $movies = Movie::jsonDeserializeMultiple($request->getBody());
        $rowsAffected = $this->movieRepository->update($movies);
        return $rowsAffected > 0 ? Response::ok() : Response::badRequest();
    }

    private function updateSingle($request) {
        $id = end($request->getPathParameters());
        $movie = Movie::jsonDeserialize($request->getBody());
        if ($movie->getId() != $id) {
            $movie->setId($id);
        }
        $rowsAffected = $this->movieRepository->update([$movie]);
        return $rowsAffected > 0 ? Response::ok() : Response::badRequest();
    }

    private function deleteMultiple($request) {
        $rowsAffected = $this->movieRepository->deleteAll();
        return $rowsAffected > 0 ? Response::ok() : Response::badRequest();
    }

    private function deleteSingle($request) {
        $id = end($request->getPathParameters());
        $rowsAffected = $this->movieRepository->deleteById($id);
        return $rowsAffected > 0 ? Response::ok() : Response::badRequest();
    }

}
