<?php

use Cegep\Web4\GestionJeu\Jeu;
use Cegep\Web4\GestionJeu\Repertoire;
use Cegep\Web4\GestionJeu\Editeur;
use Cegep\Web4\GestionJeu\Difficulte;

$host = 'db'; // localhost ou adresse
$user = 'root';
$password = 'root';
$db = 'database';

/**
 * Cette fonction créer une connection avec la base de données.
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
function ajoutJeu(object $jeu): bool
{
    if (verifGameExist($jeu)) {
        return true;
    }
    $conn = makeConnection();

    $titre = $jeu->getTitre();
    $editeur = $jeu->getEditeur()->getNom();
    $editeurId = getEditeurId($conn, $editeur);
    $difficulte = $jeu->getDifficulte()->value;
    $query = "INSERT INTO jeu (nom_jeu, editeur_jeu, difficulte_jeu) VALUES (:titre, :editeurId, :difficulte)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':titre', $titre);
    $stmt->bindParam(':editeurId', $editeurId, PDO::PARAM_INT);
    $stmt->bindParam(':difficulte', $difficulte);

    $stmt->execute();
    $stmt = null;
    $conn = null;
    return false;
}


/**
 * Cette méthode vérifie si le jeu existe dans la base de données et renvoie
 * @param object $jeu
 * @return bool
 */
function verifGameExist(object $jeu): bool
{
    $conn = makeConnection();
    $titre = strtolower($jeu->getTitre());
    $editeurNom = $jeu->getEditeur()->getNom();
    $editeurId = getEditeurId($conn, $editeurNom);

    $checkQuery = "SELECT COUNT(*) FROM jeu WHERE LOWER(nom_jeu) = :titre AND editeur_jeu = :editeurId";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bindParam(':titre', $titre);
    $checkStmt->bindParam(':editeurId', $editeurId);
    $checkStmt->execute();

    $result = $checkStmt->fetchColumn() > 0;
    $checkStmt = null;
    $conn = null;
    return $result;
}

/**
 * Ajoute un éditeur dans la table Editeur si un éditeur avec le même nom n'existe pas déjà.
 * Le nom de l'éditeur est converti en majuscules avant l'insertion pour assurer
 * l'unicité indépendamment de la casse.
 *
 * @param string $nom Le nom de l'éditeur à ajouter.
 * @return bool
 */
function ajoutEditeur(string $nom): bool
{
    $conn = makeConnection();

    $nomUpper = strtoupper($nom);
    $checkQuery = "SELECT COUNT(*) FROM editeur WHERE UPPER(nom_editeur) = :nomUpper";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bindParam(':nomUpper', $nomUpper);
    $checkStmt->execute();
    $count = $checkStmt->fetchColumn();

    $conn = null;
    if ($count == 0) {
        $insertQuery = "INSERT INTO editeur(nom_editeur) VALUES(:nomUpper)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bindParam(':nomUpper', $nomUpper);
        $insertStmt->execute();
        $insertStmt = null;
        return true;
    } else {
        $checkStmt = null;
        return false;
    }
}

/**
 * Recuperate l'ID d'un éditeur à partir de son nom.
 *
 * @param PDO $conn La connexion à la base de données.
 * @param string $editeurNom Le nom de l'éditeur à rechercher.
 * @return int|false L'ID de l'éditeur trouvé, ou false si aucun éditeur n'a été trouvé.
 */
function getEditeurId(PDO $conn, string $editeurNom): false|int
{
    $query = "SELECT id FROM editeur WHERE nom_editeur = :editeurNom LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':editeurNom', $editeurNom);
    $stmt->execute();
    $editeurId = $stmt->fetchColumn();

    $conn = null;
    $stmt = null;
    return $editeurId ? (int)$editeurId : false;
}

/**
 * Cette methode vérifie s'il existe au moins un éditeur dans la BD.
 *
 * @return boolean
 */
function asEditeurDansLaBd(): bool
{
    $conn = makeConnection();

    $query = "SELECT * FROM editeur";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    $row = $stmt->fetch();
    $conn = null;
    $stmt = null;
    return $row === false;
}

/**
 * Cette fonction va chercher les editeurs dans la BD.
 * @return false|array
 */
function getAllEditeurBd(): false|array
{
    $conn = makeConnection();

    $query = "SELECT nom_editeur FROM editeur";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_COLUMN);
    $conn = null;
    $stmt = null;
    return $result;
}

/**
 * Cette fonction va chercher le nom d'un editeur dans la BD.
 * @param $Id
 * @return false|string
 */
function getEditeurBd($Id): false|string
{
    $conn = makeConnection();
    $query = "SELECT nom_editeur FROM editeur WHERE id = :id";
    $stmt = $conn->prepare($query);

    $stmt->bindParam(':id', $Id, PDO::PARAM_INT);

    $stmt->execute();

    $result =  $stmt->fetch(PDO::FETCH_COLUMN);
    $conn = null;
    $stmt = null;
    return $result;
}


/**
 * Cette methode renvoie la totalité de la table de jeu.
 *
 * @return Repertoire
 */
function getTousLesJeux(): Repertoire
{
    $conn = makeConnection();
    $query = "SELECT * FROM jeu";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    // Le fetch_ASSOC transforme routes les rangées en array associatifs pour appeler
    // selon le nom de la column.

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $games = new Repertoire();
    foreach ($rows as $row) {
        $jeu = new Jeu(
            $row['nom_jeu'],
            new Editeur($row['editeur_jeu']), Difficulte::from($row['difficulte_jeu'])
        );
        $games->ajouterJeu($jeu);
    }
    return $games;
}

