<?php
require 'includes/functions.php';

if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}

$user = $_SESSION['user'];
$flash = pullFlash();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/register.css">
</head>
<body>

    <?php if ($flash): ?>
        <div class="toast toast-<?= e($flash['type']) ?>" role="status"><?= e($flash['text']) ?></div>
    <?php endif; ?>

    <div class="register-box home-box">
        <h1 class="register-title">Welcome!</h1>
        <img src="<?= e($user['pfp']) ?>" alt="Your profile picture" class="reg-pfp">
        <p class="home-name"><?= e($user['full_name']) ?></p>
        <p class="home-username">@<?= e($user['username']) ?></p>
        <a href="logout.php" class="register-button">Log Out</a>
    </div>

    <script src="js/main.js"></script>
</body>
</html>
