<?php

$spotify_config = require "./config/config.php";


// function getData($access_token) {
    $url = 'https://api.spotify.com/v1/me/playlists';
    
    $ch = curl_init($url);
    
    session_start();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $token = "Bearer ".$_SESSION["access_token"];
    
    $headers = array(
        "Authorization: $token"
    );
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $resp = curl_exec($ch);

    print_r($resp);
    curl_close($ch);
// }