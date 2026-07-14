
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Musicaly</title>
</head>
<body>
    <?php require "menu.php";?>
    
    <div id="home_div">
        <div id="home_text">
            <div id="home_text_title">Bienvenue ! <br> Donnez votre avis <br> sur vos chansons préférées</div>
            <div id="home_text_subtitle">Découvrez, explorez et partagez vos avis sur vos titres préférés.</div>
            <div id="home_text_buttons">
                <a href="index.php?page=research" id="home_button_search">Rechercher</a>
                <a href="index.php?page=login" id="home_button_login">Se connecter</a>
            </div>
        </div>

         <div id="home_images">
            <div class="home_images_col">
                <img src="/assets/img/Tame Impala.jpg" alt="">
                <img src="/assets/img/justice.jpg" alt="">
                <img src="/assets/img/jamiroquai.jpg" alt="">
            </div>
            <div class="home_images_col">
                <img src="/assets/img/Muse.jpg" alt="">
                <img src="/assets/img/gorillaz.jpg" alt="">
                <img src="/assets/img/Michael Jackson.jpg" alt="">
            </div>
        </div>
    </div>

    <div class="block-centered-90vw">
        <div class="section-header">
            <span>Derniers avis</span>
        </div>

        <?php if(empty($reviews)): ?>
            <div id="home_no_reviews">Aucun avis pour le moment</div>
        <?php else: ?>
            <?php foreach($reviews as $review): ?>
                <div class="one_review" data-spotify-id="<?php echo $review['spotify_id']; ?>" data-type="<?php echo $review['type']; ?>">
                    <div class="review_header">
                        <div class="review_track_name">Chargement...</div>
                        <div class="review_user"><?php echo $review['username']; ?></div>
                        <div class="review_stars">
                            <?php for($i = 1; $i <= 5; $i++): ?>
                                <span class="<?php echo $i <= $review['rating'] ? 'star_filled' : 'star_empty'; ?>">★</span>
                            <?php endfor; ?>
                        </div>
                        <div class="review_date"><?php echo date('d/m/Y', strtotime($review['created_at'])); ?></div>
                    </div>
                    <div class="review_comment"><?php echo $review['comment']; ?></div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>


    <script src="assets/js/script.js"></script>
    
    <script>
        DisplayHeader("home");
        loadReviewTrackNames();
    </script>
</body>
</html>