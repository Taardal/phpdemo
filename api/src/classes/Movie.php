<?php
class Movie implements JsonSerializable {

    private $id;
    private $title;
    private $year;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getYear() {
        return $this->year;
    }

    public function setYear($year) {
        $this->year = $year;
    }

    public function jsonSerialize() {
        return array(
            'id' => $this->id,
            'title' => $this->title,
            'year' => $this->year,
        );
    }

}