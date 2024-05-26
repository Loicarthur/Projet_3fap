<?php
require_once '../../db_connect.php'; // Inclure le fichier de connexion à la base de données

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $lien = $_POST['lien'];

    // Traitement de l'image téléversée
    $targetDirectory = "uploads/";
    $targetFile = $targetDirectory . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    
    // Vérifier si le fichier est une image réelle
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check === false) {
        echo "Le fichier n'est pas une image valide.";
        $uploadOk = 0;
    }
    
    // Vérifier la taille du fichier
    if ($_FILES["image"]["size"] > 500000) {
        echo "Désolé, votre fichier est trop volumineux.";
        $uploadOk = 0;
    }
    
    // Autoriser certains formats de fichier
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif") {
        echo "Désolé, seuls les fichiers JPG, JPEG, PNG & GIF sont autorisés.";
        $uploadOk = 0;
    }
    
    // Vérifier si $uploadOk est défini sur 0 par une erreur
    if ($uploadOk == 0) {
        echo "Désolé, votre fichier n'a pas été téléversé.";
    // Si tout est correct, essayez de téléverser le fichier
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            // Le fichier a été téléversé avec succès
            // Insérer les données dans la base de données
            $stmt = $pdo->prepare("INSERT INTO activites (nom, image_path, description, lien) VALUES (?, ?, ?, ?)");
            $stmt->execute([$nom, $targetFile, $description, $lien]);
            header("Location: liste_activites.php");
        } else {
            echo "Désolé, une erreur s'est produite lors du téléversement de votre fichier.";
        }
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>
    

    <form action="#" method="post" enctype="multipart/form-data">
        <label for="nom">Nom :</label><br>
        <input type="text" id="nom" name="nom" required><br><br>

        <label for="image">Image :</label><br>
        <input type="file" id="image" name="image" accept="image/*" required><br><br>

        <label for="description">Description :</label><br>
        <textarea id="description" name="description" required></textarea><br><br>

        <label for="lien">Lien :</label><br>
        <input type="text" id="lien" name="lien" required><br><br>

        <input type="submit" value="Ajouter l'activité">
    </form>


</body>
</html>