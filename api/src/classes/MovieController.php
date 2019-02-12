<?php
class MovieController extends Controller {

    public const ROUTE = "movie";
    public const GET_ALL_REGEX = "/\\/" . self::ROUTE . "(\\/)?$/";
    public const GET_BY_ID_REGEX = "/\\/" . self::ROUTE . "\\/([A-Za-z0-9]+)$/";
    
    private $movieRepository;

    public function __construct($movieRepository) {
        $this->movieRepository = $movieRepository;
    }

    public function receive($request) {
        switch ($request->getMethod()) {
            case "GET":
                $this->receiveGet($request);
                break;
            default:
                echo "Invalid request method";
        }
    }

    private function receiveGet($request) {
        if (preg_match(self::GET_ALL_REGEX, $request->getPath())) {
            $this->getAll();
        } else if (preg_match(self::GET_BY_ID_REGEX, $request->getPath())) {
            $this->getById($request);
        } else {
            http_response_code(404);
            die("Invalid path");
        }
    }

    private function getAll() {
        $movies = $this->movieRepository->findAll();
        $this->respondOk($movies);    
    }

    private function getById($request) {
        $id = $request->getPathParameters()[1];
        $movie = $this->movieRepository->findById($id);
        $this->respondOk($movie);    
    }

}
