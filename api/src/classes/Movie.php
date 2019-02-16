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

    public static function fromAssociativeArray($item) {
        $movie = new Movie();
        $movie->setId($item[self::ID]);
        $movie->setImdbId($item[self::IMDB_ID]);
        $movie->setTitle($item[self::TITLE]);
        $movie->setYear($item[self::YEAR]);
        return $movie;
    }

    public static function jsonDeserializeMultiple($json) {
        $items = (array) json_decode($json);
        $movies = [];
        foreach ($items as $item) {
            $movies[] = self::fromAssociativeArray((array) $item);
        }
        return $movies;
    }

    public static function jsonDeserialize($json) {
        $item = (array) json_decode($json);
        return self::fromAssociativeArray($item);
    }

    public function jsonSerialize() {
        return [
            self::ID => $this->id,
            self::IMDB_ID => $this->imdbId,
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