<?php

require 'vendor/autoload.php';

$a = $_COOKIE['token_type'];
$b = $_COOKIE['access_token'];

$tokenToFetch = "$a $b";
// echo $c;

$client = new GuzzleHttp\Client();
$res = $client->request('GET', 'https://api.spotify.com/v1/tracks/2TpxZ7JUBn3uw46aR7qd6V', [
    'headers' => [
        'Authorization' => $tokenToFetch
    ]
]);

echo $res->getBody();


// insert into tokens (access_token, refresh_access_token, token_type) values ("test", "tset", "asdd");
