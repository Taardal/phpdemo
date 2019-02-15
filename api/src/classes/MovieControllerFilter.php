<?php 
class MovieControllerFilter extends ControllerFilter {
    
    public const RESOURCE = RX_SLASH . "movie";
    private const COLLECTION_RESOURCE = self::RESOURCE . RX_URL_END;
    private const SPECIFIC_RESOURCE = self::RESOURCE . RX_SLASH . RX_NUMBERS . RX_URL_END;
    
    private $movieController;
    
    public function __construct($movieController) {
        $this->movieController = $movieController;
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
                    return $this->getById($request);
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
        return $this->movieController->getMultiple();
    }

    private function getById($request) {
        $id = end($request->getPathParameters());
        return $this->movieController->getById($id);
    }
    
    private function insertSingle($request) {
        $body = $request->getBody();
        if ($body) {
            $movie = (array) json_decode($body);
        }
        return $this->movieController->insertSingle($movie);
    }

    private function updateSingle($request) {
        $id = end($request->getPathParameters());
        $body = $request->getBody();
        if ($body) {
            $movie = (array) json_decode($body);
        }
        return $this->movieController->updateSingle($movie, $id);
    }

    private function deleteSingle($request) {
        $id = end($request->getPathParameters());
        return $this->movieController->deleteSingle($id);
    }

}