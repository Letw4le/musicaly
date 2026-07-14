<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Inscription</title>
</head>
<body>
    <div id="background"></div>
    <?php require "menu.php";?>

    <div id="register_div">
        <div id="register_title">Inscription</div>

        <form id="register_form" action="index.php?page=register" method="POST">
            <div class="login_input_group">
                <label for="register_pseudo">Pseudo</label>
                <input type="text" id="register_pseudo" name="pseudo" placeholder="Choisissez un pseudo...">
            </div>

            <div class="login_input_group">
                <label for="register_mdp">Mot de passe</label>
                <input type="password" id="register_mdp" name="mdp" placeholder="Choisissez un mot de passe...">
            </div>

    
            <?php if(isset($error)) echo "<div class='form_error'>$error</div>"; ?>
            <?php if(isset($success)) echo "<div class='form_success'>$success</div>"; ?>

            <button type="submit" id="register_submit">S'inscrire</button>

            <div id="register_login">
                Déjà un compte ?
                <a href="index.php?page=login">Se connecter</a>
            </div>
        </form>
    </div>

    <script src="assets/js/script.js"></script>
    <script>
        DisplayHeader("login");
    </script>
</body>
</html>