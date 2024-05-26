<?php
require_once '../db_connect.php'; // Inclure le fichier de connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $username = $_POST['username'];
    $password = $_POST['password'];
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phone_number'];
    $dateOfBirth = $_POST['date_of_birth'];

    // Vérifier si l'utilisateur existe déjà
    if (userExists($username)) {
        $error_message = "Ce nom d'utilisateur est déjà utilisé.";
    } else {
        // Créer un nouvel utilisateur
        createUser($username, $password, $firstName, $lastName, $email, $phoneNumber, $dateOfBirth);
        header("Location: ../login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Arial', sans-serif;
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

        .register-container {
            background: rgba(255, 255, 255, 0.1);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            text-align: center;
            color: orangered;
            max-width: 400px;
            width: 100%;
        }

        .register-container h1 {
            margin-bottom: 20px;
            font-size: 24px;
        }

        .register-container input[type="text"],
        .register-container input[type="password"],
        .register-container input[type="email"],
        .register-container input[type="date"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            font-size: 16px;
        }

        .register-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            background: #007bff;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 18px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .register-container input[type="submit"]:hover {
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
    <div class="register-container">
        <h1>Inscription</h1>
        <?php if (isset($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form method="post" onsubmit="return validateDateOfBirth()">
            <input type="text" name="username" placeholder="Nom d'utilisateur" required><br>
            <input type="password" name="password" placeholder="Mot de passe" required><br>
            <input type="text" name="first_name" placeholder="Prénom" required><br>
            <input type="text" name="last_name" placeholder="Nom de famille" required><br>
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="text" name="phone_number" placeholder="Numéro de téléphone" required><br>
            <input type="date" id="date_of_birth" name="date_of_birth" required><br>
            <input type="submit" value="S'inscrire">
            <p>Vous avez déjà un compte? <a href="login.php">Se connecter</a></p>
        </form>
    </div>
    <script>
        function validateDateOfBirth() {
            const dateOfBirth = document.getElementById('date_of_birth').value;
            const today = new Date();
            const birthDate = new Date(dateOfBirth);
            const age = today.getFullYear() - birthDate.getFullYear();
            const monthDifference = today.getMonth() - birthDate.getMonth();
            const dayDifference = today.getDate() - birthDate.getDate();

            // Check if the age is less than 16 or exactly 16 but the month and day are not yet reached
            if (age < 16 || (age === 16 && (monthDifference < 0 || (monthDifference === 0 && dayDifference < 0)))) {
                alert("Vous devez avoir au moins 16 ans pour vous inscrire.");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
