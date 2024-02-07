<?php

namespace Cegep\Web4\GestionJeu;

/**
 * Représente les différentes difficultés d'un jeu.
 */
enum Difficulte: int
{
    /**
     * Très facile avec une valeur de 1.
     */
    case Tres_Facile = 1;

    /**
     * Facile avec une valeur de 2.
     */
    case Facile = 2;

    /**
     * Moyen avec une valeur de 3.
     */
    case Moyen = 3;

    /**
     * Difficileavec une valeur de 4.
     */
    case Difficile = 4;

    /**
     * Très difficileavec une valeur de 5.
     */
    case Tres_difficile = 5;
}
