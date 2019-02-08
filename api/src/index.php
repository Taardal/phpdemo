<?php
require_once 'DataSource.php';
require_once 'MovieRepository.php';

$dataSource = new DataSource();
$movieRepository = new MovieRepository($dataSource);
echo json_encode($movieRepository->findAll());

?>