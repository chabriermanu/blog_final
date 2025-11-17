<?php
session_start();
require_once "function.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_article = (int)($_POST['id_article'] ?? 0);
    $contenu = htmlspecialchars(trim($_POST['commentaire'] ?? ''));
    
    // Validation
    if (empty($contenu) || $id_article <= 0) {
        header('Location: singleArticle.php?id=' . $id_article . '&error=empty');
        exit;
    }
    
    // Vérifier si c'est un membre connecté ou un visiteur
    if (isset($_SESSION['id_user'])) {
        // Membre connecté
        $id_user = $_SESSION['id_user'];
        $pseudo_visiteur = null;
    } else {
        // Visiteur
        $id_user = null;
        $pseudo_visiteur = htmlspecialchars(trim($_POST['pseudo'] ?? ''));
        
        if (empty($pseudo_visiteur) || strlen($pseudo_visiteur) < 3) {
            header('Location: singleArticle.php?id=' . $id_article . '&error=pseudo');
            exit;
        }
    }
    
    // Ajouter le commentaire
    if (addCommentaire($id_article, $contenu, $id_user, $pseudo_visiteur)) {
        header('Location: singleArticle.php?id=' . $id_article . '&success=comment');
    } else {
        header('Location: singleArticle.php?id=' . $id_article . '&error=failed');
    }
    exit;
}

header('Location: index.php');
exit;