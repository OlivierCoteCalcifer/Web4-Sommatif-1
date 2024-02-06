<?php

namespace Cegep\Web4\GestionJeu;


class Editeur
{       /** @var string Nom de l'editeur.*/
    public $nom;
    public function __construct($editeur){
        $this->nom = $editeur;
    }
}