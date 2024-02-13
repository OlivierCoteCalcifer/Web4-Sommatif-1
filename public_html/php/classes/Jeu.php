<?php

namespace Cegep\Web4\GestionJeu;

/**
 * Représente un jeu.
 *
 * Class Jeu
 * @author Olivier Côté
 */
class Jeu
{
    /**
     * @var string $titre Titre du jeu.
     */
    private string $titre;

    /**
     * @var Editeur $editeur Editeur du jeu.
     */
    private Editeur $editeur;

    /**
     * @var Difficulte $difficulte Difficulté du jeu.
     */
    private Difficulte $difficulte;

    /**
     * Constructeur de la classe Jeu.
     *
     * @param string $titre Le titre du jeu.
     * @param Editeur $editeur L'éditeur du jeu.
     * @param Difficulte $difficulte La difficulté du jeu.
     */
    public function __construct(string $titre, Editeur $editeur, Difficulte $difficulte)
    {
        $this->titre = $titre;
        $this->editeur = $editeur;
        $this->difficulte = $difficulte;
    }

    /**
     * Récupère le titre du jeu.
     *
     * @return string Le titre du jeu.
     */
    public function getTitre(): string
    {
        return $this->titre;
    }

    /**
     * Récupère l'éditeur du jeu.
     *
     * @return Editeur L'éditeur du jeu.
     */
    public function getEditeur(): Editeur
    {
        return $this->editeur;
    }

    /**
     * Récupère la difficulté du jeu.
     *
     * @return Difficulte La difficulté du jeu.
     */
    public function getDifficulte(): Difficulte
    {
        return $this->difficulte;
    }
}
