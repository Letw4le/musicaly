<?php
require "models/dbconnexion.php";

function inscription($db, $pseudo, $mdp){
    // vérifie que le pseudo n'existe pas déjà
    $sql = "SELECT id FROM users WHERE username = :pseudo";
    $statement = $db->prepare($sql);
    $statement->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
    if($statement->execute()){
        if($statement->fetch()){
            $GLOBALS['error'] = "Ce pseudo est déjà utilisé";
            return;
        }
    }

    //inscription
    $mdp_hash = password_hash($mdp, PASSWORD_BCRYPT); 
    $sql = "INSERT INTO users (username, password)
    VALUES (:pseudo, :password)";

    $statement = $db->prepare($sql);
    $statement->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
    $statement->bindValue(':password', $mdp_hash, PDO::PARAM_STR);
    if($statement->execute()){
        // récupère l'id du nouvel utilisateur
        $newId = $db->lastInsertId();

        // connecte directement l'utilisateur
        $_SESSION['user'] = $pseudo;
        $_SESSION['user_id'] = $newId;
        cookieUser($pseudo);
        
        header("Location:index.php?page=home");
        exit;
    }else{
        $GLOBALS['error'] = "Une erreur est survenue, veuillez réessayer.";
    }
}

function connexion($db, $pseudo, $mdp){
    $sql = "SELECT * FROM users WHERE username = :pseudo";
    $statement = $db->prepare($sql);
    $statement->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);

    if($statement->execute()){
        $user = $statement->fetch();
        if(!$user){
            $error = "Pseudo ou mot de passe incorrect";
            return;
        }else{
            if(password_verify($mdp, $user['password'])){
                // session pour la durée de navigation
                $_SESSION['user'] = $pseudo;
                $_SESSION['user_id'] = $user['id'];
                
                // cookie pour se souvenir entre les visites
                setcookie(
                    'user', 
                    $pseudo, 
                     time() + 365 * 24 * 3600
                );
        
                header("Location:index.php?page=home");
                exit;
            }else{
                $error = "Pseudo ou mot de passe incorrect";
            }
        }
    }else{
        echo "Erreur de connexion";
    }
}

function addReview($db, $user_id, $spotify_id, $type, $rating, $comment){
    // vérifie si l'utilisateur a déjà donné un avis
    $sql = "SELECT id FROM reviews WHERE user_id = :user_id AND spotify_id = :spotify_id";
    $statement = $db->prepare($sql);
    $statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $statement->bindValue(':spotify_id', $spotify_id, PDO::PARAM_STR);
    $statement->execute();

    if($statement->fetch()){
        $GLOBALS['error'] = "Vous avez déjà donné un avis sur ce titre";
        return;
    }

    $sql = "INSERT INTO reviews (user_id, spotify_id, type, rating, comment)
            VALUES (:user_id, :spotify_id, :type, :rating, :comment)";
    $statement = $db->prepare($sql);
    $statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $statement->bindValue(':spotify_id', $spotify_id, PDO::PARAM_STR);
    $statement->bindValue(':type', $type, PDO::PARAM_STR);
    $statement->bindValue(':rating', $rating, PDO::PARAM_INT);
    $statement->bindValue(':comment', $comment, PDO::PARAM_STR);

    if($statement->execute()){
        $GLOBALS['success'] = "Votre avis a été publié !";
    } else {
        $GLOBALS['error'] = "Une erreur est survenue";
    }
}

function getLastReviews($db){
    $sql = "SELECT reviews.*, users.username 
            FROM reviews 
            JOIN users ON reviews.user_id = users.id
            ORDER BY reviews.created_at DESC
            LIMIT 10";
    $statement = $db->prepare($sql);
    if ($statement->execute()) {
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        return [];
    }
}

function cookieUser($pseudo){
    setcookie(
        'pseudo',
        $pseudo,
        time() + 365 * 24 * 3600 // Heure actuelle du serveur + 1 an en seconde
    );
}

function restaurationSession($db){
    // on récupère l'id depuis la base de données
    $sql = "SELECT id FROM users WHERE username = :pseudo";
    $statement = $db->prepare($sql);
    $statement->bindValue(':pseudo', $_COOKIE['user'], PDO::PARAM_STR);
    
    if($statement->execute()){
        $user = $statement->fetch();
        $_SESSION['user_id'] = $user['id'];
    }
}


function getReviews($db, $spotify_id){
    $sql = "SELECT reviews.*, users.username 
            FROM reviews 
            JOIN users ON reviews.user_id = users.id
            WHERE reviews.spotify_id = :spotify_id
            ORDER BY reviews.created_at DESC";
    $statement = $db->prepare($sql);
    $statement->bindValue(':spotify_id', $spotify_id, PDO::PARAM_STR);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getHistoric($db, $user_id){
    // on récupère les 20 derniers avis de l'utilisateur
    $sql = "SELECT reviews.spotify_id, reviews.type, reviews.rating, reviews.comment, reviews.created_at, users.username
            FROM reviews 
            JOIN users ON reviews.user_id = users.id
            WHERE user_id = :user_id
            ORDER BY created_at DESC
            LIMIT 20";
    
    $statement = $db->prepare($sql);
    $statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    if($statement->execute()){
        return $statement->fetchAll(PDO::FETCH_ASSOC); 
    }else{
        return [];
    }

}