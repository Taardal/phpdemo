<?php
abstract class Controller {

    public function receive($request) {
        switch ($request->getMethod()) {
            case "GET":
                $this->receiveGet($request);
                break;
            case "POST":
                $this->receivePost($request);
                break;
            case "PUT":
                $this->receivePut($request);
                break;
            case "DELETE":
                $this->receiveDelete($request);
                break;    
            default:
                Response::notFound()->send();
        }
    }

    protected function receiveGet($request) {
        Response::notFound()->send();
    }

    protected function receivePost($request) {
        Response::notFound()->send();
    }

    protected function receivePut($request) {
        Response::notFound()->send();
    }

    protected function receiveDelete($request) {
        Response::notFound()->send();
    }

}