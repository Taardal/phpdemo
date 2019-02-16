<?php
class MovieService {

    private $movieRepository;
    private $genreRepository;

    public function __construct($movieRepository, $genreRepository) {
        $this->movieRepository = $movieRepository;
        $this->genreRepository = $genreRepository;
    }

    public function getAll() {
        $movies = $this->movieRepository->findAll() ?: [];
        foreach ($movies as $movie) {
            $genres = $this->genreRepository->findForMovie($movie->getId());
            $movie->setGenres($genres);
        }
        return $movies;
    }

    public function getById($id) {
        $movie = $this->movieRepository->findById($id);
        if ($movie) {
            $genres = $this->genreRepository->findForMovie($movie->getId());
            $movie->setGenres($genres);
        }
        return $movie;
    }
    
    public function create($movie) {
        $id = $this->movieRepository->insert($movie);
        if ($id > 0) {
            foreach ($movie->getGenres() as $genre) {
                $this->genreRepository->insertMappingToMovie($genre, $id);
            }
        }
        return $id > 0 ? $id : null;
    }

    public function update($movies) {
        $rowsAffected = $this->movieRepository->update($movies);
        return $rowsAffected > 0;
    }

    public function updateById($movie, $id) {
        if (!$movie->getId() || $movie->getId() != $id) {
            $movie->setId($id);
        }
        $rowsAffected = $this->update([$movie]);
        return $rowsAffected > 0;
    }

    public function deleteAll() {
        $rowsAffected = $this->movieRepository->deleteAll();
        return $rowsAffected > 0;
    }

    public function deleteById($id) {
        $rowsAffected = $this->movieRepository->deleteById($id);
        return $rowsAffected > 0;
    }

}