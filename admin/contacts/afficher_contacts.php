<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des contacts</title>
    <link rel="stylesheet" href="assets/css/style_dashboard.css">
 <!-- Assurez-vous d'ajuster le chemin si nécessaire -->
</head>

<body>


<header>
    <div class="sidebar">
        <div class="image-container">
            <img src="../../assets/images/logo.png" alt="">
        </div>
        <a class="navbar-brand" href="#">DASHBOARD</a>
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
                <a class="nav-link" href="../activites/liste_activites.php">Activités</a>
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



    <style>
        /* Styles généraux */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin-left: 200px;
            padding: 10px;
        }

        h2 {
            text-align: center;
        }

        /* Styles du tableau */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        table th {
            background-color: #f2f2f2;
            text-align: center;
            color: #007bff;
        }

        /* Styles pour les liens */
        a {
            text-decoration: none;
            color: blue;
        }

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
            text-decoration: none;
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
    <div class="container">

         <!-- Bouton de retour -->
     <a href="../dashboard.php" class="return-button">Retour</a><br>

        <?php
        // Inclure le fichier de connexion à la base de données
        require_once '../../db_connect.php';

        // Traitement de la suppression du contact
        if (isset($_GET['delete'])) {
            $contactId = $_GET['delete'];
            try {
                $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Requête pour supprimer le contact
                $stmt = $conn->prepare("DELETE FROM contact_requests WHERE id = :id");
                $stmt->bindParam(':id', $contactId);
                $stmt->execute();

                echo "Le contact a été supprimé avec succès.";
            } catch (PDOException $e) {
                echo "Erreur lors de la suppression du contact : " . $e->getMessage();
            }
        }

        // Affichage des contacts
        try {
            $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Requête pour récupérer tous les contacts
            $sql = "SELECT id, name, email, message, created_at FROM contact_requests";
            $result = $conn->query($sql);

            // Afficher les contacts
            if ($result && $result->rowCount() > 0) {
                echo "<h2>Liste des contacts</h2>";
                echo "<table>";
                echo "<tr><th>Nom</th><th>Email</th><th>Message</th><th>Date</th><th>Action</th></tr>";
                while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['message'] . "</td>";
                    echo "<td>" . $row['created_at'] . "</td>";
                    echo "<td>";
                    echo "<a href=\"view_contact.php?id=" . $row['id'] . "\">Voir</a> | ";
                    echo "<a href=\"modifier_contact.php?id=" . $row['id'] . "\">Modifier</a> | "; // Lien pour modifier le contact
                    echo "<a href=\"liste_contacts.php?delete=" . $row['id'] . "\" onclick=\"return confirm('Êtes-vous sûr de vouloir supprimer ce contact ?');\">Supprimer</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "Aucun contact trouvé.";
            }

            // Fermer la connexion
            $conn = null;
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des contacts : " . $e->getMessage();
        }
        ?>
    </div>
</body>
</html>
