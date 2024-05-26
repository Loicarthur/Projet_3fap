<?php
session_start();
require_once '../../db_connect.php';

// Vérifier si l'utilisateur est connecté et s'il est administrateur
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin') {
    header('Location: login.php');
    exit();
}

// Récupérer tous les posts
$stmt = $pdo->query("SELECT posts.id, posts.title, posts.content, posts.created_at, users.username FROM posts JOIN users ON posts.user_id = users.id ORDER BY posts.created_at DESC");
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Gérer la suppression de post
if (isset($_POST['delete_post'])) {
    $postId = $_POST['post_id'];
    $stmt = $pdo->prepare("DELETE FROM posts WHERE id = ?");
    $stmt->execute([$postId]);
    header('Location: manage_posts.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gérer les posts</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Gérer les posts</h1>
    <div class="navbar">
    <a href="../dashboard.php" class="nav-link nav-link-return">Retour au tableau de bord</a>
    <a href="../../posts/create_post.php" class="nav-link nav-link-create">Créer un nouveau post</a>
    </div>
    <div class="posts-container">
        <?php foreach ($posts as $post): ?>
            <div class="post-item">
                <h2><?php echo htmlspecialchars($post['title']); ?></h2>
                <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                <p><strong>Auteur:</strong> <?php echo htmlspecialchars($post['username']); ?></p>
                <p><strong>Date de création:</strong> <?php echo htmlspecialchars($post['created_at']); ?></p>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                    <input type="submit" name="delete_post" value="Supprimer" class="btn btn-danger">
                </form>
                <a href="edit_post.php?id=<?php echo $post['id']; ?>" class="btn btn-secondary">Modifier</a>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
