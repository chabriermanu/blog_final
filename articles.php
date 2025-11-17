<?php
session_start();
require_once "function.php";

$articles = getAllArticle();

require_once "header.php";
?>

<div class="container mt-5">
    <h2 class="mb-4">📚 Liste des Articles</h2>

    <?php if (empty($articles)): ?>
        <div class="alert alert-info">Aucun article disponible.</div>
    <?php else: ?>
        <div class="list-group">
            <?php foreach ($articles as $article): ?>
                <a href="singleArticle.php?id=<?= $article['id'] ?>" class="list-group-item list-group-item-action"><h5><?= htmlspecialchars($article['titre'] ?? '') ?></h5>
                <small>Créé le <?= htmlspecialchars($article['date_creation'] ?? '') ?> Auteur : <?= htmlspecialchars($article['auteur'] ?? '') ?></small></a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once "footer.php"; ?>
