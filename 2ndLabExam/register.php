<?php
require 'includes/functions.php';
require 'includes/validation.php';

if (isset($_SESSION['user'])) {
    header('Location: home.php');
    exit;
}

$errors = [];
$flash = null;
$old = ['username' => '', 'full_name' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = [
        'username'  => trim($_POST['username'] ?? ''),
        'full_name' => trim($_POST['full_name'] ?? ''),
        'password'  => $_POST['password'] ?? '',
        'confirm'   => $_POST['confirm_password'] ?? '',
    ];
    $old = ['username' => $input['username'], 'full_name' => $input['full_name']];
    $file = $_FILES['pfp'] ?? ['error' => UPLOAD_ERR_NO_FILE];

    try {
        $errors = validateRegistration($input, $file);

        if (!$errors) {
            $pfp = ($file['error'] === UPLOAD_ERR_OK) ? savePicture($file) : 'images/pfp.png';

            createUser($input['username'], $input['full_name'], password_hash($input['password'], PASSWORD_DEFAULT), $pfp);

            setFlash('success', 'Account created! You can log in now.');
            header('Location: index.php');
            exit;
        }
        $flash = ['type' => 'error', 'text' => 'Please fix the highlighted fields.'];
    } catch (PDOException $ex) {
        if ($ex->getCode() === '23000') {
            $errors['username'] = 'That username is already taken.';
            $flash = ['type' => 'error', 'text' => 'Please fix the highlighted fields.'];
        } else {
            $flash = ['type' => 'error', 'text' => 'Could not reach the database. Please try again.'];
        }
    }
}

require 'register/index.view.php';
