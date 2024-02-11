<?php
session_start();
if (!isset($_SESSION['usager'])) {
    header('Location: login.php');
    exit;
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);
$new_editeur = $_POST['new_editeur'] ?? "";
$erreurs = "";
if (isset($_POST['submit'])) {
    if (!(strlen($new_editeur) <= 20 && strlen($new_editeur) >= 3)) {
        $erreurs = "Le nom de l'éditeur doit être entre 3 et 20 caractères.";
    }

    if (empty($erreurs)) {
        $_SESSION['new_editeur'] = $new_editeur;
        header('Location: ../../index.php');
        exit;
    }
}
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Sommatif - Exercice 1A</title>
    <meta name="author" content="Olivier Côté">
    <meta name="description" content="Exercice 1A">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../../css/styles.css?v=1.0.0">
    <script src="../../js/scripts.js?v=1.0.0" defer></script>
</head>
<body id="body-login-logout">
<div class="header">
    <a href="../../index.php" class="back-to-index">Retour</a>
</div>
<form method="post" class="form">
    <?php
    if (!empty($erreurs)):
        echo "<div class='error-msg'><span>$erreurs</span></div>";
        $erreurs = "";
    endif;

    ?>
    <label for="new_editeur">Nom de l'éditeur:</label><br>
    <input type="text" id="new_editeur" name="new_editeur" value="<?= $new_editeur; ?>">
    <br>
    <br><br>
    <input id="button-submit" type="submit" name="submit" value="Envoyer">
</form>
</body>
</html>
