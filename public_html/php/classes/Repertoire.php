<?php

namespace Cegep\Web4\GestionJeu;

/**
 * Représente un répertoire de jeux.
 */
class Repertoire
{
    /**
     * @var Jeu[] Liste des jeux.
     */
    private array $liste = [];

    /**
     * Ajoute un jeu au répertoire.
     *
     * @param Jeu $jeu L'objet Jeu à ajouter.
     */
    public function ajouterJeu(Jeu $jeu): void
    {
        $this->liste[] = $jeu;
    }

    /**
     * Récupère la liste des jeux du répertoire.
     *
     * @return Jeu[] La liste des jeux.
     */
    public function getJeux(): array
    {
        return $this->liste;
    }
}
