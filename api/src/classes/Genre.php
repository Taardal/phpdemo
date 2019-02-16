<?php
class Genre implements JsonSerializable {
    
    private const ID = "id";
    private const NAME = "name";

    private $id;
    private $name;

    public static function jsonDeserializeMultiple($json) {
        $items = (array) json_decode($json);
        $genres = [];
        foreach ($items as $item) {
            $genres[] = self::fromAssociativeArray((array) $item);
        }
        return $genres;
    }

    public static function jsonDeserialize($json) {
        return self::fromAssociativeArray((array) json_decode($json));
    }

    public function jsonSerialize() {
        return [
            self::ID => $this->id,
            self::NAME => $this->name
        ];
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    private static function fromAssociativeArray($associativeArray) {
        $genre = new Genre();
        $genre->setId($associativeArray[self::ID]);
        $genre->setName($associativeArray[self::NAME]);
        return $genre;
    }

}