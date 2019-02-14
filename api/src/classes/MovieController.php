<?php
class MovieController extends Controller {

    public const RESOURCE = "\\/movie";
    private const COLLECTION_RESOURCE = self::RESOURCE . "(\\/)?$";
    private const SPECIFIC_RESOURCE = self::RESOURCE . "\\/([A-Za-z0-9]+)(\\/)?$";
    
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
                    return $this->create($request);
                }, 
                HTTP_PUT => function($request) {
                    return $this->update($request);
                },
                HTTP_DELETE => function($request) {
                    return $this->delete($request);
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

    private function create($request) {
        return Response::notAllowed();
    }

    private function update($request) {
        return Response::notAllowed();
    }

    private function updateById($request) {
        return Response::notAllowed();
    }

    private function delete($request) {
        return Response::notAllowed();
    }

    private function deleteById($request) {
        return Response::notAllowed();
    }

}
