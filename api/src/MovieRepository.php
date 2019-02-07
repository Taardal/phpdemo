<?php

class MovieRepository {
    
    private $dataSource;
    
    public function __construct($dataSource) {
        $this->dataSource = $dataSource;
    }
    
    public function findAll() {
        $connection = $this->dataSource->getConnection();
        $preparedStatement = $connection->prepare("SELECT * FROM movie");
        $preparedStatement->execute();
        $resultSet = $preparedStatement->get_result();
        $movies = array();
        while($row = $resultSet->fetch_assoc()) {
            $movie = array();
            $movie['id'] = $row['id'];
            $movie['title'] = $row['title'];
            array_push($movies, $movie);
        }
        $resultSet->close();
        $preparedStatement->close();
        return $movies;
    }
}

?>