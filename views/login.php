<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Connexion</title>
</head>
<body>
    <div id="background"></div>

    <?php require "menu.php";?>

    <div id="login_div">
        <div id="login_title">Connexion</div>

        <form id="login_form" action="index.php?page=login" method="POST">
            <div class="login_input_group">
                <label for="login_pseudo">Pseudo</label>
                <input type="text" id="login_pseudo" name="pseudo" placeholder="Votre pseudo...">
            </div>

            <div class="login_input_group">
                <label for="login_mdp">Mot de passe</label>
                <input type="password" id="login_mdp" name="mdp" placeholder="Votre mot de passe...">
            </div>

            <?php if(isset($error)) echo "<div id='login_error'>$error</div>"; ?>

            <button type="submit" id="login_submit">Se connecter</button>

            <div id="login_register">
                Pas encore de compte ? 
                <a href="index.php?page=register">S'inscrire</a>
            </div>
        </form>
    </div>

    <script src="assets/js/script.js"></script>
    <script>
        DisplayHeader("login");
    </script>
</body>
</html>