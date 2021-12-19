<?php

require 'vendor/autoload.php';


$client = new GuzzleHttp\Client();
$res = $client->request('GET', 'https://api.spotify.com/v1/tracks/2TpxZ7JUBn3uw46aR7qd6V', [
    'headers' => [
        'Authorization' => $_COOKIE['tokenToFetch']
    ]
]);

echo $res->getBody();


