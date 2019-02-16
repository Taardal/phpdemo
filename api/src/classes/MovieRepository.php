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
        $preparedStatement->bind_param("i", $id);
        $preparedStatement->execute();
        $movies = $this->getMovies($preparedStatement);
        $preparedStatement->close();
        return $movies[0];
    }

    public function insert($movie) {
        $sql = "INSERT INTO `movie` (`imdb_id`, `title`, `year`) VALUES (?, ?, ?)";
        $sqlParameters = [
            $movie->getImdbId(), 
            $movie->getTitle(), 
            $movie->getYear()
        ];        
        $connection = $this->dataSource->getConnection();
        $preparedStatement = $connection->prepare($sql);
        $preparedStatement->bind_param("ssi", ...$sqlParameters);
        $preparedStatement->execute();
        $id = $preparedStatement->insert_id;
        $preparedStatement->close();
        return $id;
    }

    public function update($movies) {
        $sql = "UPDATE `movie` SET `imdb_id` = ?, `title` = ?, `year` = ? WHERE `id` = ?";
        $connection = $this->dataSource->getConnection();
        $preparedStatement = $connection->prepare($sql);
        $preparedStatement->bind_param("ssii", $imdbId, $title, $year, $id);
        $affectedRows = 0;
        foreach ($movies as $movie) {
            list($imdbId, $title, $year, $id) = [
                $movie->getImdbId(), 
                $movie->getTitle(), 
                $movie->getYear(),
                $movie->getId()
            ];
            $preparedStatement->execute();
            $affectedRows += $preparedStatement->affected_rows;
        }
        $preparedStatement->close();
        return $affectedRows;
    }

    public function deleteAll() {
        $connection = $this->dataSource->getConnection();
        $preparedStatement = $connection->prepare("DELETE FROM `movie`");
        $preparedStatement->execute();
        $affectedRows = $preparedStatement->affected_rows;
        $preparedStatement->close();
        return $affectedRows;
    }

    public function deleteById($id) {
        $connection = $this->dataSource->getConnection();
        $preparedStatement = $connection->prepare("DELETE FROM `movie` WHERE `id` = ?");
        $preparedStatement->bind_param("i", $id);
        $preparedStatement->execute();
        $affectedRows = $preparedStatement->affected_rows;
        $preparedStatement->close();
        return $affectedRows;
    }

    private function getMovies($preparedStatement) {
        $movies = [];
        $resultSet = $preparedStatement->get_result();
        while($row = $resultSet->fetch_assoc()) {
            $movies[] = $this->getMovie($row);
        };
        $resultSet->close();
        return $movies;
    }

    private function getMovie($row) {
        $movie = new Movie();
        $movie->setId($row['id']);
        $movie->setImdbId($row['imdb_id']);
        $movie->setTitle($row['title']);
        $movie->setYear($row['year']);
        return $movie;
    }

}