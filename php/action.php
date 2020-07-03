<?php

// Function that redirects to failure page and terminates script
function failure() {
  header('Location: ../fail.html');
  exit();
}

// Check that the request method is post
if ($_SERVER['REQUEST_METHOD'] !== 'POST') failure();

// Check that a country is selected
if (empty($_POST['country'])) failure();

// Check that entered email is valid
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) failure();

// Read configuration data from file
$myfile = fopen("config.json", "r");
$config = json_decode(fread($myfile,filesize("config.json")), true);
fclose($myfile);


// Test PDO connection
$host = '127.0.0.1';
$db   = 'test';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
  PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
  $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
  throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// Redirect to success page
header('Location: ../success.html');