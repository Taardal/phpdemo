<?php
class Movie implements JsonSerializable {

    private const ID = "id";
    private const IMDB_ID = "imdbId";
    private const TITLE = "title";
    private const YEAR = "year";

    private $id;
    private $imdbId;
    private $title;
    private $year;

    public static function jsonDeserialize($json) {
        $decoded = (array) json_decode($json);
        $movie = new Movie();
        $movie->setId($decoded[self::ID]);
        $movie->setImdbId($decoded[self::IMDB_ID]);
        $movie->setTitle($decoded[self::TITLE]);
        $movie->setYear($decoded[self::YEAR]);
        return $movie;
    }

    public function jsonSerialize() {
        return [
            self::ID => $this->id,
            self::TITLE => $this->title,
            self::YEAR => $this->year,
        ];
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getImdbId() {
        return $this->imdbId;
    }

    public function setImdbId($imdbId) {
        $this->imdbId = $imdbId;
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

}