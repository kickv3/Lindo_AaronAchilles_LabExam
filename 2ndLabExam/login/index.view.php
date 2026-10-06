<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Registration System</title>

    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/register.css">
</head>
<body>

    <?php if ($flash): ?>
        <div class="toast toast-<?= e($flash['type']) ?>" role="status"><?= e($flash['text']) ?></div>
    <?php endif; ?>

    <div class="login-box">
        <h1><span class = "welcome-text">Welcome!</span></h1>
        <img src = "images/pfp.png" alt = "Profile Picture" class = "pfp">

        <form action = "index.php" method = "POST">

            <p class = "text text-username">Username</p>

            <div class = "input input-username">
                <input type = "text" id = "username" name = "username" value = "<?= e($username) ?>" placeholder = "Enter your username" required>
            </div>

            <p class = "text text-password">Password</p>

            <div class = "input input-password">
                <input type = "password" id = "password" name = "password" placeholder = "Enter your password" required>
            </div>
            
            <div class = "remember-me"> 
                    <input type = "checkbox" id = "remember-me" name = "remember" value = "yes" <?= $remember ? 'checked' : '' ?>>
                    <label for = "remember-me">Remember Me</label>
            </div>

            <div class = "forgot-password">
                <a href = '#'>Forgot Password?</a>
            </div>
            
            <button class="login-button" type="submit">Log In</button>

            <div class = "no-account">
                <a href = 'register.php'>Don't Have An Account Yet? Register</a>
            </div>

        </form>
    </div>

    <p class = "login-using">Login Using</p>

    <hr class = "line">

    <a href = "#">
        <img src = "images/logo-facebook.png" alt = "Facebook Logo" class = "logo-facebook">
    </a>

    <a href = "#">
        <img src = "images/logo-google.png" alt = "Google Logo" class = "logo-google">
    </a>

    <a href = "#">
        <img src = "images/logo-instagram.png" alt = "Instagram Logo" class = "logo-instagram">
    </a>

    <a href = "#">
        <img src = "images/logo-twitter.png" alt = "Twitter Logo" class = "logo-twitter">
    </a>

    <script src="js/main.js"></script>
</body>
</html>
