<?php
require 'includes/functions.php';

if (isset($_SESSION['user'])) {
    header('Location: home.php');
    exit;
}

$flash = pullFlash();
$username = $_COOKIE['remembered_user'] ?? '';
$remember = $username !== '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);

    try {
        if ($username === '' || $password === '') {
            $flash = ['type' => 'error', 'text' => 'Please enter your username and password.'];
        } else {
            $user = findUser($username);

            if ($user && password_verify($password, $user['password'])) {
                session_regenerate_id(true);

                $_SESSION['user'] = [
                    'username'  => $user['username'],
                    'full_name' => $user['full_name'],
                    'pfp'       => $user['pfp'],
                ];

                if ($remember) {
                    setcookie('remembered_user', $user['username'], [
                        'expires'  => time() + 60 * 60 * 24 * 30,
                        'httponly' => true,
                        'samesite' => 'Lax',
                    ]);
                } else {
                    setcookie('remembered_user', '', time() - 3600);
                }

                setFlash('success', 'Welcome back, ' . $user['full_name'] . '!');
                header('Location: home.php');
                exit;
            }

            $flash = ['type' => 'error', 'text' => 'Incorrect username or password.'];
        }
    } catch (PDOException $ex) {
        $flash = ['type' => 'error', 'text' => 'Could not reach the database. Please try again.'];
    }
}

require 'login/index.view.php';
