<?php
class MovieController extends Controller {

    public const ROUTE = "movie";
    
    private $movieRepository;

    public function __construct($movieRepository) {
        $this->movieRepository = $movieRepository;
    }

    protected function receiveGet($request) {
        if ($this->isGetAll($request)) {
            $this->getAll();
        } else if ($this->isGetById($request)) {
            $this->getById($request);
        } else {
            parent::receiveGet($request);
        }
    }

    private function isGetAll($request) {
        $regex = "/\\/" . self::ROUTE . "(\\/)?$/";
        return preg_match($regex, $request->getPath());
    }

    private function getAll() {
        $movies = $this->movieRepository->findAll();
        Response::ok($movies)->send();    
    }

    private function isGetById($request) {
        $regex = "/\\/" . self::ROUTE . "\\/([A-Za-z0-9]+)$/";
        return preg_match($regex, $request->getPath());
    }

    private function getById($request) {
        $id = $request->getPathParameters()[sizeof($request->getPathParameters()) - 1];
        $movie = $this->movieRepository->findById($id);
        Response::ok($movie)->send(); 
    }

}
