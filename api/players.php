<?php
require_once 'db.php';
checkAdmin($pdo);

$action = $_GET['action'] ?? '';
$data = json_decode(file_get_contents('php://input'), true) ?? [];

if ($action === 'list') {
    $rows = $pdo->query("SELECT * FROM club_players ORDER BY points DESC")->fetchAll();
    sendJson($rows);
}

if ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("INSERT INTO club_players (name, email, level, wins, tournaments_played, points) VALUES (?,?,?,?,?,?)");
    $stmt->execute([$data['name'], $data['email'] ?? null, $data['level'] ?? 'Beginner', $data['wins'] ?? 0, $data['tournaments_played'] ?? 0, $data['points'] ?? 0]);
    sendJson(['success' => true, 'id' => $pdo->lastInsertId()]);
}

if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("UPDATE club_players SET name=?, email=?, level=?, wins=?, tournaments_played=?, points=? WHERE id=?");
    $stmt->execute([$data['name'], $data['email'] ?? null, $data['level'], $data['wins'] ?? 0, $data['tournaments_played'] ?? 0, $data['points'] ?? 0, $data['id']]);
    sendJson(['success' => true]);
}

if ($action === 'delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo->prepare("DELETE FROM club_players WHERE id=?")->execute([$data['id']]);
    sendJson(['success' => true]);
}

sendJson(['error' => 'Invalid action'], 400);
?>
