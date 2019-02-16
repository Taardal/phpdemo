<?php
class Movie implements JsonSerializable {

    public const ID = "id";
    public const IMDB_ID = "imdbId";
    public const TITLE = "title";
    public const YEAR = "year";
    public const GENRES = "genres";

    private $id;
    private $imdbId;
    private $title;
    private $year;
    private $genres;

    public function jsonSerialize() {
        return [
            self::ID => $this->id,
            self::IMDB_ID => $this->imdbId,
            self::TITLE => $this->title,
            self::YEAR => $this->year,
            self::GENRES => $this->genres
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

    public function getGenres() {
        return $this->genres;
    }

    public function setGenres($genres) {
        $this->genres = $genres;
    }

}