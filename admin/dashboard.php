<?php
// Inclure le fichier de connexion à la base de données
require_once '../db_connect.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Définir le mode d'erreur PDO sur Exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Définir le jeu de caractères en UTF-8
    $pdo->exec("set names utf8");

    // Récupérer le nombre total d'utilisateurs enregistrés
    $stmtUsers = $pdo->prepare("SELECT COUNT(*) AS totalUsers FROM users");
    $stmtUsers->execute();
    $totalUsers = $stmtUsers->fetch(PDO::FETCH_ASSOC)['totalUsers'];

    // Requête pour récupérer le nombre total d'articles
    $stmtArticles = $pdo->prepare("SELECT COUNT(*) AS totalArticles FROM articles");
    $stmtArticles->execute();
    $totalArticles = $stmtArticles->fetch(PDO::FETCH_ASSOC)['totalArticles'];

    // Requête pour récupérer le nombre total de posts
    $stmtPosts = $pdo->prepare("SELECT COUNT(*) AS totalPosts FROM posts");
    $stmtPosts->execute();
    $totalPosts = $stmtPosts->fetch(PDO::FETCH_ASSOC)['totalPosts'];

    // Récupérer le nombre total de contacts reçus
    $stmtContacts = $pdo->prepare("SELECT COUNT(*) AS totalContacts FROM contact_requests");
    $stmtContacts->execute();
    $totalContacts = $stmtContacts->fetch(PDO::FETCH_ASSOC)['totalContacts'];

    // Récupérer le nombre total d'activités enregistrées
    $stmtActivities = $pdo->prepare("SELECT COUNT(*) AS totalActivities FROM activites");
    $stmtActivities->execute();
    $totalActivities = $stmtActivities->fetch(PDO::FETCH_ASSOC)['totalActivities'];

    // Récupérer le nombre total de produits ou d'articles enregistrés
    $stmtGoodies = $pdo->prepare("SELECT COUNT(*) AS totalGoodies FROM goodies");
    $stmtGoodies->execute();
    $totalGoodies = $stmtGoodies->fetch(PDO::FETCH_ASSOC)['totalGoodies'];
} catch(PDOException $e) {
    // Gérer les erreurs de connexion à la base de données
    echo "Erreur de connexion à la base de données: " . $e->getMessage();
}
?>




<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord administrateur</title>
    <link rel="stylesheet" href="assets/css/style_dashboard.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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

    </style>
</head>
<body>
<header>
    <div class="sidebar">
        <div class="image-container">
            <img src="../assets/images/logo.png" alt="">
        </div>
        <a class="navbar-brand" href="dashboard.php">DASHBOARD</a>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link " href="posts_admin/manage_posts.php">Posts</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="articles/liste_articles.php">Articles</a>
            </li><li class="nav-item">
                <a class="nav-link" href="#">Produits</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../activites/liste_activites.php">Activités</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="contacts/afficher_contacts.php">Contact</a>
            </li>
           
            <div class="user-dropdown">
                <img src="../assets/images/icon_user.png" alt="User Icon">
                <span class="user-name">Admin</span>
                <div class="user-dropdown-content">
                <a href="../authentication/profil_admin.php">Profil</a>
                <a href="../authentication/logout.php">Déconnexion</a>
                </div>
                </div>
            <!-- <li class="nav-item">
                <a class="nav-link" href="../authentication/register.php">Inscription</a>
            </li> -->
        </ul>
    </div>
    <!-- Bouton pour revenir au site -->
    <div class="site-button">
        <a href="../index.php" class="btn btn-primary">Revenir au site</a>
    </div>
    <!-- Ajout du deuxième menu horizontal -->
   <!-- HTML avec le nom d'utilisateur récupéré -->
<!-- <div class="menu">
    <div class="user">
        <span class="username"><?php echo $username; ?></span>
        <div class="dropdown-content">
            <a href="#">Profil</a>
            <a href="../authentication/logout.php">Déconnexion</a>
        </div>
    </div>
</div>-->
</header> 



<div class="container main-content">
    <h2>Tableau de bord administrateur</h2>
    <div class="stats">
        <div class="stat-item">
            <h3>Total utilisateurs </h3>
            <h4><?php echo $totalUsers; ?></h4>
            <div class="button-container">
                <strong><a href="users/liste_utilisateurs.php" class="custom-button">Voir plus </a></strong>
            </div>
        </div>
        <div class="stat-item">
            <h3>Total contacts reçus</h3>
            <h4><?php echo $totalContacts; ?></h4>
            <div class="button-container">
                <strong><a href="contacts/afficher_contacts.php" class="custom-button">Voir plus </a></strong>
            </div>
        </div>
        <div class="stat-item">
            <h3>Total activités enregistrées</h3>
            <h4><?php echo $totalActivities; ?></h4>
            <div class="button-container">
                <strong><a href="activites/liste_activites.php" class="custom-button">Voir plus </a></strong>
            </div>
        </div>
        <div class="stat-item">
            <h3>Total posts enregistrés</h3>
            <h4><?php echo $totalPosts; ?></h4>
            <div class="button-container">
                <strong><a href="posts_admin/manage_posts.php" class="custom-button">Voir plus </a></strong>
            </div>
        </div>
        <div class="stat-item">
            <h3>Total articles enregistrés</h3>
            <h4><?php echo $totalArticles; ?></h4>
            <div class="button-container">
                <strong><a href="articles/liste_articles.php" class="custom-button">Voir plus </a></strong>
            </div>
        </div>
        <div class="stat-item">
            <h3>Total produits enregistrés</h3>
            <h4><?php echo $totalGoodies; ?></h4>
            <div class="button-container">
                <strong><a href="liste_goodies.php" class="custom-button">Voir plus </a></strong>
            </div>
        </div>
    </div>
</div>

<canvas id="myChart"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Données du graphique
    const data = {
        labels: ['Utilisateurs', 'Contacts', 'Activités', 'Produits', 'Articles', 'Posts'],
        datasets: [{
            label: 'Total',
            backgroundColor: [
                'rgba(255, 99, 132, 0.5)', // Couleur de remplissage pour Utilisateurs
                'rgba(54, 162, 235, 0.5)', // Couleur de remplissage pour Contacts
                'rgba(255, 206, 86, 0.5)', // Couleur de remplissage pour Activités
                'rgba(75, 192, 192, 0.5)', // Couleur de remplissage pour Produits
                'rgba(153, 102, 255, 0.5)', // Couleur de remplissage pour Articles
                'rgba(255, 159, 64, 0.5)' // Couleur de remplissage pour Posts
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)', // Couleur de la bordure pour Utilisateurs
                'rgba(54, 162, 235, 1)', // Couleur de la bordure pour Contacts
                'rgba(255, 206, 86, 1)', // Couleur de la bordure pour Activités
                'rgba(75, 192, 192, 1)', // Couleur de la bordure pour Produits
                'rgba(153, 102, 255, 1)', // Couleur de la bordure pour Articles
                'rgba(255, 159, 64, 1)' // Couleur de la bordure pour Posts
            ],
            borderWidth: 1,
            data: [
                <?php echo $totalUsers; ?>,
                <?php echo $totalContacts; ?>,
                <?php echo $totalActivities; ?>,
                <?php echo $totalGoodies; ?>,
                <?php echo $totalArticles; ?>,
                <?php echo $totalPosts; ?>
            ] // Remplacez par vos données réelles
        }]
    };

    // Options du graphique
    const options = {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    };

    // Créer le graphique
    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: options
    });


    document.addEventListener('DOMContentLoaded', function() {
    var username = document.querySelector('.username');
    username.addEventListener('click', function() {
        var dropdown = document.querySelector('.dropdown-content');
        dropdown.style.display = (dropdown.style.display === 'block') ? 'none' : 'block';
    });
    });

</script>

</body>
</html>
