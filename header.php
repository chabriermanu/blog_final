<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon blog</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Navbar globale -->
    <nav class="navbar fixed-top bg-body-tertiary">
        <div class="container-fluid justify-content-end">
            
            <?php if (isset($_SESSION['user'])): ?>
                <!-- Utilisateur connecté -->
                
                <?php if ($_SESSION['user']['type'] === 'auteur'): ?>
                    <a href="myArticles.php" class="btn rounded-pill btn-sm btn-outline-secondary">
                        Mes articles
                    </a>
                    <a href="addArticle.php" class="btn rounded-pill btn-sm btn-outline-success">
                        <i class="bi bi-plus-circle"></i> Créer
                    </a>
                <?php endif; ?>
                
                <span class="text-muted me-2">
                    <i class="bi bi-person-circle"></i> <?= htmlspecialchars($_SESSION['user']['pseudo']) ?>
                </span>
                
                <a href="logOut.php" class="btn rounded-pill btn-sm btn-outline-danger">
                    Se déconnecter
                </a>
                
            <?php else: ?>
                <!-- Visiteur non connecté -->
                <a href="logIn.php" class="btn rounded-pill btn-sm btn-outline-primary">
                    Se connecter
                </a>
                <a href="signUp.php" class="btn rounded-pill btn-sm btn-outline-success">
                    Créer un compte
                </a>
            <?php endif; ?>
            
        </div>
    </nav>
    <div class="container-fluid text-center mt-5">
        <h1>Bienvenue sur mon blog</h1>
    </div>

