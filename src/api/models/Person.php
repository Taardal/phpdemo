<?php
class Person implements JsonSerializable {

    private $firstName;
    private $lastName;

    public function getFirstName() {
        return $this->firstName;
    }

    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function setLastName($lastName) {
        $this->lastName = $lastName;
    }

    public function jsonSerialize() {
        return array(
            'firstName' => $this->firstName,
            'lastName' => $this->lastName
        );
    }

}