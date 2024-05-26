<?php
session_start();
require_once '../db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit();
    }

    $title = $_POST['title'];
    $content = $_POST['content'];
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("INSERT INTO posts (title, content, user_id) VALUES (?, ?, ?)");
    $stmt->execute([$title, $content, $user_id]);

    header('Location: view_posts.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Créer un nouveau post</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Créer un nouveau post</h1>
    <form method="post">
        <label for="title">Titre:</label>
        <input type="text" id="title" name="title" required><br>
        <label for="content">Contenu:</label>
        <textarea id="content" name="content" required></textarea><br>
        <input type="submit" value="Créer">
    </form>
</body>
</html>
