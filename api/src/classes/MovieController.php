<?php
class MovieController extends Controller {

    public const ROUTE = "movie";
    private const GET_ALL_ROUTE = "\\/" . self::ROUTE . "(\\/)?$";
    private const GET_BY_ID_ROUTE = "\\/" . self::ROUTE . "\\/([A-Za-z0-9]+)(\\/)?$";
    
    private $movieRepository;

    public function __construct($movieRepository) {
        parent::__construct();
        $this->movieRepository = $movieRepository;
    }

    protected function registerRoutes() {
        $this->registerRoute(HTTP_GET, self::GET_ALL_ROUTE, function($request) {
            $this->getAll();
        });
        $this->registerRoute(HTTP_GET, self::GET_BY_ID_ROUTE, function($request) {
            $this->getById($request);
        });
    }

    private function getAll() {
        $movies = $this->movieRepository->findAll();
        Response::ok($movies)->send();    
    }

    private function getById($request) {
        $id = $request->getPathParameters()[sizeof($request->getPathParameters()) - 1];
        $movie = $this->movieRepository->findById($id);
        $response = $movie ? Response::ok($movie) : Response::notFound();
        $response->send(); 
    }

}
