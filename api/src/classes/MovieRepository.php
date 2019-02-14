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
        $results = $this->getResults($preparedStatement);
        $preparedStatement->close();
        return $results;
    }

    public function findById($id) {
        $connection = $this->dataSource->getConnection();
        $preparedStatement = $connection->prepare("SELECT * FROM movie WHERE id = ?");
        $preparedStatement->bind_param("s", $id);
        $preparedStatement->execute();
        $results = $this->getResults($preparedStatement);
        $preparedStatement->close();
        return $results[0];
    }

    private function getResults($preparedStatement) {
        $results = [];
        $resultSet = $preparedStatement->get_result();
        while($row = $resultSet->fetch_assoc()) {
            $results[] = $this->getMovie($row);
        };
        $resultSet->close();
        return $results;
    }

    private function getMovie($row) {
        $movie = new Movie();
        $movie->setId($row['id']);
        $movie->setTitle($row['title']);
        $movie->setYear($row['year']);
        return $movie;
    }

}