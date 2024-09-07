<?php
require_once __DIR__ . '../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$dbHOST = $_ENV['DB_HOST'];
$dbUSERNAME = $_ENV['DB_USERNAME'];
$dbPASSWORD = $_ENV['DB_PASSWORD'];
$dbNAME = $_ENV['DB_NAME'];

// Create connection
$connect = new mysqli($dbHOST, $dbUSERNAME, $dbPASSWORD, $dbNAME);

// Check connection
if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}   