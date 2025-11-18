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
    <?php if (isset($_GET['success']) && $_GET['success'] === 'deleted'): ?>
        <div class="alert alert-success">
            Article supprimé avec succès !
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error']) && $_GET['error'] === 'failed'): ?>
        <div class="alert alert-danger">
            Erreur lors de la suppression de l'article.
        </div>
    <?php endif; ?>

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
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100">
                        <?php if (!empty($article['picture'])): ?>
                            <img src="<?= htmlspecialchars($article['picture']) ?>"
                                 class="card-img-top"
                                 style="height: 200px; object-fit: contain;"
                                 alt="<?= htmlspecialchars($article['titre']) ?>">
                        <?php endif; ?>

                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($article['titre']) ?></h5>
                            
                            <!-- ✅ Affichage des catégories -->
                            <?php 
                            $categories = getCategoriesByArticle($article['id_article']); 
                            if (!empty($categories)):
                            ?>
                                <div class="mb-2">
                                    <?php foreach ($categories as $categorie): ?>
                                        <span class="badge" style="background-color: <?= htmlspecialchars($categorie['couleur']) ?>; color: white;">
                                            <?= htmlspecialchars($categorie['nom_categorie']) ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            
                            <p class="card-text text-muted">
                                <small>
                                    <i class="bi bi-calendar-event"></i>
                                    <?= htmlspecialchars($article['date_creation']) ?>
                                </small>
                            </p>
                        </div>

                        <div class="card-footer bg-white">
                            <div class="btn-group w-100" role="group">
                                <a href="singleArticle.php?id=<?= $article['id_article'] ?>"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i> Voir
                                </a>
                                <a href="upDateArticle.php?id=<?= $article['id_article'] ?>"
                                   class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil"></i> Modifier
                                </a>
                                <a href="deleteArticle.php?id=<?= $article['id_article'] ?>"
                                   class="btn btn-sm btn-outline-danger"
                                   onclick="return confirm('Supprimer cet article ?')">
                                    <i class="bi bi-trash"></i> Supprimer
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once "footer.php"; ?>