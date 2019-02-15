<?php
class MovieController extends Controller {

    public const RESOURCE = RX_SLASH . "movie";
    private const COLLECTION_RESOURCE = self::RESOURCE . RX_URL_END;
    private const SPECIFIC_RESOURCE = self::RESOURCE . RX_SLASH . RX_LETTERS_OR_NUMBERS . RX_URL_END;
    
    private $movieRepository;

    public function __construct($movieRepository) {
        parent::__construct();
        $this->movieRepository = $movieRepository;
    }

    protected function getResources() {
        return [
            self::COLLECTION_RESOURCE => [
                HTTP_GET => function($request) {
                    return $this->getAll();
                },
                HTTP_POST => function($request) {
                    return $this->createSingle($request);
                }, 
                HTTP_PUT => function($request) {
                    return $this->updateMultiple($request);
                },
                HTTP_DELETE => function($request) {
                    return $this->deleteAll($request);
                }
            ],
            self::SPECIFIC_RESOURCE => [
                HTTP_GET => function($request) {
                    return $this->getById($request);
                },
                HTTP_PUT => function($request) {
                    return $this->updateById($request);
                },
                HTTP_DELETE => function($request) {
                    return $this->deleteById($request);
                }
            ]
        ];
    }

    private function getAll() {
        $movies = $this->movieRepository->findAll();
        return Response::ok($movies);   
    }

    private function getById($request) {
        $pathParameters = $request->getPathParameters();
        $id = $pathParameters[sizeof($pathParameters) - 1];
        $movie = $this->movieRepository->findById($id);
        return $movie ? Response::ok($movie) : Response::notFound();
    }

    private function createSingle($request) {
        return Response::notAllowed();
    }

    private function updateMultiple($request) {
        return Response::notAllowed();
    }

    private function updateById($request) {
        return Response::notAllowed();
    }

    private function deleteAll($request) {
        return Response::notAllowed();
    }

    private function deleteById($request) {
        return Response::notAllowed();
    }

}
