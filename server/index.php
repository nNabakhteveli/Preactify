<?php

require 'vendor/autoload.php';
require "./config/config.php";
require './cors.php';


$clientId = $spotify_config['client_id'];
$clientSecret = $spotify_config['client_secret'];
$redirectURL = 'http://localhost/preactify/server/index.php';

$url = "https://accounts.spotify.com/authorize?client_id=$clientId&response_type=code&redirect_uri=$redirectURL";

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
            $responseStatusCode = $res->getStatusCode();
            
            setcookie("access_token", $response["access_token"]);
            setcookie("token_type", $response["token_type"]);
            setcookie("expires_in", $response["expires_in"]);
            setcookie("refresh_token", $response["refresh_token"]);

            $a = $response["token_type"];
            $b = $response["access_token"];
            
            setcookie('tokenToFetch', "$a $b"); 
        } 
        header("Location: http://localhost:3000/?spotify_login_success=true");
    } else {
        echo "Something failed during authorization...";
    }
} else {
    echo "Login success";
}