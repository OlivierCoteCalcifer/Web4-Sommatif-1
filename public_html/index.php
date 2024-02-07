<?php

require_once 'php/Repertoire.php';
require_once 'php/Jeu.php';
require_once 'php/Editeur.php';
require_once 'php/Difficulte.php';

use Cegep\Web4\GestionJeu\{Jeu, Editeur, Repertoire, Difficulte};

$repertoire = new Repertoire();
$publishers = [
    'Bandai Namco' => new Editeur('Bandai Namco'),
    'From Software' => new Editeur('From Software'),
    'Ubisoft' => new Editeur('Ubisoft'),
    'Bioware' => new Editeur('Bioware'),
    'Capcom' => new Editeur('Capcom'),
];

$gamesData = [
    ['One piece: Odyssey', $publishers['Bandai Namco'], Difficulte::Tres_difficile],
    ['Dark Souls 3', $publishers['From Software'], Difficulte::Difficile],
    ['Sekiro: Shadow die twice', $publishers['From Software'], Difficulte::Tres_difficile],
    ['Assassins Creed: Valhalla', $publishers['Ubisoft'], Difficulte::Facile],
    ['Mass Effect 2', $publishers['Bioware'], Difficulte::Tres_Facile],
    ['Mass Effect 1', $publishers['Bioware'], Difficulte::Facile],
    ['Mass Effect 3', $publishers['Bioware'], Difficulte::Moyen],
    ['Street Fighter 6', $publishers['Capcom'], Difficulte::Moyen],
    ['Prince of Persia: Warrior Within', $publishers['Ubisoft'], Difficulte::Difficile],
    ['Dragon Age: Inquisition', $publishers['Bioware'], Difficulte::Tres_Facile]
];
foreach ($gamesData as [$title, $publisher, $difficulty]) {
    $repertoire->ajouterJeu(new Jeu($title, $publisher, $difficulty));
}

$games = $repertoire->getJeux();
usort($games, fn($a, $b) => $a->getDifficulte()->value <=> $b->getDifficulte()->value);


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

<h1>Sommatif #1</h1>
<ul id="liste-jeux">
    <?php
    foreach ($games as $game) {
        ?>
        <li class="difficulte-<?= $game->getDifficulte()->value ?>">
        <p class="titre-jeu"><?= $game->getTitre() ?></p>
        <p class="editeur-jeu"><?= $game->getEditeur()->nom ?></p>
        </li>
    <?php } ?>
</ul>
</html>