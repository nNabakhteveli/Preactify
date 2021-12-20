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


$url = 'https://api.spotify.com/v1/me';

$init = curl_init($url);

curl_setopt($init, CURLOPT_URL, $url);
curl_setopt($init, CURLOPT_RETURNTRANSFER, true);

session_start();
$tokenToFetch = "Bearer ".$_SESSION["access_token"];
$headers = array(
    "Authorization: $tokenToFetch"
);
curl_setopt($init, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($init);

$decodedAPCallResponse = json_decode($response, true);


try {
    $pdo = new PDO($dsn, $username, $password, $options);
    $query = "INSERT INTO `users` (`id`, `username`, `password`, `createDate`, `access_token`, `spotify_disp_name`, `spotify_url`, `followers`, `spotify_id`, `profile_image_url`) VALUES (:id, :uname, :pass, :createDate, :access_token, :spotify_disp_name, :spotify_url, :followers, :spotify_id, :profile_image_url)";
    $statement = $pdo->prepare($query);
    $statement->bindValue(':uname', $postedUsername);
    $statement->bindValue(':pass', $postedPassword);
    $statement->bindValue(':createDate', $currentDate);
    $statement->bindValue(":id", $uniqueId);

    $statement->bindValue(":spotify_disp_name", $decodedAPCallResponse['display_name']);
    $statement->bindValue(":spotify_url", $decodedAPCallResponse["external_urls"]['spotify']);
    $statement->bindValue(":followers", $decodedAPCallResponse["followers"]['total']);
    $statement->bindValue(":spotify_id", $decodedAPCallResponse['id']);
    $statement->bindValue(":profile_image_url", $decodedAPCallResponse['images'][0]['url']);


    session_start();
    $statement->bindValue(":access_token", $_SESSION["access_token"]);

    $executed = $statement->execute();

    setcookie('uniqueID', $uniqueId);

    if($executed) echo "success!";

} catch(PDOException $error) {
    echo $error;
}

// Relocate user to React app after successful login
header("Location: http://localhost:3000/profile?current_user=$uniqueId");