<?php
class GenreController extends Controller {

    public const RESOURCE = RX_SLASH . "genres";
    private const COLLECTION_RESOURCE = self::RESOURCE . RX_URL_END;
    
    private $genreRepository;

    public function __construct($genreRepository) {
        parent::__construct();
        $this->genreRepository = $genreRepository;
    }

    protected function getResources() {
        return [
            self::COLLECTION_RESOURCE => [
                GET => function($request) {
                    return $this->getMultiple($request);
                }
            ]
        ];
    }

    private function getMultiple($request) {
        $genres = $this->genreRepository->findAll();
        return Response::ok($genres ?: []);
    }

}