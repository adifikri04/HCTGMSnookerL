<?php
require_once 'db.php';

$action = $_GET['action'] ?? '';
$data = json_decode(file_get_contents('php://input'), true);

header('Content-Type: application/json');

if ($action === 'session') {
    if (isset($_SESSION['user_uid'])) {
        $stmt = $pdo->prepare("SELECT uid, email, displayName, role, phone, bio, photoURL FROM users WHERE uid = ?");
        $stmt->execute([$_SESSION['user_uid']]);
        $user = $stmt->fetch();
        if ($user) {
            sendJson(['user' => $user]);
        }
    }
    sendJson(['user' => null]);
}

if ($action === 'logout') {
    session_destroy();
    sendJson(['success' => true]);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendJson(['error' => 'Invalid method'], 405);
}

if ($action === 'signup') {
    $email      = trim($data['email'] ?? '');
    $password   = $data['password'] ?? '';
    $displayName = trim($data['displayName'] ?? '');

    if (empty($email) || empty($password) || empty($displayName)) {
        sendJson(['error' => 'All fields are required.'], 400);
    }

    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        sendJson(['error' => 'An account with this email already exists.'], 400);
    }

    $uid  = uniqid('user_', true);
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $role = (strtolower($email) === 'adifikri56@gmail.com') ? 'admin' : 'user';

    $stmt = $pdo->prepare("INSERT INTO users (uid, email, password, displayName, role) VALUES (?, ?, ?, ?, ?)");
    if ($stmt->execute([$uid, $email, $hash, $displayName, $role])) {
        $_SESSION['user_uid'] = $uid;
        sendJson(['success' => true, 'uid' => $uid, 'role' => $role]);
    } else {
        sendJson(['error' => 'Registration failed. Please try again.'], 500);
    }
}

if ($action === 'login') {
    $email    = trim($data['email'] ?? '');
    $password = $data['password'] ?? '';

    if (empty($email) || empty($password)) {
        sendJson(['error' => 'Email and password are required.'], 400);
    }

    $stmt = $pdo->prepare("SELECT uid, password, role, displayName FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_uid'] = $user['uid'];
        $dName = $user['displayName'] ?? $user['displayname'] ?? null;
        sendJson(['success' => true, 'uid' => $user['uid'], 'role' => $user['role'], 'displayName' => $dName]);
    } else {
        sendJson(['error' => 'Invalid email or password.'], 401);
    }
}

sendJson(['error' => 'Invalid action'], 400);
?>
