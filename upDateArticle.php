<?php
session_start();
require_once "function.php";
require_once "header.php";

// Vérifier que l'utilisateur est connecté et est auteur
if (!isset($_SESSION['user']) || $_SESSION['user'] ['type'] !== 'auteur') {
    header('Location: index.php');
    exit;
}

// Vérifier si un ID est passé
if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = (int) $_GET['id'];
$post = getArticleById($id);

// Vérifier que l'article existe
if (!$post) {
    echo "<div class='alert alert-danger text-center'>Article introuvable.</div>";
    exit;
}

// Récupérer toutes les catégories disponibles
$allCategories = getAllCategories();

// Récupérer les catégories actuelles de l'article
$currentCategories = getCategoriesByArticle($id);
$currentCategoryIds = array_column($currentCategories, 'id');
?>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h2 class="fw-bold mb-4">
                <i class="bi bi-pencil-square"></i> Modifier l'article
            </h2>

            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="bi bi-check-circle"></i> Article modifié avec succès !
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="bi bi-exclamation-triangle"></i> 
                    <?php 
                    switch($_GET['error']) {
                        case 'empty': echo "Tous les champs sont obligatoires."; break;
                        case 'upload': echo "Erreur lors de l'upload de l'image."; break;
                        case 'failed': echo "Erreur lors de la modification."; break;
                        default: echo "Une erreur est survenue.";
                    }
                    ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form method="post" action="updateArticle.php" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $id ?>">

                <!-- Titre -->
                <div class="mb-3">
                    <label for="titre" class="form-label">Titre <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="titre" name="titre" value="<?= htmlspecialchars($post['titre']) ?>" required maxlength="200">
                </div>

                <!-- Contenu -->
                <div class="mb-3">
                    <label for="contenu" class="form-label">Contenu <span class="text-danger">*</span></label>
                    <textarea name="contenu" id="contenu" rows="10" class="form-control" required><?= htmlspecialchars($post['contenu']) ?></textarea>
                </div>

                <!-- Image actuelle -->
                <?php if (!empty($post['picture'])): ?>
                    <div class="mb-3">
                        <label class="form-label">Image actuelle</label>
                        <div class="border rounded p-2">
                            <img src="<?= htmlspecialchars($post['picture']) ?>" 
                                 alt="Image actuelle" 
                                 class="img-fluid" 
                                 style="max-height: 200px;">
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Nouvelle image (optionnelle) -->
                <div class="mb-3">
                    <label for="picture" class="form-label">
                        Changer l'image <small class="text-muted">(optionnel)</small>
                    </label>
                    <input type="file" 
                           class="form-control" 
                           id="picture" 
                           name="picture" 
                           accept="image/jpeg,image/png,image/jpg,image/webp">
                    <small class="text-muted">Formats acceptés : JPG, PNG, WEBP (max 2 Mo)</small>
                </div>

                <!-- Catégories -->
                <div class="mb-4">
                    <label class="form-label">Catégories <span class="text-danger">*</span></label>
                    <div class="border rounded p-3">
                        <?php foreach ($allCategories as $categorie): ?>
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       name="categories[]" 
                                       value="<?= $categorie['id'] ?>" 
                                       id="cat<?= $categorie['id'] ?>"
                                       <?= in_array($categorie['id'], $currentCategoryIds) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="cat<?= $categorie['id'] ?>">
                                    <?= htmlspecialchars($categorie['nom']) ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <small class="text-muted">Sélectionnez au moins une catégorie</small>
                </div>

                <!-- Boutons -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg"></i> Enregistrer les modifications
                    </button>
                    <a href="singleArticle.php?id=<?= $id ?>" class="btn btn-secondary">
                        <i class="bi bi-x-lg"></i> Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once "footer.php"; ?>