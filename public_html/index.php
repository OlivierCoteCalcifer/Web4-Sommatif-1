<?php

require_once('php/Repertoire.php');
require_once('php/Jeu.php');
require_once('php/Editeur.php');
require_once('php/Difficulte.php');

use Cegep\Web4\GestionJeu\Jeu;
use Cegep\Web4\GestionJeu\Editeur;
use Cegep\Web4\GestionJeu\Repertoire;
use Cegep\Web4\GestionJeu\Difficulte;

$repertoire = new Repertoire();
$editeurBandai = new Editeur('Bandai Namco');
$editeurFS = new Editeur('From Software');
$editeurUbi = new Editeur('Ubisoft');
$editeurBio = new Editeur('Bioware');
$editeurCapcom = new Editeur('Capcom');
$repertoire->ajouterJeu([
    new Jeu('One piece: Odyssey', $editeurBandai, Difficulte::Tres_difficile),
    new Jeu('Dark Souls 3', $editeurFS, Difficulte::Difficile),
    new Jeu('Sekiro: Shadow die twice', $editeurFS, Difficulte::Tres_difficile),
    new Jeu('Assasins Creed: Valhalla', $editeurUbi, Difficulte::Facile),
    new Jeu('Dragon Age: Inquisition', $editeurBio, Difficulte::Tres_Facile),
    new Jeu('Mass Effect 1', $editeurBio, Difficulte::Facile),
    new Jeu('Mass Effect 2', $editeurBio, Difficulte::Tres_Facile),
    new Jeu('Mass Effect 3', $editeurBio, Difficulte::Moyen),
    new Jeu('Prince of Persia: Warrior Within', $editeurUbi, Difficulte::Difficile),
    new Jeu('Street Fighter 6', $editeurBandai, Difficulte::Moyen)
]);
//array_multisort(array_column((array)$repertoire, 'difficulte'), SORT_ASC, $liste);

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
    var_dump($repertoire) ?>
</html>