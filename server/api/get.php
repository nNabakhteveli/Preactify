<?php

// This file is main source of information for Front-End

require "../cors.php";
require "../lib/DBInfo.php";

header('Content-Type: application/json');

$currentUserId = $_COOKIE['uniqueID'];

try {
    $pdo = new PDO($dsn, $username, $password);
    $query = $pdo->query("SELECT * FROM `users`;");
    $userData = $query->fetchAll(PDO::FETCH_ASSOC);

    $query = $pdo->query("SELECT * FROM `playlists`;");
    $playlistsData = $query->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(
        array(
        'userData' => $userData,
        'playlistsData' => $playlistsData
        )
    );

} catch(PDOException $error) {
    echo $error;
}
