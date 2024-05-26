<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voir une Activité</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Styles CSS pour la mise en page */
body {
    font-family: Arial, sans-serif;
    line-height: 1.6;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 800px;
    margin: auto;
    padding: 20px;
}

/* Style pour les boutons */
.btn-primary {
    background-color: blue; /* Couleur de fond */
    color: white; /* Couleur du texte */
    padding: 10px 20px; /* Espacement intérieur */
    border-radius: 5px; /* Bord arrondi */
    text-decoration: none; /* Pas de soulignement */
    margin-right: 10px; /* Marge à droite */
}

.btn-primary:hover {
    background-color: orange; /* Couleur de fond au survol */
}

    </style>
</head>
<body>

<div class="container">
    <h1>Détails de l'Activité</h1>

    <?php
    // Inclure le fichier de connexion à la base de données
    require_once '../../db_connect.php';

    // Vérifier si l'identifiant de l'activité est passé en paramètre dans l'URL
    if(isset($_GET['id'])) {
        // Récupérer l'identifiant de l'activité depuis l'URL
        $activite_id = $_GET['id'];

        // Requête SQL pour récupérer les détails de l'activité
        $sql = "SELECT * FROM activites WHERE id = :id";

        // Préparation de la requête
        $stmt = $pdo->prepare($sql);

        // Liaison de la valeur de l'identifiant de l'activité
        $stmt->bindParam(':id', $activite_id, PDO::PARAM_INT);

        // Exécution de la requête
        $stmt->execute();

        // Récupération des résultats de la requête
        $activite = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifier si l'activité existe dans la base de données
        if($activite) {
            // Afficher les détails de l'activité
            echo '<p><strong>Nom:</strong> ' . $activite['nom'] . '</p>';
            echo '<p><strong>Description:</strong> ' . $activite['description'] . '</p>';
            echo '<p><strong>Lien:</strong> ' . $activite['lien'] . '</p>';
            echo '<p><strong>Image:</strong> <img src="' . $activite['image_path'] . '" alt="Image de l\'activité"></p>';
            echo '<p><strong>Créé le:</strong> ' . $activite['created_at'] . '</p>';
        } else {
            // Si l'activité n'est pas trouvée, afficher un message d'erreur
            echo '<p>Aucune activité trouvée avec cet identifiant.</p>';
        }
    } else {
        // Si aucun identifiant d'activité n'est passé en paramètre, afficher un message d'erreur
        echo '<p>Aucun identifiant d\'activité fourni.</p>';
    }
    ?>

    <!-- Boutons pour Modifier et Supprimer l'activité -->
    <a href="edit_activite.php?id=<?php echo $activite_id; ?>" class="btn-primary">Modifier</a>
    <a href="delete_activite.php?id=<?php echo $activite_id; ?>" class="btn-primary">Supprimer</a>
    <a href="liste_activites.php" class="btn-primary">Retour à la Liste</a>
</div>

</body>
</html>
