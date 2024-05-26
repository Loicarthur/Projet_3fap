<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3FAP </title>
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
    </style>
</head>
<body>
    <header>
        <div class="sidebar">
            <div class="image-container">
                <img src="../logo.png" alt="">
            </div>
            <a class="navbar-brand" href="#">DASHBOARD</a>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="../admin/dashboard.php">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">À propos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../activities/liste_activites.php">Activités</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../admin/afficher_contacts.php">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../authentication/logout.php">Lo</a>
                </li>
                
                <!-- <li class="nav-item">
                    <a class="nav-link" href="../authentication/register.php">Inscription</a>
                </li> -->
            </ul>
        </div>
    </header>

    <div class="main-content">
        <!-- Contenu principal ici -->
    </div>
</body>
</html>
