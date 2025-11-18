<?php
session_start();
require_once "includes/functions.php";

$error = null;

if (isset($_POST) && !empty($_POST)) {
    $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'] ?? '';

    if (!$email || empty($password)) {
        $error = "Email invalide ou mot de passe manquant.";
    } else {
        $user = getUserByEmail($email);

        if ($user) {
            if (password_verify($password, $user['password'])) {
                session_regenerate_id(true);

                $_SESSION['user'] = [
                    'id'     => $user['id_user'],
                    'email'  => $user['email'],
                    'pseudo' => $user['pseudo'],
                    'type'   => $user['type_user'],
                    'avatar' => $user['avatar'] ?? null
                ];

                if (!empty($_SESSION['redirect_after_login'])) {
                    $redirect = $_SESSION['redirect_after_login'];
                    unset($_SESSION['redirect_after_login']);
                    header("Location: $redirect");
                    exit;
                }

                header("Location: index.php");
                exit;
            } else {
                $error = "Mot de passe incorrect.";
            }
        } else {
            $error = "Aucun compte trouvé avec cet email.";
        }
    }
}

require_once "header.php";
?>

<div class="container mt-5">
    <div class="card shadow-sm border-start border-primary rounded-4" style="max-width: 500px; margin: auto;">
        <div class="card-body">
            <h5 class="card-title mb-4 text-center">Connexion</h5>

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

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Se connecter</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once "footer.php"; ?>