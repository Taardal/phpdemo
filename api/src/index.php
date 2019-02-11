<?php

require_once 'datasources/data_source.php';
require_once 'repositories/movie_repository.php';

$dataSource = new DataSource();
$movieRepository = new MovieRepository($dataSource);
echo json_encode($movieRepository->findAll());

?>