<?php
require_once '../db_connect.php'; // Inclure le fichier de connexion à la base de données


if (isset($_SESSION['user_id'])) {
    // Récupérer les informations de l'utilisateur depuis la session
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        if (isset($_POST['new_password'])) {
            $newPassword = $_POST['new_password'];
            $hashedPassword = hashPassword($newPassword);
            $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
            $stmt->execute([$hashedPassword, $_SESSION['user_id']]);
            $passwordMessage = "Mot de passe modifié avec succès!";
        }
    } else {
        echo "Utilisateur introuvable.";
        exit;
    }
} else {
    echo "Veuillez vous connecter pour accéder à cette page.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Utilisateur</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #1d1e22 25%, #000000 100%);
            color: #fff;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
        }
        
        .stars {
            position: absolute;
            width: 100%;
            height: 100%;
           
        }

        .profile-container {
            background: rgba(255, 255, 255, 0.1);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            text-align: left;
            color: white;
            max-width: 400px;
            width: 100%;
        }

        .profile-container h1 {
            margin-bottom: 20px;
            font-size: 24px;
        }

        .profile-container p {
            margin: 10px 0;
            font-size: 18px;
        }

        .profile-container input[type="password"],
        .profile-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            font-size: 16px;
        }

        .profile-container input[type="password"] {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        .profile-container input[type="submit"] {
            background: #007bff;
            color: white;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .profile-container input[type="submit"]:hover {
            background: #0056b3;
        }

        .message {
            margin-top: 10px;
            color: lime;
        }

        .error {
            margin-top: 10px;
            color: red;
        }
    </style>
</head>
<body>
    <div class="stars"></div>
    <div class="profile-container">
        <h1>Profil Utilisateur</h1>
        <?php if (isset($user)): ?>
            <p>Nom d'utilisateur: <?php echo htmlspecialchars($user['username']); ?></p>
            <p>Prénom: <?php echo htmlspecialchars($user['first_name']); ?></p>
            <p>Nom de famille: <?php echo htmlspecialchars($user['last_name']); ?></p>
            <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
            <p>Numéro de téléphone: <?php echo htmlspecialchars($user['phone_number']); ?></p>
            <p>Date de naissance: <?php echo htmlspecialchars($user['date_of_birth']); ?></p>

            <!-- Formulaire de modification du mot de passe -->
            <form method="post">
                <input type="password" name="new_password" placeholder="Nouveau mot de passe" required><br>
                <input type="submit" value="Modifier le mot de passe">
            </form>

            <?php if (isset($passwordMessage)): ?>
                <div class="message"><?php echo $passwordMessage; ?></div>
            <?php endif; ?>
        <?php else: ?>
            <div class="error">Utilisateur introuvable.</div>
        <?php endif; ?>
    </div>
</body>
</html>
