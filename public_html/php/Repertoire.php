<?php

namespace Cegep\Web4\GestionJeu;

class Repertoire
{
    /** @var Jeu[] Liste de jeux */
    private array $liste = [];

    public function ajouterJeu(Jeu ...$jeux): void
    {
        foreach ($jeux as $jeu) {
            $this->liste[] = $jeu;
        }
    }
}
