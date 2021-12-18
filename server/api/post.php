<?php

require "../cors.php";

// echo phpinfo();
$host = "localhost";
$db = "user_info";
$username = "root";
$password = "root";
$dsn = "mysql:dbname=$db;host=$host";

try {
    $pdo = new PDO($dsn, $username, $password);
    $result = $pdo->query('SELECT * FROM tokens');
    $rows = $result->fetchAll();
    var_dump($rows);
    if($pdo) echo "success!";

} catch(PDOException $error) {
    echo $error;
}