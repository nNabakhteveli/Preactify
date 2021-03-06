<?php


// Takes in all information about playlist
function writePlaylistData(
    $uniqueId, $playlist_name, $playlist_external_url, $playlist_image_url, $owner_display_name, 
    $owner_account_external_url, $owner_account_url_api, 
    $tracks_api_url, $playlist_api_url) {

    require "./DBInfo.php";

    try {
        // Using `INSERT IGNORE` instead of `INSERT` to prevent data duplication. Some columns are UNIQUE and can't be duplicated
        $pdo = new PDO($dsn, $username, $password, $options);
        $query = "INSERT IGNORE INTO `playlists` (`userid`, `playlist_name`, `playlist_external_url`, `playlist_image_url`, `owner_display_name`, `owner_account_external_url`, `owner_account_url_api`, `tracks_api_url`, `playlist_api_url`) VALUES (:userid, :playlist_name, :playlist_external_url, :playlist_image_url, :owner_display_name, :owner_account_external_url, :owner_account_url_api, :tracks_api_url, :playlist_api_url)";

        $statement = $pdo->prepare($query);
        $statement->bindValue(":userid", $uniqueId);
        $statement->bindValue(':playlist_name', $playlist_name);
        $statement->bindValue(':playlist_external_url', $playlist_external_url);
        $statement->bindValue(':playlist_image_url', $playlist_image_url);
        $statement->bindValue(':owner_display_name', $owner_display_name);

        $statement->bindValue(':owner_account_external_url', $owner_account_external_url);
        $statement->bindValue(':owner_account_url_api', $owner_account_url_api);
        $statement->bindValue(':tracks_api_url', $tracks_api_url);
        $statement->bindValue(':playlist_api_url', $playlist_api_url);

        $executed = $statement->execute();
    
        if($executed) echo "success!";
    
    } catch(PDOException $error) {
        echo $error;
    }
}


/*
* $access_token parameter takes in session variable value, firstly fetched access token from index.php
* $uniqueId also takes session variables from index.php, that represents currently logged in user
*/

function getPlaylistData($access_token, $uniqueId) {
    // Spotify API endpoint for playlists
    $url = 'https://api.spotify.com/v1/me/playlists';
    
    $init = curl_init($url);
    
    curl_setopt($init, CURLOPT_URL, $url);
    curl_setopt($init, CURLOPT_RETURNTRANSFER, true);
    
    $headers = array(
        "Authorization: $access_token"
    );
    curl_setopt($init, CURLOPT_HTTPHEADER, $headers); // Setting Authorization header

    $response = curl_exec($init);

    $decodedResponse = json_decode($response, true);
        
    for($i = 0; $i < count($decodedResponse['items']); $i++) {
        $currentValue = $decodedResponse['items'][$i];
        
        try { // Writing every single playlist's data in the database
            writePlaylistData($uniqueId, $currentValue['name'], $currentValue['external_urls']['spotify'], $currentValue['images'][0]['url'], $currentValue['owner']['display_name'], 
            $currentValue['owner']['external_urls']['spotify'], $currentValue['owner']['href'], $currentValue['tracks']['href'], $decodedResponse['href']);
        } catch(Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }
    }
    curl_close($init);
}

session_start();

getPlaylistData("Bearer ".$_SESSION["access_token"], $_SESSION['uniqueID']);

// After getPlaylistData() is done, user will be redirected to it's profile page
header("Location: http://localhost:3000/?spotify_login_success=true");
