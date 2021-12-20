<?php

// require "../cors.php";
require "./DBInfo.php";

$options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false
);

$postedUsername = $_POST['username'];
$postedPassword = $_POST['password'];
$currentDate = date("Y/m/d");

session_start();
$uniqueId = $_SESSION['uniqueID'];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
    $query = "INSERT INTO `users` (`id`, `username`, `password`, `createDate`, `access_token`) VALUES (:id, :uname, :pass, :createDate, :access_token)";
    $statement = $pdo->prepare($query);
    $statement->bindValue(':uname', $postedUsername);
    $statement->bindValue(':pass', $postedPassword);
    $statement->bindValue(':createDate', $currentDate);
    $statement->bindValue(":id", $uniqueId);
    session_start();
    $statement->bindValue(":access_token", $_SESSION["access_token"]);

    $executed = $statement->execute();

    setcookie('uniqueID', $uniqueId);

    if($executed) echo "success!";

} catch(PDOException $error) {
    echo $error;
}

// Relocate user to React app after successful login
header("Location: http://localhost:3000/dashboard/profile?current_user=$uniqueId");