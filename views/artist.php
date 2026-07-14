<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Artiste</title>
</head>
<body>
    <div class="research_page">
    <?php require "menu.php";?>

    <div id="artist_presentation">
        <div id="artist_presentation_infos">
            <div id="artist_name"></div>

            <a id="artist_spotify_button">
                <img src="/assets/img/logo_spotify.png" alt="">
                Spotify
            </a>
        </div>

        <img id="artist_img" src="" alt="">

    </div>

    <div id="artist_albums_onglet"> 
        <span> Albums </span>
    </div>
        
    <div id="artist_albums">
        <!-- div contenant tout les albums-->
    </div>

    </div>
    
    <!-- librairie qui permet de récupérer la couleur dominante d'une image -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.0/color-thief.umd.js"></script> 
    
    <script src="/assets/js/script.js"></script>
    <script>
        DisplayHeader("research");
        getArtistData(<?php echo json_encode($id); ?>);
        getArtistAlbumData(<?php echo json_encode($id); ?>);
    </script>
</body>
</html>