<?php
session_start();
require __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
require_once("controllers/controller.php");


if(isset($_GET["page"]) && !empty($_GET["page"])){
    $page = htmlspecialchars($_GET["page"]);
}else{
    $page = "home";
}

if(isset($_GET["research"]) && !empty($_GET["research"])){
    $research = strip_tags($_GET["research"]); 
    // on utilise ici strip_tags au lieu de htmlspecialchars 
    // pour garder les caractères spéciaux (ex: si on cherche Guns N' Roses)
}else{
    $research = NULL;
}

if(isset($_GET["research_type"]) && !empty($_GET["research_type"])){
    $research_type = htmlspecialchars($_GET["research_type"]); 
}else{
    $research_type = NULL;
}

if(isset($_GET["id"]) && !empty($_GET["id"])){
    $id = htmlspecialchars($_GET["id"]); 
}else{
    $id = NULL;
}

$token = getSpotifyToken();


if($page === "home"){
    DisplayHome($db);
}else if ($page === "research" && $research === NULL){
    DisplayResearch();
}else if ($page === "research" && $research !== NULL){
    recherche($token, $research);
}else if ($page === "result"){
    if($id !== NULL){
        if($research_type === "artist"){
            DisplayArtist($id);
        }else if($research_type === "album"){
            DisplayAlbum($id);
        }else if($research_type === "track"){
            DisplayTrack($db, $id);
        }else{
            Display404();
        }
    }else{
        Display404();
    }
}else if($page === "getInfos"){
    if($id !== NULL){
        if($research_type === "artist"){
            artistData($token, $id);
        }else if($research_type === "artist_albums"){
            artistAlbumData($token, $id);
        }else if($research_type === "album"){
            albumData($token, $id);
        }else if($research_type === "track"){
            trackData($token,$id);
        }else{
            Display404();
        }
    }else{
        Display404();
    }
}else if ($page === "login") {
    if (isset($_SESSION['user'])) {
        DisplayProfile();
    } else {
        DisplayLogin($db);
    }
}else if ($page === "register") {
    if (isset($_SESSION['user'])) {
        header('Location: ?page=profile');
        exit;
    } else {
        DisplayRegister($db);
    }
}else if ($page === "profile") {
    if (isset($_SESSION['user'])) {
        DisplayProfile();
    } else {
        header('Location: ?page=login');
        exit;
    }
}else if ($page === "log_out"){
    LogOut();
}else if ($page === "historic") {
    if (isset($_SESSION['user'])) {
        DisplayHistoric($db);
    } else {
        header('Location: ?page=login');
        exit;
    }
}else{
   Display404();
}