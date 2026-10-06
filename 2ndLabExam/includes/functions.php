<?php
require_once __DIR__ . '/../config.php';

session_start();

function e(string $text): string
{
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

function setFlash(string $type, string $text): void
{
    $_SESSION['flash'] = ['type' => $type, 'text' => $text];
}

function pullFlash(): ?array
{
    $flash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $flash;
}

function fieldError(array $errors, string $field): string
{
    return isset($errors[$field]) ? '<p class="field-error">' . e($errors[$field]) . '</p>' : '';
}

function errorClass(array $errors, string $field): string
{
    return isset($errors[$field]) ? ' has-error' : '';
}

function getPdo(): PDO
{
    static $pdo = null;
    if ($pdo === null) {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }
    return $pdo;
}

function readMockUsers(): array
{
    if (!file_exists(MOCK_FILE)) {
        return [];
    }
    return json_decode(file_get_contents(MOCK_FILE), true) ?: [];
}

function findUser(string $username): ?array
{
    if (USE_MOCK_DB) {
        foreach (readMockUsers() as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return $user;
            }
        }
        return null;
    }
    $stmt = getPdo()->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->execute([$username]);
    return $stmt->fetch() ?: null;
}

function createUser(string $username, string $fullName, string $passwordHash, string $pfp): void
{
    if (USE_MOCK_DB) {
        $dir = dirname(MOCK_FILE);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
            file_put_contents($dir . '/.htaccess', "Require all denied\n");
        }
        $users = readMockUsers();
        $users[] = [
            'username' => $username,
            'full_name' => $fullName,
            'password' => $passwordHash,
            'pfp' => $pfp,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        file_put_contents(MOCK_FILE, json_encode($users, JSON_PRETTY_PRINT), LOCK_EX);
        return;
    }
    $stmt = getPdo()->prepare('INSERT INTO users (username, full_name, password, pfp) VALUES (?, ?, ?, ?)');
    $stmt->execute([$username, $fullName, $passwordHash, $pfp]);
}
