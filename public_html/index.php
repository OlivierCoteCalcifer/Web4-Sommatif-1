<?php

session_start();
require_once 'php/classes/Repertoire.php';
require_once 'php/classes/Jeu.php';
require_once 'php/classes/Editeur.php';
require_once 'php/classes/Difficulte.php';

use Cegep\Web4\GestionJeu\{Jeu, Editeur, Repertoire, Difficulte};

$repertoire = new Repertoire();
$editeurs = [
    'Bandai Namco' => new Editeur('Bandai Namco'),
    'From Software' => new Editeur('From Software'),
    'Ubisoft' => new Editeur('Ubisoft'),
    'Bioware' => new Editeur('Bioware'),
    'Capcom' => new Editeur('Capcom'),
];

$gamesData = [
    ['One piece: Odyssey', $editeurs['Bandai Namco'], Difficulte::Tres_difficile],
    ['Dark Souls 3', $editeurs['From Software'], Difficulte::Difficile],
    ['Sekiro: Shadow die twice', $editeurs['From Software'], Difficulte::Tres_difficile],
    ['Assassins Creed: Valhalla', $editeurs['Ubisoft'], Difficulte::Facile],
    ['Mass Effect 2', $editeurs['Bioware'], Difficulte::Tres_Facile],
    ['Mass Effect 1', $editeurs['Bioware'], Difficulte::Facile],
    ['Mass Effect 3', $editeurs['Bioware'], Difficulte::Moyen],
    ['Street Fighter 6', $editeurs['Capcom'], Difficulte::Moyen],
    ['Prince of Persia: Warrior Within', $editeurs['Ubisoft'], Difficulte::Difficile],
    ['Dragon Age: Inquisition', $editeurs['Bioware'], Difficulte::Tres_Facile]
];
foreach ($gamesData as [$title, $editeur, $difficulty]) {
    $repertoire->ajouterJeu(new Jeu($title, $editeur, $difficulty));
}
$games = $repertoire->getJeux();
usort($games, fn($a, $b) => $a->getTitre() <=> $b->getTitre());
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
    if (!isset($_SESSION['usager'])) {
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
    foreach ($games as $game) {
        ?>
        <li class="difficulte-<?= $game->getDifficulte()->value ?>">
            <p class="titre-jeu"><?= $game->getTitre() ?></p>
            <p class="editeur-jeu"><?= $game->getEditeur()->nom ?></p>
        </li>
        <?php
    } ?>
</ul>
</html>
