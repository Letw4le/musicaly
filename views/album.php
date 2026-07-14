<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Album</title>
</head>
<body>
    <div id="background"></div>
    <div class="research_page">
    <?php require "menu.php";?>

    <div id="album_presentation">

        <img id="album_img" src="" alt="">

        <div id="album_presentation_infos">
            <div id="album_top_infos">
                <div id="album_name"></div>
                <div id="album_genres"></div>
                <div id="album_date"></div>
            </div>

            <a id="artist_spotify_button">
                <img src="/assets/img/logo_spotify.png" alt="">
                Spotify
            </a>
        </div>

    </div>

    <div id="artist_albums_onglet"> 
        <span> Titres </span>
    </div>
        
    <div id="album_tracks">
        <!-- div contenant tout les titres-->
         <a href="" class="one_track">
            <span class="track_number"></span>
            <span class="track_title"></span>
            <span class="track_duration"></span>
         </a>
    </div>

    </div>
    
    <!-- librairie qui permet de récupérer la couleur dominante d'une image -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.0/color-thief.umd.js"></script> 
    
    <script src="/assets/js/script.js"></script>
    <script>
        DisplayHeader("research");
        getAlbumData(<?php echo json_encode($id); ?>);
    </script>
</body>
</html>