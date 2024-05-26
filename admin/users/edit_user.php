<?php
// Inclure le fichier de connexion à la base de données
require_once '../../db_connect.php';

// Vérifier si l'ID de l'utilisateur est défini dans l'URL

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

    // Traitement du formulaire de modification si le formulaire est soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Récupérer les nouvelles valeurs des champs du formulaire
        $username = $_POST['username'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $phone_number = $_POST['phone_number'];
        $date_of_birth = $_POST['date_of_birth'];
        $role = $_POST['role'];

        // Mettre à jour les détails de l'utilisateur dans la base de données
        $stmt = $pdo->prepare("UPDATE users SET username = ?, first_name = ?, last_name = ?, email = ?, phone_number = ?, date_of_birth = ?, role = ? WHERE id = ?");
        $stmt->execute([$username, $first_name, $last_name, $email, $phone_number, $date_of_birth, $role, $user_id]);

        // Rediriger vers la page de visualisation de l'utilisateur après la modification
        header("Location: liste_utilisateurs.php?id=$user_id");
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
    <title>Modifier Utilisateur</title>
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

/* Style spécifique pour edit_user.php */
form {
    width: 100%;
    max-width: 500px;
    margin: 0 auto;
}

label {
    display: block;
    margin-bottom: 5px;
}

input[type="text"],
input[type="email"],
input[type="date"] {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

input[type="submit"] {
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    padding: 10px 20px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #0056b3;
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
    <br>
    <!-- Bouton de retour -->
    <a href="liste_utilisateurs.php" class="return-button">Retour</a>

    <h1>Modifier Utilisateur</h1><br>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $user_id; ?>" method="post">
    <label for="username">Nom d'utilisateur:</label>
    <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>"><br><br>
    
    <label for="first_name">Prénom:</label>
    <input type="text" id="first_name" name="first_name" value="<?php echo $user['first_name']; ?>"><br><br>
    
    <label for="last_name">Nom:</label>
    <input type="text" id="last_name" name="last_name" value="<?php echo $user['last_name']; ?>"><br><br>
    
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>"><br><br>
    
    <label for="phone_number">Numéro de téléphone:</label>
    <input type="text" id="phone_number" name="phone_number" value="<?php echo $user['phone_number']; ?>"><br><br>
    
    <label for="date_of_birth">Date de naissance:</label>
    <input type="date" id="date_of_birth" name="date_of_birth" value="<?php echo $user['date_of_birth']; ?>"><br><br>
    
    <label for="role">Rôle:</label>
    <select id="role" name="role">
        <option value="Admin" <?php if($user['role'] == 'Admin') echo 'selected'; ?>>Admin</option>
        <option value="User" <?php if($user['role'] == 'User') echo 'selected'; ?>>User</option>
    </select><br><br>
    
    <input type="submit" value="Enregistrer">
</form>

</body>
</html>
