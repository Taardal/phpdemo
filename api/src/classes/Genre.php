<?php
class Genre implements JsonSerializable {
    
    public const ID = "id";
    public const NAME = "name";

    private $id;
    private $name;

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

}