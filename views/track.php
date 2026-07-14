<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Track</title>
</head>
<body>
    <div id="background"></div>

    <div class="research_page">
        <?php require "menu.php";?>

        <div id="track_presentation">
            <img id="track_img" src="" alt="">

            <div id="track_presentation_infos">
                <div id="track_top_infos">
                    <div id="track_name"></div>
                    <div id="track_date"></div>
                    <div id="track_duration"></div>
                </div>

                <a id="artist_spotify_button">
                    <img src="/assets/img/logo_spotify.png" alt="">
                    Spotify
                </a>
            </div>
        </div>
        
        <?php if(isset($_SESSION['user'])): ?>
            <div id="track_review_section">
                <div id="track_review_header">
                    <span>Votre avis</span>
                </div>
                <form action="index.php?page=result&research_type=track&id=<?php echo $id; ?>" method="POST">
                    <div id="track_rating">
                        <label></label>
                        <div id="track_stars">
                            <input type="radio" name="rating" value="5" id="star5"><label for="star5">★</label>
                            <input type="radio" name="rating" value="4" id="star4"><label for="star4">★</label>
                            <input type="radio" name="rating" value="3" id="star3"><label for="star3">★</label>
                            <input type="radio" name="rating" value="2" id="star2"><label for="star2">★</label>
                            <input type="radio" name="rating" value="1" id="star1"><label for="star1">★</label>
                        </div>
                    </div>
                    <textarea name="comment" id="track_review_input" placeholder="Donnez votre avis sur ce titre..."></textarea>
                    <button type="submit" id="track_review_submit">Publier</button>
                </form>
                <?php if(isset($error)) echo "<div class='form_error'>$error</div>"; ?>
                <?php if(isset($success)) echo "<div class='form_success'>$success</div>"; ?>
            </div>
        <?php else: ?>
            <div id="track_review_section">
                <div id="track_review_header"><span>Votre avis</span></div>
                <div id="track_review_login">
                    <p>Connectez-vous pour donner votre avis</p>
                </div>
            </div>
        <?php endif; ?>
        
        <div id="track_reviews">
            <div id="track_reviews_header">
                <span>Avis</span>
            </div>

            <?php if(empty($reviews)): ?>
                <div id="track_no_reviews">Aucun avis pour le moment, soyez le premier !</div>
            <?php else: ?>
                <?php foreach($reviews as $review): ?>
                    <div class="one_review">
                        <div class="review_header">
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
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.0/color-thief.umd.js"></script>
    <script src="/assets/js/script.js"></script>
    <script>
        DisplayHeader("research");
        getTrackData(<?php echo json_encode($id); ?>);
    </script>
</body>
</html>