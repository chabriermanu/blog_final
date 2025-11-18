<?php
session_start();
require_once "function.php";

// Vérification de la méthode POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

// Récupération et validation des données
$id_article = (int)($_POST['id_article'] ?? 0);
$contenu = trim($_POST['contenu'] ?? '');

// Validation de l'article
if ($id_article <= 0) {
    header("Location: index.php");
    exit;
}

// Validation du contenu
if (empty($contenu) || strlen($contenu) > 1000) {
    header("Location: singleArticle.php?id=$id_article&error=empty");
    exit;
}

// Déterminer si c'est un membre ou un visiteur
if (isset($_SESSION['user'])) {
    // Membre connecté
    $id_user = $_SESSION['user']['id'];
    $pseudo_visiteur = null;
} else {
    // Visiteur non connecté
    $pseudo_visiteur = trim($_POST['pseudo_visiteur'] ?? '');
    
    if (empty($pseudo_visiteur) || strlen($pseudo_visiteur) > 50) {
        header("Location: singleArticle.php?id=$id_article&error=pseudo");
        exit;
    }
    
    $id_user = null;
}

// Insertion du commentaire
$result = addCommentaire($id_article, $contenu, $id_user, $pseudo_visiteur);
if ($result) {
    header("Location: singleArticle.php?id=$id_article&success=comment");
} else {
    header("Location: singleArticle.php?id=$id_article&error=failed");
}

exit;
