<?php
session_start();
require_once "function.php";

// Protection auteur
if (!isset($_SESSION['user']) || $_SESSION['user']['type'] !== 'auteur') {
    header('Location: index.php');
    exit;
}

$error = '';
$success = '';

// ✅ Récupération de toutes les catégories
$categories = getAllCategories();

if (isset($_POST['submit'])) {
    // Validation des champs obligatoires
    if (
        empty($_POST['titre']) ||
        empty($_POST['dateCreation']) ||
        empty($_POST['contenu'])
    ) {
        $error = "Tous les champs sont obligatoires.";
    }
    // ✅ Vérification qu'au moins une catégorie est sélectionnée
    elseif (empty($_POST['categories'])) {
        $error = "Veuillez sélectionner au moins une catégorie.";
    }
    // Vérification de l'image
    elseif (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        $error = "Veuillez sélectionner une image valide.";
    } else {
        $image = $_FILES['image'];
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $maxSize = 5 * 1024 * 1024; // 5 Mo

        // Validation du type et de la taille
        if (!in_array($image['type'], $allowedTypes)) {
            $error = "Format d'image non autorisé.";
        } elseif ($image['size'] > $maxSize) {
            $error = "L'image est trop volumineuse (max 5 Mo).";
        } else {
            // Préparation du nom et du chemin
            $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
            $newFileName = uniqid('article_', true) . '.' . $extension;
            $uploadDir = 'uploads/articles/';
            
            // Créer le dossier s'il n'existe pas
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            $uploadPath = $uploadDir . $newFileName;
            
            // ✅ Date de parution = AUJOURD'HUI (automatique)
            $dateParution = date('Y-m-d');

            // Déplacement du fichier
            if (move_uploaded_file($image['tmp_name'], $uploadPath)) {
                // Insertion en base
                $id = addArticle(
                    $_POST['titre'],
                    $_POST['dateCreation'],    // ✅ Date choisie par l'auteur
                    $dateParution,              // ✅ Aujourd'hui (automatique)
                    $_SESSION['user']['id'],
                    $uploadPath,
                    $_POST['contenu']
                );

                if ($id) {
                    // ✅ Ajout des catégories sélectionnées
                    $categoriesAdded = getAllCategories($id, $_POST['categories']);
                    if ($categoriesAdded) {
                        header("Location: singleArticle.php?id=$id&success=created");
                        exit;
                    } else {
                    $error = "Erreur lors de la création de l'article.";
                    }
                } else {
                    $error = "Erreur lors de l'upload de l'image.";
                }
            }
        }
    }
}
require_once "header.php";
?>

<<div class="container mt-5">
    <div class="card shadow-sm border-start border-primary rounded-4" style="max-width: 700px; margin: auto;">
        <div class="card-body">
            <h4 class="card-title text-center mb-4">📝 Ajouter un Article</h4>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="titre" class="form-label">Titre de l'article *</label>
                    <input type="text" class="form-control" id="titre" name="titre" required maxlength="255" value="<?= htmlspecialchars($_POST['titre'] ?? '') ?>">
                </div>

                <div class="mb-3">
                    <label for="dateCreation" class="form-label">
                        Date de création *
                        <small class="text-muted">(Quand avez-vous rédigé cet article ?)</small>
                    </label>
                    <input type="date" class="form-control" id="dateCreation" name="dateCreation" required max="<?= date('Y-m-d') ?>" value="<?= $_POST['dateCreation'] ?? date('Y-m-d') ?>">
                    <small class="form-text text-muted">
                        La date ne peut pas être dans le futur
                    </small>
                </div>

                <div class="mb-3">
                    <label for="dateParutionDisplay" class="form-label">
                        Date de parution
                        <small class="text-muted">(Automatique)</small>
                    </label>
                    <input type="text" id="dateParutionDisplay" class="form-control" value="Aujourd'hui : <?= date('d/m/Y') ?>" disabled>
                    <small class="form-text text-muted">
                        L'article sera publié immédiatement
                    </small>
                </div>

                <div class="mb-3">
                    <label for="auteur" class="form-label">Auteur</label>
                    <input type="text" id="auteur" class="form-control" value="<?= htmlspecialchars($_SESSION['user']['pseudo']) ?>" disabled>
                </div>

                <!-- ✅ SECTION CATÉGORIES -->
                <div class="mb-3">
                    <label class="form-label">Catégories * <small class="text-muted">(Sélectionnez au moins une catégorie)</small></label>
                    <div class="border rounded p-3" style="max-height: 300px; overflow-y: auto;">
                        <?php foreach ($categories as $categorie): ?>
                            <div class="form-check mb-2">
                                <input 
                                    class="form-check-input" 
                                    type="checkbox" 
                                    name="categories[]" 
                                    value="<?= $categorie['id_categorie'] ?>" 
                                    id="cat_<?= $categorie['id_categorie'] ?>"
                                    <?= (isset($_POST['categories']) && in_array($categorie['id_categorie'], $_POST['categories'])) ? 'checked' : '' ?>
                                >
                                <label class="form-check-label" for="cat_<?= $categorie['id_categorie'] ?>">
                                    <?php if (!empty($categorie['avatar'])): ?>
                                        <img src="<?= htmlspecialchars($categorie['avatar']) ?>" alt="" style="width: 20px; height: 20px; object-fit: cover; border-radius: 3px;">
                                    <?php endif; ?>
                                    <strong><?= htmlspecialchars($categorie['nom_categorie']) ?></strong>
                                    <?php if (!empty($categorie['description'])): ?>
                                        <small class="text-muted">- <?= htmlspecialchars($categorie['description']) ?></small>
                                    <?php endif; ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="contenu" class="form-label">Contenu de l'article *</label>
                    <textarea class="form-control" id="contenu" name="contenu" rows="10" required placeholder="Rédigez votre article ici..."><?= htmlspecialchars($_POST['contenu'] ?? '') ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Image de l'article *</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/jpeg,image/png,image/gif,image/webp" required>
                    <small class="form-text text-muted">Formats acceptés : JPG, PNG, GIF, WEBP (Max : 5 Mo)</small>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" name="submit" class="btn btn-primary">
                        ✅ Publier l'article
                    </button>
                    <a href="myArticles.php" class="btn btn-outline-secondary">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>


<?php require_once "footer.php"; ?>