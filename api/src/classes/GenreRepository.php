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

    private function getGenres($preparedStatement) {
        $genres = [];
        $resultSet = $preparedStatement->get_result();
        while($row = $resultSet->fetch_assoc()) {
            $genres[] = $row;
        };
        $resultSet->close();
        return $genres;
    }

}