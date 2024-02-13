<?php

use Cegep\Web4\GestionJeu\Editeur;
use Cegep\Web4\GestionJeu\Difficulte;
use Cegep\Web4\GestionJeu\Jeu;
ob_start();
session_start();
if (!isset($_SESSION['estConnecte'])) {
    header('Location: login.php');
    exit;
}
include_once('../bd.php');
include_once('../classes/Jeu.php');
include_once('../classes/Editeur.php');
include_once('../classes/Difficulte.php');

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
        $jeu = new Jeu($nom, new Editeur($editeur), Difficulte::from($difficulte));
        if (!ajoutJeu($jeu)) {
            header('Location: ../../index.php');
            exit;
        } else {
            $erreurs = "Ce jeu existe. Veuillez entrez un autre jeu";
        }
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
<?php
if (!asEditeurDansLaBd()) {
    ?>
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
        <?php $editeurs = getAllEditeurBd(); ?>
        <label for="editeur">Éditeur:</label><br>
        <select required id="editeur" name="editeur">
            <option value="">Sélectionnez un éditeur</option>
            <?php
            foreach ($editeurs as $editeur) {
                ?>
                <option value="<?= $editeur ?? "selected" ?>"><?= $editeur ?></option>
                <?php
            }
            ?>
        </select><br>

        <label for="difficulte">Difficulté:</label><br>
        <select required id="difficulte" name="difficulte">
            <option value="">Sélectionnez une difficulté</option>
            <option value="1" <?= $difficulte == "1" ? "selected" : ""; ?>>Très facile</option>
            <option value="2" <?= $difficulte == "2" ? "selected" : ""; ?>>Facile</option>
            <option value="3" <?= $difficulte == "3" ? "selected" : ""; ?>>Moyen</option>
            <option value="4" <?= $difficulte == "4" ? "selected" : ""; ?>>Difficile</option>
            <option value="5" <?= $difficulte == "5" ? "selected" : ""; ?>>Très difficile</option>
        </select>
        <br>
        <br><br>
        <input id="button-submit" type="submit" name="submit" value="Envoyer">
    </form>
<?php } else {
    echo "<h1>Vous devez ajouter un editeur avant d'ajouter un jeu.</h1>";
} ?>
</body>
</html>
