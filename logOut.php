<?php
session_start();

// Supprime toutes les variables de session
$_SESSION = [];

// Détruit la session
session_destroy();

// Redirige vers la page d'accueil
header('Location: index.php');
exit;
