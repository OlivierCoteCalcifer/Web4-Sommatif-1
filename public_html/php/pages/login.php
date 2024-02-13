<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);
$usager = $_POST['usager'] ?? "";
$password = $_POST['password'] ?? "";
$erreurs = [];
if (isset($_POST['submit'])) {
    if (empty($usager) || empty($password)) {
        $erreurs = " ** Les champs usager et mot de passe sont requis.";
    } elseif (!($usager == "Olivier" && $password == "1234")) {
        $erreurs = " ** Les informations entrées sont invalides.";
    }

    if (empty($erreurs)) {
        //** IMPORTANT ** Le session_start() doît être avant le html
        session_start();
        $_SESSION['estConnecte'] = true;
        header('Location: ../../index.php');
    }
} ?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Sommatif - Exercice 1A</title>
    <meta name="author" content="Olivier Côté">
    <meta name="description" content="Exercice 1A">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../../css/styles.css?v=1.0.0">
    <script src="../../js/scripts.js?v=1.0.0" defer></script>
</head>
<body id="body-login-logout">
<div class="header">
    <a href="../../index.php" class="back-to-index">Retour</a>
</div>
<form method="post" class="form">
    <?php
    if (!empty($erreurs)):
        echo "<div class='error-msg'><span>$erreurs</span></div>";
    endif;
    ?>
    <label for="usager">Usager</label><br>
    <input type="text" id="usager" name="usager" value="<?= $usager; ?>">
    <br>
    <label for="password">Mot de passe:</label><br>
    <input type="text" id="password" name="password" value="">
    <br><br>
    <input id="button-submit" type="submit" name="submit" value="Envoyer">
</form>
</body>
</html>
