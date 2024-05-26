<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer une Activité</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container">
    <h2>Supprimer une Activité</h2>

    <?php
    // Inclure le fichier de connexion à la base de données
    require_once '../../db_connect.php';

    // Vérifier si l'identifiant de l'activité est passé en paramètre dans l'URL
    if(isset($_GET['id'])) {
        // Récupérer l'identifiant de l'activité depuis l'URL
        $activite_id = $_GET['id'];

        // Afficher un formulaire pour la confirmation de suppression
        echo '<form method="post" id="deleteForm">';
        echo '<p>Êtes-vous sûr de vouloir supprimer cette activité ?</p>';
        echo '<input type="hidden" name="activite_id" value="' . $activite_id . '">';
        echo '<button type="submit" name="submit">Supprimer</button>';
        echo '</form>';
        
        // Si le formulaire est soumis, supprimer l'activité
        if(isset($_POST['submit'])) {
            $activite_id = $_POST['activite_id'];
            $sql = "DELETE FROM activites WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $activite_id, PDO::PARAM_INT);
            if($stmt->execute()) {
                echo '<script>alert("L\'activité a été supprimée avec succès.");</script>';
            } else {
                echo '<script>alert("Une erreur s\'est produite lors de la suppression de l\'activité.");</script>';
            }
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
