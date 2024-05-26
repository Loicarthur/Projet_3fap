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


        .image-container {
            width: 100px; /* Ajustez la taille du conteneur d'image selon vos besoins */
        }
        .image-container img {
            width: 100%; /* Ajustez la taille de l'image selon vos besoins */
        }

        /* Style pour le titre du header */
        .navbar-brand {
            font-weight: bold;
            color: #fff; /* Couleur du texte */
        }

        /* Style pour la barre de navigation latérale */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 200px; /* Largeur de la barre latérale */
            height: 100%;
            background-color: #007bff; /* Couleur bleue pour la barre latérale */
            padding-top: 50px; /* Espace pour le logo et le titre */
        }

        /* Style pour les liens de navigation dans la barre latérale */
        .nav-link {
            color: #fff; /* Couleur des liens de navigation */
        }

        /* Style pour les liens de navigation actifs dans la barre latérale */
        .nav-link.active {
            font-weight: bold; /* Texte en gras pour les liens actifs */
        }

        /* Style pour le contenu principal */
        .main-content {
            margin-left: 170px; /* Marge à gauche pour laisser de la place à la barre latérale */
            padding: 10px;
        }

        /* Styles généraux */
        body {
            font-family: Arial, sans-serif;
            margin: 10px;
            padding: 10px;
        }

        .container {
            width: 70%; /* Largeur réduite à 70% */
            margin: auto;
            padding: 20px;
        }

        h2 {
            text-align: center;
        }

        .menu {
            position: fixed;
            display: flex;
            top: 0; /* Aligner le menu en haut */
    right: 20px; /* Ajuster la distance depuis le bord droit */
            justify-content: flex-end;
            align-items: center;
            margin-bottom: 40px;
            background-color: #007bff;
            height: 40px;
            padding: 0;
        }

        .menu-item {
            padding: 10px 20px;
            background-color: #007bff; /* Couleur bleue par défaut */
            color: #fff; /* Texte blanc par défaut */
            border-radius: 5px;
            text-decoration: none;
        }

        .menu-item:hover {
            background-color: #0056b3; /* Couleur bleue plus foncée au survol */
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); /* Répéter les colonnes avec une largeur minimale de 250px */
            grid-gap: 20px; /* Espacement entre les boîtes */
            margin-top: 20px;
        }

        .stat-item {
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            
        }

         /* Styles spécifiques pour chaque boîte */
         .stat-item:nth-child(1) {
            background: linear-gradient(to bottom right, #ff9f9f, #c22f2f); /* Rouge dégradé par défaut */
        }

        .stat-item:nth-child(2) {
            background: linear-gradient(to bottom right, #9f9fff, #4848f1); /* Bleu dégradé par défaut */
        }

        .stat-item:nth-child(3) {
            background: linear-gradient(to bottom right, #9fff9f, #41e741); /* Vert dégradé par défaut */
        }

        .stat-item:nth-child(4) {
            background: linear-gradient(to bottom right, #ffff9f, #eeee33); /* Jaune dégradé par défaut */
        }

        .stat-item:nth-child(5) {
            background: linear-gradient(to bottom right, #ff9fff, #d11ed1); /* Rose dégradé par défaut */
        }

        .stat-item:nth-child(6) {
            background: linear-gradient(to bottom right, #9fffff, #22cccc); /* Cyan dégradé par défaut */
        }

        .stat-item:nth-child(7) {
            background: linear-gradient(to bottom right, #ffbf5f, #ff8833); /* Orange dégradé par défaut */
        }

        .stat-item:nth-child(8) {
            background: linear-gradient(to bottom right, #bf9fff, #8a4bff); /* Violet dégradé par défaut */
        }

        .custom-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff; /* Couleur bleue par défaut */
            color: #fff; /* Texte blanc par défaut */
            border-radius: 5px;
            text-decoration: none;
        }

        .custom-button:hover {
            background-color: #0056b3; /* Couleur bleue plus foncée au survol */
        }

        /* Ajustement du contenu par rapport à la barre de menu latérale */
        .main-content {
            margin-left: 250px; /* Marge à gauche égale à la largeur de la barre latérale */
            padding: 20px;
        }

        /* Ajustement de la taille du graphique */
        #myChart {
            max-width: 800px; /* Largeur maximale du graphique */
            margin-left: 20%; /* Centrer le graphique */
        }

        .user-dropdown img {
            width: 40px; /* Taille réduite */
            height: 40px; /* Taille réduite */
            border-radius: 50%;
            margin-right: 5px; /* Espacement réduit */
        }


        .user-dropdown-content {
            display: none;
            position: absolute;
            background-color: #bf9fff;
            min-width: 110px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 0.5;
            
        }

        .user-dropdown:hover .user-dropdown-content {
            display: block;
        }

        .user-dropdown-content a {
            color: black;
            padding: 10px 10px;
            text-decoration: none;
            display: block;
        }

        .user-dropdown-content a:hover {
            background-color: #ddd;
        }
        .site-button {
            position: fixed;
            top: 10px;
            left: 16%;
            z-index: 1000; /* Pour s'assurer que le bouton est au-dessus du contenu */
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
<div class="sidebar">
        <div class="image-container">
            <img src="../assets/images/logo.png" alt="">
        </div>
        <a class="navbar-brand" href="#">DASHBOARD</a>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link " href="#">Posts</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Articles</a>
            </li><li class="nav-item">
                <a class="nav-link" href="../e_commerce/products.php">Produits</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../activities/liste_activites.php">Activités</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../admin/afficher_contacts.php">Contact</a>
            </li>
           
            <div class="user-dropdown">
                <img src="../assets/images/icon_user.png" alt="User Icon">
                <span class="user-name">Admin</span>
                <div class="user-dropdown-content">
                <a href="profil_admin.php">Profil</a>
                <a href="logout.php">Déconnexion</a>
                </div>
                </div>
            <!-- <li class="nav-item">
                <a class="nav-link" href="../authentication/register.php">Inscription</a>
            </li> -->
        </ul>
    </div>
    <!-- Bouton pour revenir au site -->
    <div class="site-button">
        <a href="../admin/dashboard.php" class="btn btn-primary">Retour</a>
    </div>


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
