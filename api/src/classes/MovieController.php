<?php
class MovieController extends Controller {
    
    public const RESOURCE = RX_SLASH . "movies";
    private const COLLECTION_RESOURCE = self::RESOURCE . RX_URL_END;
    private const SPECIFIC_RESOURCE = self::RESOURCE . RX_SLASH . RX_NUMBERS . RX_URL_END;
    
    private $movieService;
    private $movieDeserializer;

    public function __construct($movieService) {
        parent::__construct();
        $this->movieService = $movieService;
        $this->movieDeserializer = new MovieDeserializer();
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
        $movies = $this->movieService->getAll();
        return Response::ok($movies);
    }

    private function getSingle($request) {
        $id = end($request->getPathParameters());
        $movie = $this->movieService->getById($id);
        return $movie ? Response::ok($movie) : Response::notFound();
    }
    
    private function insertSingle($request) {
        $movie = $this->movieDeserializer->deserializeJson($request->getBody());
        $id = $this->movieService->create($movie);
        if ($id) {
            $location = $request->getPath() . "/$id";
            return Response::created($location);
        } else {
            return Response::badRequest();
        }
    }

    private function updateMultiple($request) {
        $movies = $this->movieDeserializer->deserializeJsonArray($request->getBody());
        $updated = $this->movieService->update($movies);
        return $updated ? Response::ok() : Response::badRequest();
    }

    private function updateSingle($request) {
        $id = end($request->getPathParameters());
        $movie = $this->movieDeserializer->deserializeJson($request->getBody());
        $updated = $this->movieService->updateById($movie, $id);
        return $updated ? Response::ok() : Response::badRequest();
    }

    private function deleteMultiple($request) {
        $deleted = $this->movieService->deleteAll();
        return $deleted ? Response::ok() : Response::badRequest();
    }

    private function deleteSingle($request) {
        $id = end($request->getPathParameters());
        $deleted = $this->movieService->deleteById($id);
        return $deleted ? Response::ok() : Response::badRequest();
    }

}
