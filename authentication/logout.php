<?php
// Démarre la session
session_start();

// Détruit toutes les données de session
$_SESSION = array();

// Si l'utilisateur est connecté via un cookie de session, détruit également le cookie de session
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Détruit la session
session_destroy();

// Redirige vers la page de connexion
header("location: ../accueil.php");
exit;
?>
