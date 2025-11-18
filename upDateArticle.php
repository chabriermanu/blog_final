<?php
session_start();
require_once "includes/functions.php";

// Protection auteur
if (!isset($_SESSION['user']) || $_SESSION['user']['type'] !== 'auteur') {
    header('Location: index.php');
    exit;
}

$error = '';
$success = '';

// Récupération de l'article
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: myArticles.php');
    exit;
}

$id = (int)$_GET['id'];
$article = getArticleById($id);
// ✅ Récupération des catégories existantes de l'article
$articleCategories = getCategoriesByArticle($id);
$selectedCategories = array_column($articleCategories, 'id_categorie');

// Récupération de TOUTES les catégories disponibles
$allCategories = getAllCategories();

// Vérifier que l'article existe
if (!$article) {
    header('Location: myArticles.php?error=notfound');
    exit;
}

// Vérifier que c'est bien l'auteur de l'article
if ($article['auteur'] !== $_SESSION['user']['pseudo']) {
    header('Location: myArticles.php?error=unauthorized');
    exit;
}

if (isset($_POST['submit'])) {
    // Validation des champs obligatoires
    // var_dump($_POST);
    // die;
    if (
        empty($_POST['titre']) ||
        empty($_POST['dateCreation']) ||
        empty($_POST['contenu'])
    ) {
        $error = "Tous les champs sont obligatoires.";
    } else {
        $uploadPath = $article['picture']; // On garde l'ancienne image par défaut
        
        // Si une nouvelle image est uploadée
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
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
                
                // Déplacement du nouveau fichier
                if (move_uploaded_file($image['tmp_name'], $uploadPath)) {
                    // Supprimer l'ancienne image
                    if (file_exists($article['chemin_image'])) {
                        unlink($article['chemin_image']);
                    }
                } else {
                    $error = "Erreur lors de l'upload de l'image.";
                }
            }
        }
        
        // Si pas d'erreur, mise à jour en base
        if (empty($error)) {
            // var_dump($_POST['contenu']);
            // die;   
            $updated = updateArticle(
                $id,
                $_POST['titre'],
                $_POST['contenu'],
                $uploadPath,
                
            );
            updateArticleCategories($id, $_POST['categories']);
            if ($updated) {
                header("Location: singleArticle.php?id=$id&success=updated");
                exit;
            } else {
                $error = "Erreur lors de la modification de l'article.";
            }
             
        }
    }
}

require_once "header.php";
?>

<div class="container mt-5">
    <div class="card shadow-sm border-start border-warning rounded-4" style="max-width: 700px; margin: auto;">
        <div class="card-body">
            <h4 class="card-title text-center mb-4">✏️ Modifier l'Article</h4>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="titre" class="form-label">Titre de l'article *</label>
                    <input type="text" class="form-control" id="titre" name="titre" required maxlength="255" value="<?= htmlspecialchars($_POST['titre'] ?? $article['titre']) ?>">
                </div>

                <!-- Date de création (modifiable) -->
                <div class="mb-3">
                    <label for="dateCreation" class="form-label">
                        Date de création *
                        <small class="text-muted">(Quand avez-vous rédigé cet article ?)</small>
                    </label>
                    <input type="date" class="form-control" id="dateCreation" name="dateCreation" required max="<?= date('Y-m-d') ?>" value="<?= $_POST['dateCreation'] ?? $article['date_creation'] ?>">
                    <small class="form-text text-muted">La date ne peut pas être dans le futur</small>
                </div>

                <!-- Date de parution (non modifiable) -->
                <div class="mb-3">
                    <label for="dateParutionDisplay" class="form-label">
                        Date de parution
                        <small class="text-muted">(Non modifiable)</small>
                    </label>
                    <input type="text" id="dateParutionDisplay" class="form-control" value="<?= date('d/m/Y', strtotime($article['date_parution'])) ?>" disabled>
                    <small class="form-text text-muted">La date de publication reste inchangée</small>
                </div>

                <div class="mb-3">
                    <label for="auteur" class="form-label">Auteur</label>
                    <input type="text" id="auteur" class="form-control" value="<?= htmlspecialchars($_SESSION['user']['pseudo']) ?>" disabled>
                </div>

                <div class="mb-3">
                    <label for="contenu" class="form-label">Contenu de l'article *</label>
                    <textarea class="form-control" id="contenu" name="contenu" rows="10" required><?= htmlspecialchars ($article['contenu']) ?></textarea>
                </div>

                <!-- Image actuelle -->
                <div class="mb-3">
                    <label class="form-label">Image actuelle</label>
                    <div class="mb-2">
                        <img src="<?= htmlspecialchars($article['picture']) ?>" alt="Image actuelle" class="img-fluid">
                    </div>
                </div>

                <!-- Nouvelle image (optionnelle) -->
                <div class="mb-3">
                    <label for="image" class="form-label">
                        Nouvelle image <small class="text-muted">(Optionnel)</small>
                    </label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/jpeg,image/png,image/gif,image/webp">
                    <small class="form-text text-muted">Formats acceptés : JPG, PNG, GIF, WEBP (Max : 5 Mo)</small>
                </div>
                <div class="mb-3">
                    <label class="form-label">Catégories *</label>
                    <div class="border rounded p-3" style="max-height: 300px; overflow-y: auto;">
                        <?php foreach ($allCategories as $categorie): ?>
                            <div class="form-check mb-2">
                                <input 
                                    class="form-check-input" 
                                    type="checkbox" 
                                    name="categories[]" 
                                    value="<?= $categorie['id_categorie'] ?>" 
                                    id="cat_<?= $categorie['id_categorie'] ?>"
                                    <?= in_array($categorie['id_categorie'], $selectedCategories) ? 'checked' : '' ?>
                                >
                                <label class="form-check-label" for="cat_<?= $categorie['id_categorie'] ?>">
                                    <?php if (!empty($categorie['avatar'])): ?>
                                        <img src="<?= htmlspecialchars($categorie['avatar']) ?>" alt="" style="width: 20px; height: 20px; object-fit: cover; border-radius: 3px;">
                                    <?php endif; ?>
                                    <strong><?= htmlspecialchars($categorie['nom_categorie']) ?></strong>
                                </label>
                            </div>
                        <?php endforeach; ?>
                   </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" name="submit" class="btn btn-warning">
                        💾 Enregistrer les modifications
                    </button>
                    <a href="singleArticle.php?id=<?= $id ?>" class="btn btn-outline-secondary">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once "footer.php"; ?>