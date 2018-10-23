<?php
require_once 'datasources/DataSource.php';
require_once 'repositories/PersonRepository.php';

$dataSource = new DataSource();
$personRepository = new PersonRepository($dataSource);
echo json_encode($personRepository->findAll());