<?php
class Movie implements JsonSerializable {

    private const ID = "id";
    private const IMDB_ID = "imdbId";
    private const TITLE = "title";
    private const YEAR = "year";
    private const GENRES = "genres";

    private $id;
    private $imdbId;
    private $title;
    private $year;
    private $genres;

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

    private static function fromAssociativeArray($associativeArray) {
        $movie = new Movie();
        $movie->setId($associativeArray[self::ID]);
        $movie->setImdbId($associativeArray[self::IMDB_ID]);
        $movie->setTitle($associativeArray[self::TITLE]);
        $movie->setYear($associativeArray[self::YEAR]);
        $movie->setGenres(self::parseGenres($associativeArray));
        return $movie;
    }

    private static function parseGenres($associativeArray) {
        $genresJson = json_encode($associativeArray[self::GENRES]);
        return (array) Genre::jsonDeserializeMultiple($genresJson);
    }

}