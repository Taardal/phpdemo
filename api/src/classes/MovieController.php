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
        return Response::ok($movies);
    }

    private function getSingle($request) {
        $id = end($request->getPathParameters());
        $movie = $this->movieRepository->findById($id);
        return $movie ? Response::ok($movie) : Response::notFound();
    }
    
    private function insertSingle($request) {
        $movie = Movie::jsonDeserialize($request->getBody());
        $id = $this->movieRepository->insert($movie);
        if ($id) {
            $location = $request->getPath() . "/$id";
            return Response::created($location);
        } else {
            return Response::badRequest();
        }
    }

    private function updateSingle($request) {
        $id = end($request->getPathParameters());
        $movie = Movie::jsonDeserialize($request->getBody());
        $updated = $this->movieRepository->updateById($movie, $id);
        return $updated ? Response::ok() : Response::badRequest();
    }

    private function deleteSingle($request) {
        $id = end($request->getPathParameters());
        $deleted = $this->movieRepository->deleteById($id);
        return $deleted ? Response::ok() : Response::badRequest();
    }

}
