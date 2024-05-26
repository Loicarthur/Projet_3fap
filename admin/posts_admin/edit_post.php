<?php
session_start();
require_once '../../db_connect.php';

// Vérifier si l'utilisateur est connecté et s'il est administrateur
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin') {
    header('Location: login.php');
    exit();
}

// Récupérer le post à éditer
if (isset($_GET['id'])) {
    $postId = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
    $stmt->execute([$postId]);
    $post = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$post) {
        echo "Post non trouvé.";
        exit();
    }
} else {
    echo "ID de post manquant.";
    exit();
}

// Mettre à jour le post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $stmt = $pdo->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ?");
    $stmt->execute([$title, $content, $postId]);
    header('Location: manage_posts.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Modifier le post</title>
    <link rel="stylesheet" href="styles1.css">
</head>
<body>
    
    <form method="post">
    <div class="navbar">
    <a href="manage_posts.php" class="nav-link nav-link-return">Retour </a>
    </div>
    <h1>Modifier le post</h1>
        <label for="title">Titre:</label>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required><br>
        <label for="content">Contenu:</label>
        <textarea id="content" name="content" required><?php echo htmlspecialchars($post['content']); ?></textarea><br>
        <input type="submit" value="Mettre à jour">
    </form>
</body>
</html>
