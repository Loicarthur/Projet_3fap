<?php
// Inclure le fichier de connexion à la base de données
require_once '../../db_connect.php';

// Vérifier si l'ID de l'utilisateur est défini dans l'URL
if (isset($_GET['id'])) {
    // Récupérer l'ID de l'utilisateur depuis l'URL
    $user_id = $_GET['id'];
    
    // Mettre à jour le statut de l'utilisateur à "active" dans la base de données
    $stmt = $pdo->prepare("UPDATE users SET active = 1 WHERE id = ?");
    $stmt->execute([$user_id]);

    // Rediriger vers la page d'affichage des utilisateurs après l'activation
    header("Location: liste_utilisateurs.php");
    exit();
} else {
    // Rediriger vers une page d'erreur si l'ID de l'utilisateur n'est pas défini dans l'URL
    header("Location: error.php");
    exit();
}
?>
