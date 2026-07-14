<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Muse</title>
</head>
<body>
    <?php require "menu.php";?>
    
    <div class="block-centered-90vw">
        <?php if(empty($reviews)): ?>
            <div id="historic-empty">
                Votre historique est vide pour l'instant. Allez notez des musiques !         
            </div>  
        <?php else: ?>
            <div class="section-header">
                <span> Vos avis </span>
            </div>
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
        <?php endif;?>
    </div>


    <script src="assets/js/script.js"></script>
    <script>
        DisplayHeader("historic");
        loadReviewTrackNames();
    </script>
</body>
</html>