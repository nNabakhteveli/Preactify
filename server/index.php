<?php

require 'vendor/autoload.php';
require './cors.php';
$spotify_config = require "./config/config.php";


// Essential queries for HTTP requests
$clientId = $spotify_config['client_id'];
$clientSecret = $spotify_config['client_secret'];
$redirectURL = 'http://localhost/preactify/server/index.php'; // After successful login, user gets redirected back to our local app

// Things that we want to get about our user
$SCOPES = implode("%20", array(
    'user-read-currently-playing',
    'user-follow-modify',
    'user-follow-read',
    'playlist-read-private'
));

$url = "https://accounts.spotify.com/authorize?client_id=$clientId&response_type=code&redirect_uri=$redirectURL&scope=$SCOPES&show_dialog=true";


if($_SERVER['REQUEST_URI'] == '/preactify/server/index.php' && !isset($_COOKIE["access_token"])) header("Location: $url");


if($_SERVER['QUERY_STRING'] != "") {
    setcookie('query_success_login', $_SERVER['QUERY_STRING']);
    $queryString = parse_url($_SERVER["REQUEST_URI"]);
    $returnedAuthorizedCode = str_replace("code=", "", $queryString['query']);

    if(!str_contains($queryString['query'], "error")) {
        $responseStatusCode = null;
        if(!isset($_COOKIE["access_token"])) {
            $client = new GuzzleHttp\Client();
            $res = $client->request('POST', "https://accounts.spotify.com/api/token?grant_type=authorization_code&code=$returnedAuthorizedCode&redirect_uri=$redirectURL&client_id=$clientId&client_secret=$clientSecret", [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded'
                ]
            ]);
                
            $response = json_decode($res->getBody("access_token"), true);

            session_start();
            $_SESSION["access_token"] = $response["access_token"];
            $_SESSION["token_type"] = $response["token_type"];

            
            setcookie("access_token", $response["access_token"], time() + 31536000, "/");
            setcookie("token_type", $response["token_type"], time() + 31536000, "/");
            setcookie("expires_in", $response["expires_in"], time() + 31536000, "/");
            setcookie("refresh_token", $response["refresh_token"], time() + 31536000, "/");
            

            $uniqueId = uniqid("id_"); // Built in PHP function to generate random ID's to identify different users

            $_SESSION['uniqueID'] = $uniqueId;

        }
        /*  After successful Spotify authorization, user gets redirected to /curl.php route to
        *   finish setting up the account
        */ 
        header("Location: http://localhost/preactify/server/lib/curl.php");
    } else {
        echo "Something failed during authorization...";
    }
} else {
    // If user is already logged in, the only output will be this
    echo "Login success";
}

