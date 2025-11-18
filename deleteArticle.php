<?php
session_start();
require_once "includes/functions.php";

// Vérifier que l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
// ✅ AJOUTE ÇA : Vérifier que c'est un AUTEUR (pas un simple membre)
if ($_SESSION['user']['type'] !== 'auteur') {
    header('Location: index.php?error=unauthorized');
    exit;
}

// Récupérer l'ID de l'article
$id = (int)($_POST['id'] ?? 0);

if ($id <= 0) {
    header('Location: index.php?error=invalid');
    exit;
}

// Récupérer l'article pour vérifier les droits
$article = getArticleById($id);

if (!$article) {
    header('Location: index.php?error=notfound');
    exit;
}

// Vérifier que l'utilisateur est bien l'auteur
if ($_SESSION['user']['id'] !== $article['id_user']) {
    header('Location: article.php?id=' . $id . '&error=unauthorized');
    exit;
}

// Supprimer l'article
$cheminImage = !empty($article['picture']) ? $article['picture'] : null;

if (deleteArticle($id, $cheminImage)) {
    header('Location: index.php?success=deleted');
} else {
    header('Location: article.php?id=' . $id . '&error=delete');
}
exit;