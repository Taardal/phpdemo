<?php
class GenreRepository {
    
    private $dataSource;
    
    public function __construct($dataSource) {
        $this->dataSource = $dataSource;
    }
    
    public function findAll() {
        $connection = $this->dataSource->getConnection();
        $preparedStatement = $connection->prepare("SELECT * FROM `genre`");
        $preparedStatement->execute();
        $genres = $this->getGenres($preparedStatement);
        $preparedStatement->close();
        return $genres;
    }

    public function findForMovie($movieId) {
        $sql = "
            SELECT  g.*
            FROM `genre` g
            INNER JOIN `movie_genre` mg ON g.`id` = mg.`genre_id_fk`
            INNER JOIN `movie` m ON m.`id` = mg.`movie_id_fk`
            WHERE m.`id` = ?
        ";
        $connection = $this->dataSource->getConnection();
        $preparedStatement = $connection->prepare($sql);
        $preparedStatement->bind_param("i", $movieId);
        $preparedStatement->execute();
        $genres = $this->getGenres($preparedStatement);
        $preparedStatement->close();
        return $genres;        
    } 

    public function insertMappingToMovie($genre, $movieId) {
        $sql = "INSERT INTO `movie_genre` (`genre_id_fk`, `movie_id_fk`) VALUES (?, ?)";  
        $connection = $this->dataSource->getConnection();
        $preparedStatement = $connection->prepare($sql);
        $preparedStatement->bind_param("ii", $genre->getId(), $movieId);
        $preparedStatement->execute();
        $id = $preparedStatement->insert_id;
        $preparedStatement->close();
        return $id;
    }

    private function getGenres($preparedStatement) {
        $genres = [];
        $resultSet = $preparedStatement->get_result();
        while($row = $resultSet->fetch_assoc()) {
            $genres[] = $this->getGenre($row);
        };
        $resultSet->close();
        return $genres;
    }

    private function getGenre($row) {
        $genre = new Genre();
        $genre->setId($row['id']);
        $genre->setName($row['name']);
        return $genre;
    }

}