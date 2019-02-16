<?php
class MovieDeserializer {

    private $genreDeserializer;

    public function __construct() {
        $this->genreDeserializer = new GenreDeserializer();
    }

    public function deserializeJsonArray($json) {
        $items = (array) json_decode($json);
        $movies = [];
        foreach ($items as $item) {
            $movies[] = $this->createFromAssociativeArray((array) $item);
        }
        return $movies;
    }

    public function deserializeJson($json) {
        $item = (array) json_decode($json);
        return $this->createFromAssociativeArray($item);
    }

    private function createFromAssociativeArray($associativeArray) {
        $movie = new Movie();
        $movie->setId($associativeArray[Movie::ID]);
        $movie->setImdbId($associativeArray[Movie::IMDB_ID]);
        $movie->setTitle($associativeArray[Movie::TITLE]);
        $movie->setYear($associativeArray[Movie::YEAR]);
        $movie->setGenres($this->getGenres($associativeArray));
        return $movie;
    }

    private function getGenres($associativeArray) {
        $genresJsonArray = json_encode($associativeArray[Movie::GENRES]);
        return $this->genreDeserializer->deserializeJsonArray($genresJsonArray);
    }

}