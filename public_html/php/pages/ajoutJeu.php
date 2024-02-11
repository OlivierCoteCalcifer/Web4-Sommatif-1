<?php

session_start();
if (!isset($_SESSION['usager'])) {
    header('Location: login.php');
    exit;
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

$nom = $_POST['nom'] ?? "";
$editeur = $_POST['editeur'] ?? "";
$difficulte = $_POST['difficulte'] ?? "";
$erreurs = "";

if (isset($_POST['submit'])) {
    if (!(strlen($nom) <= 100 && strlen($nom) >= 3)) {
        $erreurs = "Le nom du jeu doit être entre 3 et 100 caractères.";
    }
    if (empty($erreurs)) {
        $_SESSION['nom'] = $nom;
        $_SESSION['editeur'] = $editeur;
        $_SESSION['difficulte'] = $difficulte;
        header('Location: ../../index.php');
        exit;
    }
}
?>


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
    if (!empty($erreurs)) {
        echo "<div class='error-msg'><span>$erreurs</span></div>";
        $erreurs = "";
    }
    ?>
    <label for="nom">Titre:</label><br>
    <input type="text" id="nom" name="nom" value="<?= $nom; ?>">
    <br>

    <label for="editeur">Éditeur:</label><br>
    <select required id="editeur" name="editeur">
        <option value="">Sélectionnez un éditeur</option>
        <option value="Bandai_Namco" <?= $editeur == "Bandai_Namco" ? "selected" : ""; ?>>Bandai Namco</option>
        <option value="CD_projekt_Red" <?= $editeur == "CD_projekt_Red" ? "selected" : ""; ?>>CD projekt Red</option>
        <option value="Capcom" <?= $editeur == "Capcom" ? "selected" : ""; ?>>Capcom</option>
    </select><br>

    <label for="difficulte">Difficulté:</label><br>
    <select required id="difficulte" name="difficulte">
        <option value="">Sélectionnez une difficulté</option>
        <option value="Tres_Facile" <?= $difficulte == "Tres_Facile" ? "selected" : ""; ?>>Très facile</option>
        <option value="Facile" <?= $difficulte == "Facile" ? "selected" : ""; ?>>Facile</option>
        <option value="Moyen" <?= $difficulte == "Moyen" ? "selected" : ""; ?>>Moyen</option>
        <option value="Difficile" <?= $difficulte == "Difficile" ? "selected" : ""; ?>>Difficile</option>
        <option value="Tres_difficile" <?= $difficulte == "Tres_difficile" ? "selected" : ""; ?>>Très difficile</option>
    </select>
    <br>
    <br><br>
    <input id="button-submit" type="submit" name="submit" value="Envoyer">
</form>

</body>
</html>
