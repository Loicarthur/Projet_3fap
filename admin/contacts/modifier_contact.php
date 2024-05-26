<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le contact</title>
    <link rel="stylesheet" href="styles.css"> <!-- Assurez-vous d'ajuster le chemin si nécessaire -->
</head>

<body>
    <style>
        /* Styles généraux */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

.container {
    width: 80%;
    margin: auto;
    padding: 20px;
}

h2 {
    text-align: center;
}

/* Styles du formulaire */
.form-group {
    margin-bottom: 20px;
}

label {
    display: block;
    font-weight: bold;
}

input[type="text"],
input[type="email"],
textarea {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

textarea {
    height: 100px;
}

button[type="submit"] {
    background-color: #007bff;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

button[type="submit"]:hover {
    background-color: #0056b3;
}

/* Responsive */
@media (max-width: 768px) {
    .container {
        width: 90%;
    }
}

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

      <!-- Bouton de retour -->
      <a href="afficher_contacts.php" class="return-button">Retour</a><br>

    <div class="container">
        <?php
        // Inclure le fichier de connexion à la base de données
        require_once '../../db_connect.php';

        // Vérifier si l'ID du contact est passé en paramètre
        if (isset($_GET['id'])) {
            $contactId = $_GET['id'];

            // Vérifier si le formulaire a été soumis
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Vérifier si tous les champs requis sont remplis
                if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message'])) {
                    $name = $_POST['name'];
                    $email = $_POST['email'];
                    $message = $_POST['message'];

                    try {
                        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        // Requête pour mettre à jour le contact
                        $stmt = $conn->prepare("UPDATE contact_requests SET name = :name, email = :email, message = :message WHERE id = :id");
                        $stmt->bindParam(':name', $name);
                        $stmt->bindParam(':email', $email);
                        $stmt->bindParam(':message', $message);
                        $stmt->bindParam(':id', $contactId);
                        $stmt->execute();

                        echo "Le contact a été mis à jour avec succès.";
                    } catch (PDOException $e) {
                        echo "Erreur lors de la mise à jour du contact : " . $e->getMessage();
                    }
                } else {
                    echo "Tous les champs requis ne sont pas remplis.";
                }
            }

            // Affichage du formulaire pré-rempli avec les informations du contact à modifier
            try {
                $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Requête pour récupérer les détails du contact à modifier
                $stmt = $conn->prepare("SELECT name, email, message FROM contact_requests WHERE id = :id");
                $stmt->bindParam(':id', $contactId);
                $stmt->execute();
                $contact = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($contact) {
                    // Afficher le formulaire pré-rempli
        ?>
        <h2>Modifier le contact</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="name">Nom</label>
                <input type="text" id="name" name="name" value="<?php echo $contact['name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo $contact['email']; ?>" required>
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea id="message" name="message" rows="4" required><?php echo $contact['message']; ?></textarea>
            </div>
            <button type="submit">Modifier le contact</button>
        </form>
        <?php
                } else {
                    echo "Aucun contact trouvé avec cet identifiant.";
                }
            } catch (PDOException $e) {
                echo "Erreur lors de la récupération des détails du contact : " . $e->getMessage();
            }
        } else {
            echo "Aucun identifiant de contact fourni.";
        }
        ?>
    </div>
</body>
</html>
