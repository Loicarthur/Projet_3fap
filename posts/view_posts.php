<?php
session_start();
require_once '../db_connect.php';

// Fetch the post
if (isset($_GET['id'])) {
    $postId = $_GET['id'];
    $stmt = $pdo->prepare("SELECT posts.id, posts.title, posts.content, posts.created_at, users.username 
                           FROM posts JOIN users ON posts.user_id = users.id WHERE posts.id = ?");
    $stmt->execute([$postId]);
    $post = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$post) {
        echo "Post non trouvé.";
        exit();
    }
} else {
    echo "<p><a href='../authentication/login.php'>Connectez-vous</a> pour voir les Posts.</p>";
    exit();
}

// Fetch comments
$stmt = $pdo->prepare("SELECT comments.content, comments.created_at, users.username 
                       FROM comments JOIN users ON comments.user_id = users.id 
                       WHERE comments.post_id = ? ORDER BY comments.created_at DESC");
$stmt->execute([$postId]);
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Add new comment
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    if (!isset($_SESSION['user_id'])) {
        echo "Vous devez être connecté pour commenter.";
    } else {
        $commentContent = $_POST['comment'];
        $userId = $_SESSION['user_id'];

        $stmt = $pdo->prepare("INSERT INTO comments (post_id, user_id, content) VALUES (?, ?, ?)");
        $stmt->execute([$postId, $userId, $commentContent]);

        // Refresh the page to show the new comment
        header("Location: view_post.php?id=" . $postId);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($post['title']); ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1><?php echo htmlspecialchars($post['title']); ?></h1>
    <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
    <p><strong>Auteur:</strong> <?php echo htmlspecialchars($post['username']); ?></p>
    <p><strong>Date de création:</strong> <?php echo htmlspecialchars($post['created_at']); ?></p>

    <h2>Commentaires</h2>
    <div class="comments-container">
        <?php foreach ($comments as $comment): ?>
            <div class="comment-item">
                <p><?php echo nl2br(htmlspecialchars($comment['content'])); ?></p>
                <p><strong><?php echo htmlspecialchars($comment['username']); ?></strong>, <?php echo htmlspecialchars($comment['created_at']); ?></p>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if (isset($_SESSION['user_id'])): ?>
        <form method="post">
            <textarea name="comment" required></textarea><br>
            <input type="submit" value="Ajouter un commentaire">
        </form>
    <?php else: ?>
        <p><a href="login.php">Connectez-vous</a> pour commenter.</p>
    <?php endif; ?>
</body>
</html>
