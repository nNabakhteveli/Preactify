<?php

$spotify_config = require "./config/config.php";

echo "asdddddddd";

function get() {
    $request = curl_init();
    $url = 'https://api.spotify.com/v1/me/player/devices';

    $headers = array(
        'Authorization' => $_COOKIE['tokenToFetch']
    );

    curl_setopt($request, CURLOPT_URL, $url);
    curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($request, CURLOPT_HTTPHEADER, $headers);


    $resp = curl_exec($request);

    if($e = curl_error($request)) {
        echo $e;
    } else {
        $decoded = json_decode($resp);
        print_r($decoded);
    }


    curl_close($request);
}

// function refresh() {
    $req = curl_init();
    $url = 'https://example.com/v1/swap';
    $body = json_encode(array(
        'access_token' => $_COOKIE['access-token'],
        'expires_in' => $_COOKIE['expires_in'],
        'refresh_token' => $_COOKIE['refresh_token']       
    ));

    $rt = $_COOKIE['refresh_token'];
    $id = $spotify_config['client_id'];
    $a = "grant_type=refresh_token&refresh_token=$rt&client_id=$id";

    curl_setopt($req, CURLOPT_URL, $url);
    curl_setopt($req, CURLOPT_POST, true);
    curl_setopt($req, CURLOPT_POSTFIELDS, $body);
    curl_setopt($req, CURLOPT_RETURNTRANSFER, true);

    $resp = curl_exec($req);

    if($e = curl_error($req)) {
        echo $e;
    } else {
        echo "Success: $resp";
    }

    curl_close($req);
// }

// refresh();