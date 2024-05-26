<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une Activité</title>
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

/* Styles CSS pour les champs de formulaire */
label {
    font-weight: bold;
}

input[type="text"],
textarea {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

textarea {
    height: 150px;
}

/* Style pour le bouton d'enregistrement */
input[type="submit"] {
    background-color: blue; /* Couleur de fond */
    color: white; /* Couleur du texte */
    padding: 10px 20px; /* Espacement intérieur */
    border-radius: 5px; /* Bord arrondi */
    border: none; /* Pas de bordure */
    cursor: pointer; /* Curseur de type pointeur */
}

input[type="submit"]:hover {
    background-color: orange; /* Couleur de fond au survol */
}

/* Style pour le bouton de retour */
.btn-primary {
    background-color: blue; /* Couleur de fond */
    color: white; /* Couleur du texte */
    padding: 10px 20px; /* Espacement intérieur */
    border-radius: 5px; /* Bord arrondi */
    text-decoration: none; /* Pas de soulignement */
    margin-top: 10px; /* Marge en haut */
    display: inline-block; /* Affichage en ligne */
}

.btn-primary:hover {
    background-color: orange; /* Couleur de fond au survol */
}

    </style>
</head>
<body>

<div class="container">
    <h2>Modifier une Activité</h2>

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
            // Afficher un formulaire pré-rempli avec les détails de l'activité
            echo '<form action="update_activite.php?id=' . $activite_id . '" method="post" enctype="multipart/form-data">';
            echo '<label for="nom">Nom:</label><br>';
            echo '<input type="text" id="nom" name="nom" value="' . $activite['nom'] . '"><br><br>';
            echo '<label for="description">Description:</label><br>';
            echo '<textarea id="description" name="description">' . $activite['description'] . '</textarea><br><br>';
            echo '<label for="lien">Lien:</label><br>';
            echo '<input type="text" id="lien" name="lien" value="' . $activite['lien'] . '"><br><br>';
            echo '<label for="image">Image actuelle:</label><br>';
            echo '<img src="' . $activite['image_path'] . '" alt="Image actuelle de l\'activité" style="max-width: 200px;"><br><br>'; // Affichage de l'image actuelle
            echo '<label for="new_image">Nouvelle image:</label><br>'; // Nouvelle balise pour la nouvelle image
            echo '<input type="file" id="new_image" name="new_image"><br><br>'; // Champ pour la nouvelle image
            echo '<input type="submit" value="Enregistrer les Modifications">';
            echo '</form>';
        } else {
            // Si l'activité n'est pas trouvée, afficher un message d'erreur
            echo '<p>Aucune activité trouvée avec cet identifiant.</p>';
        }
    } else {
        // Si aucun identifiant d'activité n'est passé en paramètre, afficher un message d'erreur
        echo '<p>Aucun identifiant d\'activité fourni.</p>';
    }
    ?>

    <!-- Bouton de retour à la liste des activités -->
    <a href="liste_activites.php" class="btn-primary">Retour à la Liste</a>
</div>

</body>
</html>
