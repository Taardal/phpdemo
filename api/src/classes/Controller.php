<?php
abstract class Controller {

    public function receive($request) {
        switch ($request->getMethod()) {
            case "GET":
                $this->receiveGet($request);
                break;
            default:
                Response::notFound()->send();
        }
    }

    protected function receiveGet($request) {
        Response::notFound()->send();
    }

}