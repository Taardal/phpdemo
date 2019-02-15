<?php
class MovieRepository {
    
    private $dataSource;
    
    public function __construct($dataSource) {
        $this->dataSource = $dataSource;
    }
    
    public function findAll() {
        $connection = $this->dataSource->getConnection();
        $preparedStatement = $connection->prepare("SELECT * FROM `movie`");
        $preparedStatement->execute();
        $results = $this->getResults($preparedStatement);
        $preparedStatement->close();
        return $results;
    }

    public function findById($id) {
        $connection = $this->dataSource->getConnection();
        $preparedStatement = $connection->prepare("SELECT * FROM `movie` WHERE `id` = ?");
        $preparedStatement->bind_param("s", $id);
        $preparedStatement->execute();
        $results = $this->getResults($preparedStatement);
        $preparedStatement->close();
        return $results[0];
    }

    public function insert($movie) {
        $connection = $this->dataSource->getConnection();
        $preparedStatement = $connection->prepare("INSERT INTO `movie` (`imdbId`, `title`, `year`) VALUES (?, ?, ?)");
        $preparedStatement->bind_param("ssi", $movie['imdbId'], $movie['title'], $movie['year']);
        $preparedStatement->execute();
        $id = $preparedStatement->insert_id;
        $preparedStatement->close();
        return $id != 0 ? $id : null;
    }

    public function updateById($movie, $id) {
        $connection = $this->dataSource->getConnection();
        $preparedStatement = $connection->prepare("UPDATE `movie` SET `imdbId` = ?, `title` = ?, `year` = ? WHERE `id` = ?");
        $preparedStatement->bind_param("ssii", $movie['imdbId'], $movie['title'], $movie['year'], $id);
        $preparedStatement->execute();
        $affectedRows = $preparedStatement->affected_rows;
        $preparedStatement->close();
        return $affectedRows > 0;
    }

    public function deleteById($id) {
        $connection = $this->dataSource->getConnection();
        $preparedStatement = $connection->prepare("DELETE FROM `movie` WHERE `id` = ?");
        $preparedStatement->bind_param("i", $id);
        $preparedStatement->execute();
        $affectedRows = $preparedStatement->affected_rows;
        $preparedStatement->close();
        return $affectedRows > 0;
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
        $movie = [];
        $movie['id'] = $row['id'];
        $movie['title'] = $row['title'];
        $movie['year'] = $row['year'];
        return $movie;
    }

}