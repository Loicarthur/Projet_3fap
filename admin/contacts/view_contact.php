<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du contact</title>
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
            margin-left: 200px;
            padding: 10px;
        }
        
    h2 {
        text-align: center;
    }

    /* Styles pour les détails du contact */
    .contact-details {
        margin-top: 20px;
    }

    .contact-details p {
        margin-bottom: 10px;
    }

    /* Styles pour le lien de retour */
    .back-link {
        display: block;
        margin-top: 20px;
        text-align: center;
    }

   /* Style pour le logo */

   .menu-item {
            padding: 10px 20px;
            background-color: #007bff; /* Couleur bleue par défaut */
            color: #fff; /* Texte blanc par défaut */
            border-radius: 5px;
            text-decoration: none;
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
            text-decoration: none;
        }
        .nav-item{
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

<header>
    <div class="sidebar">
        <div class="image-container">
            <img src="../../assets/images/logo.png" alt="">
        </div>
        <a class="navbar-brand" href="dashboard.php">DASHBOARD</a>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link " href="../posts/liste_posts.php">Posts</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../articles/liste_articles.php">Articles</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../produits/liste_produits.php">Produits</a>
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

    
    <div class="container">
        
        <h2>Détails du contact</h2>
        <?php
        // Inclure le fichier de connexion à la base de données
        require_once '../../db_connect.php';

        // Vérifier si l'ID du contact est passé en paramètre
        if (isset($_GET['id'])) {
            $contactId = $_GET['id'];
            try {
                $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Requête pour récupérer les détails du contact
                $stmt = $conn->prepare("SELECT name, email, message, created_at FROM contact_requests WHERE id = :id");
                $stmt->bindParam(':id', $contactId);
                $stmt->execute();
                $contact = $stmt->fetch(PDO::FETCH_ASSOC);

                // Afficher les détails du contact
                if ($contact) {
                    echo "<p><strong>Nom :</strong> " . $contact['name'] . "</p>";
                    echo "<p><strong>Email :</strong> " . $contact['email'] . "</p>";
                    echo "<p><strong>Message :</strong> " . $contact['message'] . "</p>";
                    echo "<p><strong>Date :</strong> " . $contact['created_at'] . "</p>";
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
        <br>
        <a href="afficher_contacts.php" class="return-button">Retour à la liste des contacts</a>
    </div>
</body>
</html>
