<?php
class GenreDeserializer {

    public function deserializeJsonArray($jsonArray) {
        $items = (array) json_decode($jsonArray);
        $genres = [];
        foreach ($items as $item) {
            $genres[] = $this->createFromAssociativeArray((array) $item);
        }
        return $genres;
    }

    public function deserializeJson($json) {
        return $this->createFromAssociativeArray((array) json_decode($json));
    }

    private function createFromAssociativeArray($associativeArray) {
        $genre = new Genre();
        $genre->setId($associativeArray[Genre::ID]);
        $genre->setName($associativeArray[Genre::NAME]);
        return $genre;
    }

}