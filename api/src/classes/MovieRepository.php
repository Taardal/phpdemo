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
            array_push($movies, $this->getMovie($row));
        }
        $resultSet->close();
        $preparedStatement->close();
        return $movies;
    }

    public function findById($id) {
        $connection = $this->dataSource->getConnection();
        $preparedStatement = $connection->prepare("SELECT * FROM movie WHERE id = ?");
        $preparedStatement->bind_param("s", $id);
        $preparedStatement->execute();
        $resultSet = $preparedStatement->get_result();
        while($row = $resultSet->fetch_assoc()) {
            $movie = $this->getMovie($row);
        }
        $resultSet->close();
        $preparedStatement->close();
        return $movie;
    }

    private function getMovie($row) {
        $movie = new Movie();
        $movie->setId($row['id']);
        $movie->setTitle($row['title']);
        $movie->setYear($row['year']);
        return $movie;
    }

}