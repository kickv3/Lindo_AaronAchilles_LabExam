<?php
function imageExtension(string $tmpPath): ?string
{
    $info = @getimagesize($tmpPath);
    $types = [IMAGETYPE_JPEG => 'jpg', IMAGETYPE_PNG => 'png', IMAGETYPE_WEBP => 'webp'];
    return $info ? ($types[$info[2]] ?? null) : null;
}

function validateRegistration(array $in, array $file): array
{
    $errors = [];

    if ($in['username'] === '') {
        $errors['username'] = 'Username is required.';
    } elseif (!preg_match('/^[A-Za-z0-9_]{3,20}$/', $in['username'])) {
        $errors['username'] = 'Use 3 to 20 letters, numbers, or underscores.';
    } elseif (findUser($in['username'])) {
        $errors['username'] = 'That username is already taken.';
    }

    $nameLength = mb_strlen($in['full_name']);
    if ($in['full_name'] === '') {
        $errors['full_name'] = 'Full name is required.';
    } elseif ($nameLength < 2 || $nameLength > 60 || !preg_match('/^\p{L}[\p{L} .\'-]*$/u', $in['full_name'])) {
        $errors['full_name'] = 'Use letters and spaces only, 2 to 60 characters.';
    }

    $pw = $in['password'];
    if ($pw === '') {
        $errors['password'] = 'Password is required.';
    } elseif (strlen($pw) < 8 || strlen($pw) > 72) {
        $errors['password'] = 'Password must be 8 to 72 characters long.';
    } elseif (!preg_match('/[a-z]/', $pw) || !preg_match('/[A-Z]/', $pw) || !preg_match('/\d/', $pw)) {
        $errors['password'] = 'Add an uppercase letter, a lowercase letter, and a number.';
    }

    if ($in['confirm'] === '') {
        $errors['confirm'] = 'Please confirm your password.';
    } elseif (!hash_equals($pw, $in['confirm'])) {
        $errors['confirm'] = 'Passwords do not match.';
    }

    $code = $file['error'] ?? UPLOAD_ERR_NO_FILE;
    if ($code !== UPLOAD_ERR_NO_FILE) {
        $tooBig = in_array($code, [UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE], true)
            || ($code === UPLOAD_ERR_OK && $file['size'] > MAX_PFP_BYTES);
        if ($tooBig) {
            $errors['pfp'] = 'Picture must be 2 MB or smaller.';
        } elseif ($code !== UPLOAD_ERR_OK) {
            $errors['pfp'] = 'The upload failed. Please try again.';
        } elseif (imageExtension($file['tmp_name']) === null) {
            $errors['pfp'] = 'Picture must be a JPG, PNG, or WEBP image.';
        }
    }

    return $errors;
}

function savePicture(array $file): string
{
    if (!is_dir(UPLOAD_DIR)) {
        mkdir(UPLOAD_DIR, 0755, true);
    }
    $name = bin2hex(random_bytes(8)) . '.' . imageExtension($file['tmp_name']);
    move_uploaded_file($file['tmp_name'], UPLOAD_DIR . $name);
    return 'uploads/' . $name;
}
