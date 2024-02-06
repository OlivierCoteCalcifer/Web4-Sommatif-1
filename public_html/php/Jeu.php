<?php
namespace Cegep\Web4\GestionJeu;

/*
 * Class Jeu
 * @author Olivier Côté
 */

use Difficulte;

class Jeu
{
    /** @var string $titre Titre du jeu.*/
    private string $titre;

    /** @var Editeur  Editeur du jeu.*/
    private Editeur $editeur;

    /** @var Difficulte Difficulte du jeu.*/
    private Difficulte $difficulte;
    public function __construct($titre,$editeur,$difficulte)
    {
        $this->titre = $titre;
        $this->editeur = $editeur;
        $this->difficulte = $difficulte;
    }

    public function getTitre(): string
    {
        return $this->titre;
    }

    public function getEditeur(): Editeur
    {
        return $this->editeur;
    }

    public function getDifficulte(): Difficulte
    {
        return $this->difficulte;
    }
}


