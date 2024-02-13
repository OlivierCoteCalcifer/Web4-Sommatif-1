<?php

session_start();
require_once 'php/classes/Repertoire.php';
require_once 'php/classes/Jeu.php';
require_once 'php/classes/Editeur.php';
require_once 'php/classes/Difficulte.php';
require_once 'php/bd.php';

use Cegep\Web4\GestionJeu\{Jeu, Repertoire};

$gamesData = getTousLesJeux();
//usort($games, fn($a, $b) => $a->getTitre() <=> $b->getTitre());
 ?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Sommatif - Exercice 1A</title>
    <meta name="author" content="Olivier Côté">
    <meta name="description" content="Exercice 1A">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/styles.css?v=1.0.0">
    <script src="js/scripts.js?v=1.0.0" defer></script>
</head>
<body>
<div class="header">
    <?php
    if (!isset($_SESSION['estConnecte'])) {
    ?>
        <a href="php/pages/login.php"> Se connecter</a>
    <?php
    } else {
    ?>
        <div>
            <a href="php/pages/ajoutEditeur.php">Ajouter un éditeur</a>
            <a href="php/pages/ajoutJeu.php">Ajouter un jeu</a>
            <a href="php/pages/logout.php">Déconnecter</a>
        </div>
    <?php
    }
    ?>
</div>
<h1>Sommatif #1</h1>
<ul id="liste-jeux">
    <?php
    if (!empty($gamesData)) {
    foreach ($gamesData->getJeux() as $game) {
        var_dump(getEditeurBd($game->getEditeur()->nom));
    ?>
    <li class="difficulte-<?= $game->getDifficulte()->value ?>">
        <p class="titre-jeu"><?= $game->getTitre() ?></p>
        <p class="editeur-jeu"><?= getEditeurBd($game->getEditeur()->nom) ?></p>
    </li>
    <?php
    }
    } else {
    echo "<h1>Aucun jeu pour le moment...</h1>";
    } ?>
</ul>
</html>
