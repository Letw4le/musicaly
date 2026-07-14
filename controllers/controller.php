<?php

require "models/model.php";
$db = DbConnexion();

// si pas de session mais un cookie existe alors on restaure la session
if(!isset($_SESSION['user']) && isset($_COOKIE['user'])){
    $_SESSION['user'] = $_COOKIE['user'];

    restaurationSession($db);
}

function DisplayHome($db){
    $reviews = getLastReviews($db);
    require "views/home.php";
}

function Display404(){
    http_response_code(404);
    echo "Page non trouvée";
    exit;
}

function DisplayResearch(){
    require "views/research.php";
}

function DisplayLogin($db){
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $mdp = $_POST['mdp'];
        connexion($db, $pseudo, $mdp);
    }

    require "views/login.php";
}

function DisplayRegister($db){
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $mdp    = $_POST['mdp'];
        inscription($db, $pseudo, $mdp);
    }
    require "views/register.php";
}

function DisplayProfile(){
    require "views/profile.php";
}

function LogOut(){
    session_destroy();
    setcookie('user', '', time() - 3600);
    header("Location:index.php?page=home");
    exit;
}



function DisplayHistoric($db){
    $reviews = getHistoric($db, $_SESSION['user_id']);
    require "views/historic.php";
}

function DisplayArtist($id){
    require "views/artist.php";
    
}

function DisplayAlbum($id){
    require "views/album.php";
}

function DisplayTrack($db, $id){
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user'])){
        if(!isset($_POST['rating'])){
            $GLOBALS['error'] = "Veuillez sélectionner une note";
        } else {
            $rating  = (int)$_POST['rating'];
            $comment = strip_tags($_POST['comment']);
            addReview($db, $_SESSION['user_id'], $id, 'track', $rating, $comment);
        }
    }
    $reviews = getReviews($db, $id);
    require "views/track.php";
}



function recherche($token, $requete){
    $results = researchSpotify($token, $requete);
    ob_clean(); // efface tout output précédent
    header('Content-Type: application/json'); 
    echo json_encode($results);
    exit();

}

function artistData($token, $requete){
    $results = getSpotifyArtistData($token, $requete);
    ob_clean(); 
    header('Content-Type: application/json'); 
    echo json_encode($results);
    exit();

}

function artistAlbumData($token, $requete){
    $results = getSpotifyArtistAlbumData($token, $requete);
    ob_clean(); 
    header('Content-Type: application/json'); 
    echo json_encode($results);
    exit();
}

function albumData($token, $requete){
    $results = getSpotifyAlbumData($token, $requete);
    ob_clean();
    header('Content-Type: application/json'); 
    echo json_encode($results);
    exit();
}

function trackData($token, $requete){
    $results = getSpotifyTrackData($token, $requete);
    ob_clean();
    header('Content-Type: application/json'); 
    echo json_encode($results);
    exit();
}



function getSpotifyToken() {
    $clientId = $_ENV['SPOTIFY_CLIENT_ID'] ?? null;
    $clientSecret = $_ENV['SPOTIFY_CLIENT_SECRET'] ?? null;

    if (!$clientId || !$clientSecret) {
        die('Erreur : les variables SPOTIFY_CLIENT_ID / SPOTIFY_CLIENT_SECRET ne sont pas définies dans le .env');
    }
    

    $ch = curl_init();

    curl_setopt_array($ch, [
        CURLOPT_URL            => 'https://accounts.spotify.com/api/token',
        CURLOPT_POST           => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_HTTPHEADER     => [
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Basic ' . base64_encode("$clientId:$clientSecret")
        ],
        CURLOPT_POSTFIELDS     => 'grant_type=client_credentials'
    ]);

    $response = curl_exec($ch);

    $data = json_decode($response, true);
    return $data['access_token'];
}


function researchSpotify($token, $request){

    $ch = curl_init();

    curl_setopt_array($ch, [
        CURLOPT_URL            => 'https://api.spotify.com/v1/search?q=' . urlencode($request) . '&type=album%2Cartist%2Ctrack&limit=5',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_HTTPHEADER     => [
            'Authorization: Bearer ' . $token
        ],
    ]);

    $response = curl_exec($ch);

    $data = json_decode($response, true);

    return [
        'artists' => $data['artists']['items'],
        'albums'  => $data['albums']['items'],
        'tracks'  => $data['tracks']['items'],
    ];

}


function getSpotifyArtistData($token, $id) {
    $ch = curl_init();

    curl_setopt_array($ch, [
        CURLOPT_URL            => "https://api.spotify.com/v1/artists/" . $id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_HTTPHEADER     => [
            'Authorization: Bearer ' . $token
        ],
    ]);

    $response = curl_exec($ch);
    $data = json_decode($response, true);
    
    return $data;
}


function getSpotifyArtistAlbumData($token, $id) {
    $ch = curl_init();

    curl_setopt_array($ch, [
        CURLOPT_URL            => "https://api.spotify.com/v1/artists/" . $id ."/albums?limit=10",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_HTTPHEADER     => [
            'Authorization: Bearer ' . $token
        ],
    ]);

    $response = curl_exec($ch);
    $data = json_decode($response, true);
    
    return $data;
}

function getSpotifyAlbumData($token, $id) {
    $ch = curl_init();

    curl_setopt_array($ch, [
        CURLOPT_URL            => "https://api.spotify.com/v1/albums/" . $id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_HTTPHEADER     => [
            'Authorization: Bearer ' . $token
        ],
    ]);

    $response = curl_exec($ch);
    $data = json_decode($response, true);
    
    return $data;
}

function getSpotifyTrackData($token, $id) {
    $ch = curl_init();

    curl_setopt_array($ch, [
        CURLOPT_URL            => "https://api.spotify.com/v1/tracks/" . $id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_HTTPHEADER     => [
            'Authorization: Bearer ' . $token
        ],
    ]);

    $response = curl_exec($ch);
    $data = json_decode($response, true);
    
    return $data;
}
