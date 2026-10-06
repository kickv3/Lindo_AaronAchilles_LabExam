<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>

    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/register.css">
</head>
<body>

    <?php if ($flash): ?>
        <div class="toast toast-<?= e($flash['type']) ?>" role="status"><?= e($flash['text']) ?></div>
    <?php endif; ?>

    <div class="register-box">
        <h1 class="register-title">Create Account</h1>

        <form action="register.php" method="POST" enctype="multipart/form-data" novalidate>

            <div class="register-body">

                <div class="avatar-column">
                    <label for="pfp" class="avatar-label">
                        <img src="images/pfp.png" alt="Profile picture preview" class="reg-pfp" id="pfp-preview">
                        Add Profile Picture
                    </label>
                    <input type="file" id="pfp" name="pfp" accept="image/png,image/jpeg,image/webp" hidden>
                    <?= fieldError($errors, 'pfp') ?>
                </div>

                <div class="fields-column">

                    <label for="username" class="reg-label">Username</label>
                    <input type="text" id="username" name="username" maxlength="20" autocomplete="username"
                           class="reg-input icon-user<?= errorClass($errors, 'username') ?>"
                           placeholder="Choose a username" value="<?= e($old['username']) ?>">
                    <?= fieldError($errors, 'username') ?>

                    <label for="full_name" class="reg-label">Full Name</label>
                    <input type="text" id="full_name" name="full_name" maxlength="60" autocomplete="name"
                           class="reg-input<?= errorClass($errors, 'full_name') ?>"
                           placeholder="Enter your full name" value="<?= e($old['full_name']) ?>">
                    <?= fieldError($errors, 'full_name') ?>

                    <label for="password" class="reg-label">Password</label>
                    <input type="password" id="password" name="password" maxlength="72" autocomplete="new-password"
                           class="reg-input icon-lock<?= errorClass($errors, 'password') ?>"
                           placeholder="Create a password">
                    <?php if (isset($errors['password'])): ?>
                        <?= fieldError($errors, 'password') ?>
                    <?php else: ?>
                        <p class="field-hint">8 or more characters with uppercase, lowercase, and a number.</p>
                    <?php endif; ?>

                    <label for="confirm_password" class="reg-label">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" maxlength="72" autocomplete="new-password"
                           class="reg-input icon-lock<?= errorClass($errors, 'confirm') ?>"
                           placeholder="Re-enter your password">
                    <p class="field-hint" id="match-hint" aria-live="polite"></p>
                    <?= fieldError($errors, 'confirm') ?>

                </div>
            </div>

            <button class="register-button" type="submit">Register</button>

            <p class="switch-page"><a href="index.php">Already Have An Account? Login</a></p>

        </form>
    </div>

    <div class="social-box">
        <p class="social-title">Register Using</p>
        <hr>
        <div class="social-icons">
            <a href="#"><img src="images/logo-facebook.png" alt="Facebook Logo"></a>
            <a href="#"><img src="images/logo-google.png" alt="Google Logo"></a>
            <a href="#"><img src="images/logo-instagram.png" alt="Instagram Logo"></a>
            <a href="#"><img src="images/logo-twitter.png" alt="Twitter Logo"></a>
        </div>
    </div>

    <script src="js/main.js"></script>
</body>
</html>
