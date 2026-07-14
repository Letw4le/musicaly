<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Profil</title>
</head>
<body>
    <div id="background"></div>

    <?php require "menu.php";?>

    <div id="profile_div">
        <div id="profile_title">Bonjour <?php echo $_SESSION['user']; ?> !</div>
        <div id="profile_subtitle">Vous êtes déjà connecté.</div>
        <a href="index.php?page=log_out" id="profile_logout">Se déconnecter</a>
    </div>


    <script src="assets/js/script.js"></script>
    <script>
        DisplayHeader("login");
    </script>
</body>
</html>