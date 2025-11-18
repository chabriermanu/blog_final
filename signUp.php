<?php
session_start();
require_once "includes/functions.php";

$error = null;

if (isset($_POST) && !empty($_POST)) {
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'] ?? '';
    $pseudo = htmlspecialchars(trim($_POST['pseudo'] ?? '')); // ✅ AJOUTÉ
    $type_user = $_POST['type_user'] ?? '';

    // Validation
    if (!$email) {
        $error = "Email invalide.";
    } elseif (empty($password)) {
        $error = "Mot de passe requis.";
    } elseif (empty($pseudo)) {
        $error = "Pseudo requis.";
    } elseif (!in_array($type_user, ['membre', 'auteur'])) {
        $error = "Type d'utilisateur invalide.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        
        // ✅ Passe le pseudo à la fonction
        if (signUp($email, $hashed_password, $pseudo, $type_user)) {
            header('Location: login.php?success=1');
            exit;
        } else {
            $error = "Erreur lors de l'inscription. L'email existe peut-être déjà.";
        }
    }
}

require_once "header.php";
?>

<div class="container mt-5">
    <div class="card shadow-sm border-start border-primary rounded-4" style="max-width: 500px; margin: auto;">
        <div class="card-body">
            <h5 class="card-title mb-4 text-center">Inscription</h5>

            <?php if ($error): ?>
                <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form action="" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>

                <div class="mb-3">
                    <label for="inputPassword" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" id="inputPassword" name="password" required>
                </div>

                <div class="mb-3">
                    <label for="pseudo" class="form-label">Pseudo</label>
                    <input type="text" class="form-control" id="pseudo" name="pseudo" maxlength="25" required>
                </div>

                <div class="mb-3">
                    <label for="type_user" class="form-label">Type d'utilisateur</label>
                    <select class="form-select" id="type_user" name="type_user" required>
                        <option value="membre">Membre</option>
                        <option value="auteur">Auteur</option>
                    </select>
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary">S'inscrire</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once "footer.php"; ?>