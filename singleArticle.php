<?php
session_start();
require_once "function.php";
require_once "header.php";

// Vérifier si un ID est passé
if (!isset($_GET['id'])) {
    echo "<div class='alert alert-danger text-center'>Article introuvable.</div>";
    exit;
}

$id = (int) $_GET['id'];
$post = getArticleById($id); 
?>
<div class="container mt-5 mb-5">
    <?php if (!$post): ?>
        <div class="alert alert-warning text-center">
            Cet article n'existe pas.
        </div>
    <?php else: ?>
        <h2 class="fw-bold mb-4"><?= htmlspecialchars($post['titre']) ?></h2>

        <?php if (!empty($post['picture'])): ?>
            <img src="<?= htmlspecialchars($post['picture']) ?>" 
                 class="img-fluid mb-4" 
                 alt="<?= htmlspecialchars($post['titre']) ?>">
        <?php endif; ?>

        <p class="text-muted">
            <i class="bi bi-person"></i> <?= htmlspecialchars($post['auteur']) ?> |
            <i class="bi bi-calendar-event"></i> <?= htmlspecialchars($post['date_creation']) ?>
        </p>

        <hr>

        <div class="article-content">
            <?= nl2br(htmlspecialchars($post['contenu'])) ?>
        </div>
        <!-- Bouton pour ouvrir la modale -->
        <button class="btn rounded-pill btn-primary mt-3" id="openModal" data-bs-toggle="modal" data-bs-target="#commentModal">Écrire un commentaire</button>
    <?php endif; ?>
</div>

<!-- Modale -->
<div id="commentModal" class="modal fade" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="height: 85vh; overflow-y: auto;">
      
            <!-- Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="commentModalLabel">Votre commentaire</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
      
            <!-- Body -->
            <div class="modal-body">
                <form id="commentForm" method="post" action="addComment.php" class="w-100">
                    <input type="hidden" name="id_article" value="<?= $id ?>">
                    
                    <!-- Champ Pseudo -->
                    <div class="mb-3">
                        <label for="pseudo" class="form-label">Pseudo <span class="text-danger">*</span></label>
                        <?php if (isset($_SESSION['id_user']) && isset($_SESSION['pseudo'])): ?>
                            <!-- Membre connecté -->
                            <input type="text" class="form-control" id="pseudo" name="pseudo" value="<?= htmlspecialchars($_SESSION['pseudo']) ?>" readonly>
                            <small class="text-muted">
                                <i class="bi bi-person-check"></i> Vous êtes connecté en tant que membre
                            </small>
                            <input type="hidden" name="id_user" value="<?= $_SESSION['id_user'] ?>">
                        <?php else: ?>
                            <!-- Visiteur -->
                            <input type="text" class="form-control" id="pseudo" name="pseudo" placeholder="Entrez votre pseudo" required minlength="3" maxlength="50">
                            <small class="text-muted">Entre 3 et 50 caractères</small>
                        <?php endif; ?>
                    </div>
                    <!-- Champ Commentaire -->
                    <div class="mb-3">
                        <label for="commentaire" class="form-label">Commentaire <span class="text-danger">*</span></label>
                        <textarea name="commentaire" id="commentaire" rows="5" class="form-control" placeholder="Écrivez votre commentaire..." required maxlength="1000"></textarea>
                        <small class="text-muted">Maximum 1000 caractères</small>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-send"></i> Envoyer le commentaire
                        </button>
                    </div>
                </form>
            </div>
      
        </div>
    </div>
</div>

<?php require_once "footer.php"; ?>