<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Musiques</title>
</head>
<body>
    <div class="research_page">

    <?php require "menu.php";?>
    
    <div id="research_barre">
        <input type="text" id="search_input" placeholder="Rechercher un artiste, un album, un titre...">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="rgba(243,239,229,0.4)" stroke-width="1.5" stroke-linecap="round">
            <circle cx="11" cy="11" r="6"/>
            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
    </div>


    <div id="results"> 
        <!-- div centenant les résultats de la recherche -->
    </div>
    
    </div>


    <script src="/assets/js/script.js"></script>
    <script>
        DisplayHeader("research");

    </script>
</body>
</html>