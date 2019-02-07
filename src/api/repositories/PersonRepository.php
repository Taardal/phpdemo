<?php
require_once 'models/Person.php';

class PersonRepository {

    private $dataSource;

    public function __construct($dataSource) {
        $this->dataSource = $dataSource;
    }

    public function findAll() {
        $connection = $this->dataSource->getConnection();
        $preparedStatement = $connection->prepare("SELECT * FROM person");
        $preparedStatement->execute();
        $resultSet = $preparedStatement->get_result();
        $persons = array();
        while($row = $resultSet->fetch_assoc()) {
            $person = new Person();
            $person->setFirstName(utf8_encode($row["first_name"]));
            $person->setLastName(utf8_encode($row["last_name"]));
            array_push($persons, $person);
        }
        $resultSet->close();
        $preparedStatement->close();
        return $persons;
    }

}