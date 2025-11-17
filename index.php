<?php
session_start();
require_once "function.php";
require_once "header.php";
?>

<div class="container mt-5 mb-5">
    <h3 class="text-center mb-5">Les 10 derniers articles</h3>

    <?php
    $posts = getLastPosts(10);
    
    if (empty($posts)): ?>
        <div class="alert alert-info text-center">
            Aucun article disponible pour le moment.
        </div>
    <?php else:
        $chunked_posts = array_chunk($posts, 3);
    ?>
        <!-- ✅ Wrapper avec position relative pour positionner les boutons -->
        <div class="position-relative carousel-wrapper">
            <div id="carouselCards" class="carousel slide" data-bs-ride="carousel">
                
                <div class="carousel-indicators">
                    <?php foreach ($chunked_posts as $index => $chunk): ?>
                        <button type="button" data-bs-target="#carouselCards" data-bs-slide-to="<?= $index ?>" 
                                class="<?= $index === 0 ? 'active' : '' ?>"></button>
                    <?php endforeach; ?>
                </div>

                <div class="carousel-inner pb-5">
                    <?php foreach ($chunked_posts as $chunk_index => $chunk): ?>
                        <article class="carousel-item <?= $chunk_index === 0 ? 'active' : '' ?>">
                            <!-- ✅ Cartes centrées avec justify-content-center et max-width -->
                            <div class="row g-4 justify-content-center mx-auto" style="max-width: 1200px;">
                                <?php foreach ($chunk as $post): ?>
                                    <div class="col-md-4">
                                        <div class="card article-card shadow-lg border-0">
                                            <div class="card-img-container">
                                                <?php if (!empty($post['picture'])): ?>
                                                    <img src="<?= htmlspecialchars($post['picture']) ?>" 
                                                         class="card-img-top article-img" 
                                                         alt="<?= htmlspecialchars($post['titre']) ?>">
                                                <?php else: ?>
                                                    <div class="bg-gradient bg-secondary article-img d-flex align-items-center justify-content-center">
                                                        <i class="bi bi-image text-white" style="font-size: 3rem;"></i>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <div class="card-body d-flex flex-column">
                                                <span class="badge bg-primary mb-2 align-self-start">Article</span>
                                                <h5 class="card-title fw-bold mb-3"><?= htmlspecialchars($post['titre']) ?></h5>
                                                <p class="card-text text-muted flex-grow-1">
                                                    <?= htmlspecialchars(substr($post['contenu'], 0, 120)) ?>...
                                                </p>
                                                
                                                <hr class="my-3">
                                                
                                                <div class="d-flex align-items-center gap-2 mb-3">
                                                    <?php if (!empty($post['auteur_avatar'])): ?>
                                                        <img src="<?= htmlspecialchars($post['auteur_avatar']) ?>" 
                                                             alt="Avatar" 
                                                             class="rounded-circle author-avatar">
                                                    <?php else: ?>
                                                        <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center author-avatar-placeholder">
                                                            <i class="bi bi-person text-white"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                    
                                                    <div class="flex-grow-1">
                                                        <div class="fw-bold small"><?= htmlspecialchars($post['auteur']) ?></div>
                                                        <small class="text-muted">
                                                            <i class="bi bi-calendar-event"></i> 
                                                            <?= htmlspecialchars($post['date_creation']) ?>
                                                        </small>
                                                    </div>
                                                </div>
                                                
                                                <a href="singleArticle.php?id=<?= $post['id_article'] ?>" class="btn btn-primary w-100">
                                                    Lire la suite <i class="bi bi-arrow-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- ✅ Boutons écartés avec classe custom-carousel-btn -->
            <button class="carousel-control-prev custom-carousel-btn" 
                    type="button" 
                    data-bs-target="#carouselCards" 
                    data-bs-slide="prev">
                <span class="carousel-btn-icon">
                    <i class="bi bi-chevron-left text-white fs-3"></i>
                </span>
                <span class="visually-hidden">Précédent</span>
            </button>
        
            <button class="carousel-control-next custom-carousel-btn" 
                    type="button" 
                    data-bs-target="#carouselCards" 
                    data-bs-slide="next">
                <span class="carousel-btn-icon">
                    <i class="bi bi-chevron-right text-white fs-3"></i>
                </span>
                <span class="visually-hidden">Suivant</span>
            </button>
        </div>
    <?php endif; ?>
</div>

<?php require_once "footer.php"; ?>