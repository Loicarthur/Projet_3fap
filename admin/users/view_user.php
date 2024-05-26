<?php
// Inclure le fichier de connexion à la base de données
require_once '../../db_connect.php';

// Vérifier si l'ID de l'utilisateur est défini dans l'URL
if (isset($_GET['id'])) {
    // Récupérer l'ID de l'utilisateur depuis l'URL
    $user_id = $_GET['id'];

    // Récupérer les détails de l'utilisateur depuis la base de données
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifier si l'utilisateur existe dans la base de données
    if (!$user) {
        // Rediriger vers une page d'erreur si l'utilisateur n'est pas trouvé
        header("Location: error.php");
        exit();
    }
} else {
    // Rediriger vers une page d'erreur si l'ID de l'utilisateur n'est pas défini dans l'URL
    header("Location: error.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualiser Utilisateur</title>
    <style>
        /* Style général pour les deux pages */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

h1 {
    color: #333;
}


/* Style spécifique pour view_user.php */
p {
    margin-bottom: 10px;
}

a {
    color: #007bff;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

/* Style pour le bouton de retour */
.return-button {
            display: inline-block;
            padding: 10px 20px;
            margin: 5px;
            background-color: #007bff; /* Bleu */
            color: #fff; /* Texte blanc */
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .return-button:hover {
            background-color: #0056b3; /* Bleu foncé au survol */
        }

    </style>
</head>
<body>
    <!-- Bouton de retour -->
    <a href="liste_utilisateurs.php" class="return-button">Retour</a>
    <h1>Détails de l'utilisateur</h1>
    <p><strong>Nom d'utilisateur:</strong> <?php echo $user['username']; ?></p>
    <p><strong>Prénom:</strong> <?php echo $user['first_name']; ?></p>
    <p><strong>Nom:</strong> <?php echo $user['last_name']; ?></p>
    <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
    <p><strong>Numéro de téléphone:</strong> <?php echo $user['phone_number']; ?></p>
    <p><strong>Date de naissance:</strong> <?php echo $user['date_of_birth']; ?></p>
    <p><a href="edit_user.php?id=<?php echo $user_id; ?>">Modifier</a></p>
</body>
</html>
