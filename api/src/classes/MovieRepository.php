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
        $movies = $this->getMovies($preparedStatement);
        $preparedStatement->close();
        return $movies;
    }

    public function findById($id) {
        $connection = $this->dataSource->getConnection();
        $preparedStatement = $connection->prepare("SELECT * FROM `movie` WHERE `id` = ?");
        $preparedStatement->bind_param("s", $id);
        $preparedStatement->execute();
        $movies = $this->getMovies($preparedStatement);
        $preparedStatement->close();
        return $movies[0];
    }

    public function insert($movie) {
        $connection = $this->dataSource->getConnection();
        $preparedStatement = $connection->prepare("INSERT INTO `movie` (`imdbId`, `title`, `year`) VALUES (?, ?, ?)");
        $preparedStatement->bind_param("ssi", $movie->getImdbId(), $movie->getTitle(), $movie->getYear());
        $preparedStatement->execute();
        $id = $preparedStatement->insert_id;
        $preparedStatement->close();
        return $id != 0 ? $id : null;
    }

    public function updateById($movie, $id) {
        $connection = $this->dataSource->getConnection();
        $preparedStatement = $connection->prepare("UPDATE `movie` SET `imdbId` = ?, `title` = ?, `year` = ? WHERE `id` = ?");
        $preparedStatement->bind_param("ssii", $movie->getImdbId(), $movie->getTitle(), $movie->getYear(), $id);
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

    private function getMovies($preparedStatement) {
        $movies = [];
        $resultSet = $preparedStatement->get_result();
        while($row = $resultSet->fetch_assoc()) {
            $movies[] = Movie::jsonDeserialize(json_encode($row));
        };
        $resultSet->close();
        return $movies;
    }

}