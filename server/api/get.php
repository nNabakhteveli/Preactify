<?php

require "../cors.php";

header('Content-Type: application/json');


$host = "localhost";
$db = "user_info";
$username = "root";
$password = "root";
$dsn = "mysql:dbname=$db;host=$host";

$options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false
);

$currentUserId = $_COOKIE['uniqueID'];

try {
    $pdo = new PDO($dsn, $username, $password);
    $query = $pdo->query("SELECT * FROM `users`;");
    $data = $query->fetchAll();

    echo json_encode($data);

} catch(PDOException $error) {
    echo $error;
}

