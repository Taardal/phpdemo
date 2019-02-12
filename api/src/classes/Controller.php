<?php
abstract class Controller {

    public abstract function receive($request);

    protected function respondOk($data) {
        echo json_encode($data);
    }

}