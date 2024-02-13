<?php

use Cegep\Web4\GestionJeu\Jeu;
use Cegep\Web4\GestionJeu\Repertoire;
use Cegep\Web4\GestionJeu\Editeur;
use Cegep\Web4\GestionJeu\Difficulte;

$host = 'db'; // localhost ou adresse
$user = 'root';
$password = 'root';
$db = 'database';
// ajoutJeu
/**
 * Cette fonction creer une connection.
 *
 * @return PDO
 */
function makeConnection(): PDO
{
    global $host, $db, $user, $password;
    return new PDO("mysql:host=$host;dbname=$db", $user, $password);
}

/**
 * Ajoute un jeu à la table JEU si un jeu avec le même nom et éditeur n'existe pas déjà.
 *
 * @param object $jeu Un objet contenant les propriétés du jeu.
 * @return bool Retourne true si le jeu a été ajouté, false sinon.
 */
function ajoutJeu(object $jeu): bool {

    $conn = makeConnection();
    $titre = $jeu->getTitre();
    $editeurNom = $jeu->getEditeur()->getNom();
    $difficulte = $jeu->getDifficulte()->value;

    $editeurQuery = "SELECT ID FROM Editeur WHERE Nom_Editeur = :editeurNom";
    $editeurStmt = $conn->prepare($editeurQuery);
    $editeurStmt->bindParam(':editeurNom', $editeurNom);
    $editeurStmt->execute();
    $editeurId = $editeurStmt->fetchColumn();

    if (!$editeurId) {
        return true;
    }

    $checkQuery = "SELECT COUNT(*) FROM Jeu WHERE LOWER(Nom_jeu) = :titre AND Editeur_jeu = :editeurId";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bindParam(':titre', $titre);
    $checkStmt->bindParam(':editeurId', $editeurId, PDO::PARAM_INT);
    $checkStmt->execute();

    if ($checkStmt->fetchColumn() > 0) {
        return true;
    }

    $query = "INSERT INTO Jeu (Nom_jeu, Editeur_jeu, Difficulte_jeu) VALUES (:titre, :editeurId, :difficulte)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':titre', $titre);
    $stmt->bindParam(':editeurId', $editeurId, PDO::PARAM_INT);
    $stmt->bindParam(':difficulte', $difficulte);

    $stmt->execute();
    $stmt = null;

    return false;
}



/**
 * Ajoute un éditeur dans la table Editeur si un éditeur avec le même nom n'existe pas déjà.
 * Le nom de l'éditeur est converti en minuscules avant l'insertion pour assurer l'unicité indépendamment de la casse.
 *
 * @param string $nom Le nom de l'éditeur à ajouter.
 * @return void
 */
function ajoutEditeur(string $nom): void
{
    $conn = makeConnection();

    $nomUpper = strtoupper($nom);

    $checkQuery = "SELECT COUNT(*) FROM Editeur WHERE UPPER(Nom_Editeur) = :nomUpper";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bindParam(':nomUpper', $nomUpper);
    $checkStmt->execute();

    $count = $checkStmt->fetchColumn();

    if ($count == 0) {
        $insertQuery = "INSERT INTO Editeur(Nom_Editeur) VALUES(:nomUpper)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bindParam(':nomUpper', $nomUpper);
        $insertStmt->execute();
        $insertStmt = null;
    }
    $checkStmt = null; //
}


/**
 * Cette methode vérifie s'il existe au moins un éditeur dans la BD.
 *
 * @return boolean
 */
function asEditeurDansLaBd(): bool
{
    $conn = makeConnection();

    $query = "SELECT * FROM Editeur";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    $row = $stmt->fetch();
    return $row === false;
}

/**
 * Cette fonction va chercher les editeurs dans la BD.
 * @return false|array
 */
function getAllEditeurBd(): false|array
{
    $conn = makeConnection();

    $query = "SELECT Nom_Editeur FROM Editeur";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

/**
 * Cette fonction va chercher le nom d'un editeur dans la BD.
 * @param $nom
 * @return false|string
 */
function getEditeurBd($Id): false|string
{
    $conn = makeConnection();
    $query = "SELECT Nom_Editeur FROM Editeur WHERE ID = :id";
    $stmt = $conn->prepare($query);

    $stmt->bindParam(':id', $Id, PDO::PARAM_INT);

    $stmt->execute();

     return $stmt->fetch(PDO::FETCH_COLUMN);
}


/**
 * Cette methode renvoie la totalité de la table de jeu.
 *
 * @return Repertoire
 */
function getTousLesJeux(): Repertoire
{
    $conn = makeConnection();
    $query = "SELECT * FROM Jeu";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    // Le fetch_ASSOC transforme toutes les rangées en array associatifs pour appeler
    // selon le nom de la column.
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $games = new Repertoire();
    foreach ($rows  as $row) {
        $jeu = new Jeu($row['Nom_jeu'],
            new Editeur($row['Editeur_jeu']),Difficulte::from($row['Difficulte_jeu']));
        $games->ajouterJeu($jeu);
    }
    return $games;
}

