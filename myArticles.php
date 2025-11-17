<?php
session_start();
require_once "function.php";

// Seuls les auteurs ont accès
if (!isset($_SESSION['user']) || $_SESSION['user']['type'] !== 'auteur') {
    header('Location: index.php');
    exit;
}

$mesArticles = getArticlesByUser($_SESSION['user']['id']);

require_once "header.php";
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-journal-text"></i> Mes articles</h2>
        <a href="addArticle.php" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Créer un article
        </a>
    </div>
    
    <?php if (empty($mesArticles)): ?>
        <div class="alert alert-info">
            Vous n'avez pas encore créé d'article. 
            <a href="addArticle.php">Créer votre premier article</a>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($mesArticles as $article): ?>
                <?php $categories = getCategoriesByArticle($article['id_article']);?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100">
                        <?php if (!empty($article['picture'])): ?>
                        <img src="<?= htmlspecialchars($article['picture']) ?>" class="card-img-top" style="height: 200px; object-fit: cover;" alt="<?= htmlspecialchars($article['titre']) ?>"> <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($article['titre']) ?></h5>
                            <p class="card-text text-muted"><small><i class="bi bi-calendar-event"></i><?= htmlspecialchars($article['date_creation']) ?></small></p>
                        </div>
                        <div class="card-footer bg-white">
                            <div class="btn-group w-100" role="group">
                                <a href="singleArticle.php?id=<?= $article['id_article'] ?>"class="btn rounded-pill btn-sm btn-outline-primary"><i class="bi bi-eye"></i> Voir</a>
                                <a href="upDateArticle.php?id=<?= $article['id_article'] ?>"class="btn rounded-pill btn-sm btn-outline-warning"><i class="bi bi-pencil"></i> Modifier</a>
                                <a href="deleteArticle.php?id=<?= $article['id_article'] ?>"class="btn rounded-pill btn-sm btn-outline-danger"onclick="return confirm('Supprimer cet article ?')">
                                    <i class="bi bi-trash"></i> Supprimer </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once "footer.php"; ?>