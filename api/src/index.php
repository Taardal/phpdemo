<?php
require_once 'DataSource.php';
require_once 'MovieRepository.php';

header("Access-Control-Allow-Origin: http://localhost:4200");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Accept");

$dataSource = new DataSource();
$movieRepository = new MovieRepository($dataSource);
echo json_encode($movieRepository->findAll());

?>