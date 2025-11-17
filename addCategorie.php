<?php
session_start();
require_once "function.php";

if (isset($_POST['submit_categorie'])) {
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $couleur = $_POST['couleur'];

    // Gestion de l’upload
    $avatar = $_FILES['avatar']['name'];
    $tmp = $_FILES['avatar']['tmp_name'];
    $destination = 'uploads/categories/' . $avatar;
    move_uploaded_file($tmp, $destination);

    if (addCategorie($nom, $description, $avatar, $couleur)) {
        $success = "Catégorie ajoutée avec succès !";
    } else {
        $error = "Erreur lors de l’ajout.";
    }
}

require_once "header.php";
?>

<div class="container mt-5">
    <div class="card shadow-sm border-start border-success rounded-4" style="max-width: 700px; margin: auto;">
        <div class="card-body">
            <h4 class="card-title text-center mb-4">📁 Ajouter une Catégorie</h4>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
                <div class="alert alert-success text-center"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom de la catégorie *</label>
                    <input type="text" class="form-control" name="nom" id="nom" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" name="description" id="description" rows="3"></textarea>
                </div>

                <div class="mb-3">
                   <label for="avatar" class="form-label">Image d’illustration *</label>
                    <input type="file" class="form-control" name="avatar" id="avatar" accept="image/*" required>
                </div>

                <div class="mb-3">
                    <label for="couleur" class="form-label">Couleur (code hex ou Bootstrap)</label>
                    <input type="text" class="form-control" name="couleur" id="couleur" placeholder="#ff6600 ou bg-primary">
                </div>

                <div class="d-grid">
                    <button type="submit" name="submit_categorie" class="btn btn-success">➕ Ajouter la catégorie</button>
                </div>
            </form>
        </div>
    </div>
</div>


