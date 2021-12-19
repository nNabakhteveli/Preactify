<?php

require "../cors.php";

$host = "localhost";
$db = "user_info";
$username = "root";
$password = "root";
$dsn = "mysql:dbname=$db;host=$host";

$options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false
);

try {
    $pdo = new PDO($dsn, $username, $password, $options);
    $query = $pdo->query("SELECT * from `accountDetails`");
    $data = $query->fetchAll();

    echo json_encode($data);

} catch(PDOException $error) {
    echo $error;
}

