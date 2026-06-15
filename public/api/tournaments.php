<?php
require_once 'db.php';

$uid = checkAuth();
$action = $_GET['action'] ?? '';

if ($action === 'list_all') {
    checkAdmin($pdo);
    $stmt = $pdo->query("SELECT id, user_uid, tournamentname AS \"tournamentName\", name, email, membershipid AS \"membershipId\", status, created_at FROM tournament_registrations ORDER BY created_at DESC");
    sendJson($stmt->fetchAll());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'register') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $tournamentName = $data['tournamentName'] ?? '';
    $name = $data['name'] ?? '';
    $email = $data['email'] ?? '';
    $membershipId = $data['membershipId'] ?? null;

    if (!$tournamentName || !$name || !$email) {
        sendJson(['error' => 'Missing fields'], 400);
    }

    $stmt = $pdo->prepare("INSERT INTO tournament_registrations (user_uid, tournamentname, name, email, membershipid) VALUES (?, ?, ?, ?, ?)");
    if ($stmt->execute([$uid, $tournamentName, $name, $email, $membershipId])) {
        sendJson(['success' => true]);
    } else {
        sendJson(['error' => 'Registration failed'], 500);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'update_status') {
    checkAdmin($pdo);
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'] ?? '';
    $status = $data['status'] ?? '';
    
    $stmt = $pdo->prepare("UPDATE tournament_registrations SET status = ? WHERE id = ?");
    $stmt->execute([$status, $id]);

    sendJson(['success' => true]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'delete') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'] ?? '';
    
    // Allow if it's the user's own registration or they are admin
    $stmt = $pdo->prepare("DELETE FROM tournament_registrations WHERE id = ? AND (user_uid = ? OR (SELECT role FROM users WHERE uid = ?) = 'admin')");
    $stmt->execute([$id, $uid, $uid]);

    sendJson(['success' => true]);
}

sendJson(['error' => 'Invalid action'], 400);
?>
