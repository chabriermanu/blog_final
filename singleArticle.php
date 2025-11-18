<?php
session_start();
require_once "includes/functions.php";

// Récupérer l'article
$id_article = (int)($_GET['id'] ?? 0);

if ($id_article <= 0) {
    header('Location: index.php');
    exit;
}

$article = getArticleById($id_article);
if (!$article) {
    header('Location: index.php?error=notfound');
    exit;
}

// Récupérer les commentaires
$commentaires = getCommentairesByArticle($id_article);
$categories = getCategoriesByArticle($id_article);
require_once "header.php";
?>

<div class="container mt-5">
    
    <!-- Article complet -->
    <article class="mb-5">
        <h1 class="mb-3 text-center"><?= htmlspecialchars($article['titre']) ?></h1>
        
        <div class="d-flex align-items-center gap-3 mb-4 text-muted">
            <div class="d-flex align-items-center gap-2">
                <?php if (!empty($article['auteur_avatar'])): ?>
                    <img src="<?= htmlspecialchars($article['auteur_avatar']) ?>" 
                         class="rounded-circle" 
                         style="width: 40px; height: 40px; object-fit: contain;">
                <?php else: ?>
                    <i class="bi bi-person-circle fs-4"></i>
                <?php endif; ?>
                <span><?= htmlspecialchars($article['auteur']) ?></span>
            </div>
            
            <span>•</span>
            
            <div>
                <i class="bi bi-calendar-event"></i>
                <!-- ?=  ouverture hp + echo -->
                <?= htmlspecialchars($article['date_creation']) ?>
            </div>
        </div>
        
        <?php if (!empty($article['picture'])): ?>
            <img src="<?= htmlspecialchars($article['picture']) ?>" 
                 class="img-fluid rounded mb-4 w-100" 
                 style="max-height: 500px; object-fit: contain;"
                 alt="<?= htmlspecialchars($article['titre']) ?>">
        <?php endif; ?>
        
        <div class="article-content">
            <?= nl2br(htmlspecialchars($article['contenu'])) ?>
        </div>
    </article>

 <!-- ✅ Affichage des catégories -->
<?php if (!empty($categories)): ?>
<div class="mb-2">
    <?php foreach ($categories as $categorie): ?>
        <a href="categorie.php?id=<?= $categorie['id_categorie'] ?>" 
           class="badge" 
           style="background-color: <?= htmlspecialchars($categorie['couleur']) ?>; color: white; text-decoration: none;">
            <?= htmlspecialchars($categorie['nom_categorie']) ?>
        </a>
    <?php endforeach; ?>
</div>
<?php endif; ?>
 
     
<!-- Boutons d'action pour l'auteur -->
<?php if (isset($_SESSION['user']) && 
          $_SESSION['user']['type'] === 'auteur' && 
          $_SESSION['user']['id'] === $article['id_user']): ?>
    <div class="d-flex gap-2 mb-4">
        <a href="updateArticle.php?id=<?= $article['id'] ?>" class="btn btn-warning">
            <i class="bi bi-pencil"></i> Modifier
        </a>
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalDeleteArticle">
            <i class="bi bi-trash"></i> Supprimer
        </button>
    </div>
<?php endif; ?>
    <hr>

  <!-- Bouton pour ouvrir la modal -->
<div class="text-center mt-4 mb-5">
    <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#modalCommentaire">
        <i class="bi bi-chat-dots"></i> Laisser un commentaire
    </button>
</div>

<!-- Modal Commentaire -->
<div id="modalCommentaire" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 100%; height: auto; overflow-y: auto; margin: auto;">
            <div class="w-100 position-relative text-center p-3">
                <button type="button" class="modal-close" data-bs-dismiss="modal">✌</button>
                <h3 style="color:#1E90FF">Laisser un commentaire</h3>
            </div>
            
            <div class="modal-body">
                <?php if (isset($_GET['success']) && $_GET['success'] === 'comment'): ?>
                    <div class="alert alert-success">
                        Votre commentaire a été envoyé avec succès !
                    </div>
                <?php endif; ?>
                
                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger">
                        <?php if ($_GET['error'] === 'empty'): ?>
                            Le commentaire ne peut pas être vide.
                        <?php elseif ($_GET['error'] === 'pseudo'): ?>
                            Veuillez renseigner votre pseudo.
                        <?php else: ?>
                            Une erreur s'est produite.
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                
                <form method="post" action="addCommentaire.php">
                    <input type="hidden" name="id_article" value="<?= $article['id'] ?>">
                    
                    <?php if (!isset($_SESSION['user'])): ?>
                        <div class="mb-3">
                            <label for="pseudo_visiteur" class="form-label">Votre pseudo *</label>
                            <input type="text" class="form-control" id="pseudo_visiteur" name="pseudo_visiteur" maxlength="50" required>
                            <small class="text-muted">
                                Vous n'êtes pas inscrit ? <a href="signup.php">Créer un compte</a>
                            </small>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">
                            Commentaire en tant que <strong><?= htmlspecialchars($_SESSION['user']['pseudo']) ?></strong>
                        </div>
                    <?php endif; ?>
                    
                    <div class="mb-3">
                        <label for="contenu" class="form-label">Votre commentaire *</label>
                        <textarea class="form-control" id="contenu" name="contenu" rows="6" maxlength="1000" required placeholder="Partagez votre avis..."></textarea>
                        <small class="text-muted">Maximum 1000 caractères</small>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send"></i> Publier le commentaire
                        </button>
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Annuler
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
 </div>
 <!-- Modal Suppression Article -->
<div id="modalDeleteArticle" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle"></i> Confirmer la suppression
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer cet article ?</p>
                <p class="text-danger"><strong>Cette action est irréversible !</strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form method="POST" action="deleteArticle.php" style="display: inline;">
                    <input type="hidden" name="id" value="<?= $article['id'] ?>">
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash"></i> Supprimer définitivement
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>    
    <!-- Affichage des commentaires -->
    <?php if (!empty($commentaires)): ?>
        <div class="mt-5 mb-5">
            <h4 class="mb-4">
                <i class="bi bi-chat-dots"></i> 
                <?= count($commentaires) ?> Commentaire<?= count($commentaires) > 1 ? 's' : '' ?>
            </h4>
            
            <?php foreach ($commentaires as $comment): ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <?php if ($comment['type_auteur'] === 'membre' && !empty($comment['avatar'])): ?>
                                <img src="<?= htmlspecialchars($comment['avatar']) ?>" 
                                     class="rounded-circle" 
                                     style="width: 40px; height: 40px; object-fit: cover;">
                            <?php else: ?>
                                <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center" 
                                     style="width: 40px; height: 40px;">
                                    <i class="bi bi-person text-white"></i>
                                </div>
                            <?php endif; ?>
                            
                            <div>
                                <strong><?= htmlspecialchars($comment['auteur_commentaire']) ?></strong>
                                <?php if ($comment['type_auteur'] === 'visiteur'): ?>
                                    <span class="badge bg-secondary ms-2">Visiteur</span>
                                <?php endif; ?>
                                <br>
                                <small class="text-muted">
                                    <i class="bi bi-clock"></i> 
                                    <?= date('d/m/Y à H:i', strtotime($comment['date_commentaire'])) ?>
                                </small>
                            </div>
                        </div>
                        <p class="mb-0"><?= nl2br(htmlspecialchars($comment['contenu'])) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info mt-5 mb-5">
            Aucun commentaire pour le moment. Soyez le premier à commenter !
        </div>
    <?php endif; ?>
</div>



<?php require_once "footer.php";?>