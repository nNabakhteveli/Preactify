<?php

require "../cors.php";

// echo phpinfo();
$host = "localhost";
$db = "user_info";
$username = "root";
$password = "root";
$dsn = "mysql:dbname=$db;host=$host";

$options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false
);


$postedUsername = $_POST['username'];
$postedPassword = $_POST['password'];
$currentDate = date("Y/m/d");

try {
    $pdo = new PDO($dsn, $username, $password, $options);
    $query = "INSERT INTO `accountDetails` (`username`, `password`, `createDate`) VALUES (:uname, :pass, :createDate)";
    $statement = $pdo->prepare($query);
    $statement->bindValue(':uname', $postedUsername);
    $statement->bindValue(':pass', $postedPassword);
    $statement->bindValue(':createDate', $currentDate);

    $executed = $statement->execute();

    if($executed) echo "success!";

} catch(PDOException $error) {
    echo $error;
}
