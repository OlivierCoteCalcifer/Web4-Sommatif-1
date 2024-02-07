<?php

namespace Cegep\Web4\GestionJeu;

/**
 * Représente l'éditeur d'un jeu.
 */
class Editeur
{
    /**
     * @var string Nom de l'editeur.
     */
    public string $nom;

    /**
     * Editeur constructor.
     *
     * @param string $editeur Nom de l'editeur.
     */
    public function __construct($editeur)
    {
        $this->nom = $editeur;
    }
}
