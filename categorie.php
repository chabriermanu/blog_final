<?php
session_start();
require_once "includes/functions.php";

// Récupérer l'ID de la catégorie
$id_categorie = (int)($_GET['id'] ?? 0);

if ($id_categorie <= 0) {
    header('Location: index.php');
    exit;
}

// Récupérer les infos de la catégorie
$categories = getAllCategories();
$categorie_actuelle = null;
foreach ($categories as $cat) {
    if ($cat['id_categorie'] == $id_categorie) {
        $categorie_actuelle = $cat;
        break;
    }
}

if (!$categorie_actuelle) {
    header('Location: index.php?error=category_not_found');
    exit;
}

// Récupérer tous les articles de cette catégorie
$articles = getArticlesByCategory($id_categorie);

require_once "header.php";
?>

<div class="container mt-5">
    <div class="d-flex align-items-center mb-4">
    <!-- 1️⃣ L'EMOJI (💥, 🗺️, etc.) -->
        <?php if (!empty($categorie_actuelle['avatar'])): ?>
            <div style="font-size: 3rem; margin-right: 1rem;">
                <?= $categorie_actuelle['avatar'] ?>
            </div>
        <?php endif; ?>
    
    <!-- 2️⃣ LE NOM DE LA CATÉGORIE (Action, Aventure, etc.) -->
        <div>
            <h2 class="mb-0">
                <span class="badge" style="background-color: <?= htmlspecialchars($categorie_actuelle['couleur']) ?>; color: white; font-size: 1.5rem;">
                    <?= htmlspecialchars($categorie_actuelle['nom_categorie']) ?> 
                </span>
            </h2>
        <!-- 3️⃣ LA DESCRIPTION -->
            <?php if (!empty($categorie_actuelle['description'])): ?>
            <p class="text-muted mt-2"><?= htmlspecialchars($categorie_actuelle['description']) ?></p>
            <?php endif; ?>
        <!-- 4️⃣ LE NOMBRE D'ARTICLES -->
            <small class="text-muted">
                <?= count($articles) ?> article<?= count($articles) > 1 ? 's' : '' ?>
            </small>
        </div>
    </div>

    <?php if (empty($articles)): ?>
        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i> Aucun article dans cette catégorie pour le moment.
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($articles as $article): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm">
                        <?php if (!empty($article['picture'])): ?>
                            <img src="<?= htmlspecialchars($article['picture']) ?>" 
                                 class="card-img-top" 
                                 style="height: 200px; object-fit: contain;"
                                 alt="<?= htmlspecialchars($article['titre']) ?>">
                        <?php endif; ?>
                        
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($article['titre']) ?></h5>
                            <p class="card-text text-muted">
                                <?= htmlspecialchars(mb_substr(strip_tags($article['contenu']), 0, 150)) ?>...
                            </p>
                            <p class="text-muted small">
                                <i class="bi bi-person"></i> <?= htmlspecialchars($article['auteur']) ?>
                                <br>
                                <i class="bi bi-calendar"></i> <?= date('d/m/Y', strtotime($article['date_creation'])) ?>
                            </p>
                        </div>
                        
                        <div class="card-footer bg-white">
                            <a href="singleArticle.php?id=<?= $article['id_article'] ?>" class="btn btn-primary btn-sm w-100">
                                <i class="bi bi-eye"></i> Lire l'article
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="mt-4">
        <a href="index.php" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Retour à l'accueil
        </a>
    </div>
</div>

<?php require_once "footer.php"; ?>