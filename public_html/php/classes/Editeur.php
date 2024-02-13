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
    public function __construct(string $editeur)
    {
        $this->nom = $editeur;
    }

    /**
     * Getter pour le nom
     */
    public function getNom(): string
    {
        return $this->nom;
    }

}
