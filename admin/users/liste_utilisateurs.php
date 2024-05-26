<?php
// Inclure le fichier de connexion à la base de données
require_once '../../db_connect.php';

// Requête SQL pour récupérer les utilisateurs
$stmt = $pdo->query("SELECT * FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
      
        /* Style pour le logo */
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

        /* Style pour le tableau des utilisateurs */
table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

th {
    background-color: #007bff; /* Bleu */
    color: white;
}

tr:nth-child(even) {
    background-color: #f8f9fa; /* Gris clair */
}

/* Style pour les liens d'action */
a {
    color: #007bff; /* Bleu */
    text-decoration: none;
    margin-right: 5px;
}

a:hover {
    color: #ff5722; /* Orange */
}

</style>
<body>
<header>
    <div class="sidebar">
        <div class="image-container">
            <img src="../assets/images/logo.png" alt="">
        </div>
        <a class="navbar-brand" href="dashboard.php">DASHBOARD</a>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link " href="#">Posts</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Articles</a>
            </li><li class="nav-item">
                <a class="nav-link" href="#">Produits</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../activities/liste_activites.php">Activités</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../admin/afficher_contacts.php">Contact</a>
            </li>
           
            <div class="user-dropdown">
                <img src="../../assets/images/icon_user.png" alt="User Icon">
                <span class="user-name">Admin</span>
                <div class="user-dropdown-content">
                <a href="../../authentication/profil.php">Profil</a>
                <a href="../../authentication/logout.php">Déconnexion</a>
                </div>
                </div>
            <!-- <li class="nav-item">
                <a class="nav-link" href="../authentication/register.php">Inscription</a>
            </li> -->
        </ul>
    </div>
   
</header>
<div class="container main-content">
    <table>
        <tr>
            <th>ID</th>
            <th>Nom d'utilisateur</th>
            <th>Rôle</th>
            <th>Prénom</th>
            <th>Nom</th>
            <th>Email</th>
            <th>Numéro de téléphone</th>
            <th>Date de naissance</th>
            <th>Action</th>
        </tr>
        <?php foreach ($users as $user) : ?>
        <tr>
            <td><?php echo $user['id']; ?></td>
            <td><?php echo $user['username']; ?></td>
            <td><?php echo $user['role']; ?></td>
            <td><?php echo $user['first_name']; ?></td>
            <td><?php echo $user['last_name']; ?></td>
            <td><?php echo $user['email']; ?></td>
            <td><?php echo $user['phone_number']; ?></td>
            <td><?php echo $user['date_of_birth']; ?></td>
            <td>
                <?php if (isset($user['active']) && $user['active']) : ?>
                    <a href="deactivate_user.php?id=<?php echo $user['id']; ?>">Désactiver</a>
                <?php else : ?>
                    <a href="activate_user.php?id=<?php echo $user['id']; ?>">Activer</a>
                <?php endif; ?>
                <a href="view_user.php?id=<?php echo $user['id']; ?>">Voir</a>
                <a href="edit_user.php?id=<?php echo $user['id']; ?>">Modifier</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

</body>
</html>