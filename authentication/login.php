<?php
require_once '../db_connect.php'; // Inclure le fichier de connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Authentifier l'utilisateur
    $user = authenticateUser($username, $password);
    if ($user) {
        // Démarrer la session et enregistrer l'ID utilisateur
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role']; // Stocker le rôle de l'utilisateur dans la session

        // Rediriger en fonction du rôle de l'utilisateur
        if ($user['role'] == 'Admin') {
            header('Location: ../admin/dashboard.php');
        } else {
            header('Location: ../accueil.php');
        }
        exit();
    } else {
        $error_message = "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #1d1e22 25%, #000000 100%);
            overflow: hidden;
        }

        .stars {
            position: absolute;
            width: 100%;
            height: 100%;
            background: url('https://media.giphy.com/media/3oEjI6SIIHBdRxXI40/giphy.gif') repeat;
            background-size: cover;
            z-index: -1;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.1);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            text-align: center;
            color: orange;
        }

        .login-container h1 {
            margin-bottom: 20px;
            font-size: 24px;
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            font-size: 16px;
        }

        .login-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            background: #007bff;
            border: none;
            border-radius: 5px;
            color: yellow;
            font-size: 18px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .login-container input[type="submit"]:hover {
            background: #0056b3;
        }

        .error-message {
            color: red;
            margin-top: 10px;
        }
        a{
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="stars"></div>
    <div class="login-container">
        <h1>Connexion</h1>
        <?php if (isset($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form method="post">
            <input type="text" name="username" placeholder="Nom d'utilisateur" required><br>
            <input type="password" name="password" placeholder="Mot de passe" required><br>
            <input type="submit" value="Se connecter">
            <p>Pas de compte <a href="register.php">S'inscrire</a></p>
        </form>
    </div>
</body>
</html>
