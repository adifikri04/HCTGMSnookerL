<?php
require_once 'db.php';

$uid = checkAuth();
$action = $_GET['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $action === 'list') {
    // Both users and admin can list club tournaments.
    $stmt = $pdo->query("SELECT id, date, title, description, created_at FROM club_tournaments ORDER BY date ASC LIMIT 3");
    sendJson($stmt->fetchAll());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'create') {
    checkAdmin($pdo);
    $data = json_decode(file_get_contents('php://input'), true);
    
    $date = $data['date'] ?? '';
    $title = $data['title'] ?? '';
    $description = $data['description'] ?? '';

    if (!$date || !$title || !$description) {
        sendJson(['error' => 'Missing fields'], 400);
    }

    $stmt = $pdo->prepare("INSERT INTO club_tournaments (date, title, description) VALUES (?, ?, ?)");
    if ($stmt->execute([$date, $title, $description])) {
        sendJson(['success' => true]);
    } else {
        sendJson(['error' => 'Failed to add tournament'], 500);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'update') {
    checkAdmin($pdo);
    $data = json_decode(file_get_contents('php://input'), true);
    
    $id = $data['id'] ?? '';
    $date = $data['date'] ?? '';
    $title = $data['title'] ?? '';
    $description = $data['description'] ?? '';

    if (!$id || !$date || !$title || !$description) {
        sendJson(['error' => 'Missing fields'], 400);
    }

    $stmt = $pdo->prepare("UPDATE club_tournaments SET date = ?, title = ?, description = ? WHERE id = ?");
    if ($stmt->execute([$date, $title, $description, $id])) {
        sendJson(['success' => true]);
    } else {
        sendJson(['error' => 'Failed to update tournament'], 500);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'delete') {
    checkAdmin($pdo);
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'] ?? '';
    
    if (!$id) {
        sendJson(['error' => 'Missing ID'], 400);
    }

    $stmt = $pdo->prepare("DELETE FROM club_tournaments WHERE id = ?");
    if ($stmt->execute([$id])) {
        sendJson(['success' => true]);
    } else {
        sendJson(['error' => 'Failed to delete tournament'], 500);
    }
}

sendJson(['error' => 'Invalid action'], 400);
?>
