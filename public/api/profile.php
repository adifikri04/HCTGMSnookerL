<?php
require_once 'db.php';

$uid = checkAuth();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Get user info
    $stmt = $pdo->prepare("SELECT displayname AS \"displayName\", email, phone, bio, photourl AS \"photoURL\" FROM users WHERE uid = ?");
    $stmt->execute([$uid]);
    $user = $stmt->fetch();

    if (!$user) sendJson(['error' => 'User not found'], 404);

    // Get bookings
    $stmt = $pdo->prepare("SELECT id, user_uid, name, date, time, tableid AS \"tableId\", status, created_at FROM bookings WHERE user_uid = ? ORDER BY date DESC, time DESC");
    $stmt->execute([$uid]);
    $bookings = $stmt->fetchAll();

    // Get tournament registrations
    $stmt = $pdo->prepare("SELECT id, user_uid, tournamentname AS \"tournamentName\", name, email, membershipid AS \"membershipId\", status, created_at FROM tournament_registrations WHERE user_uid = ? ORDER BY created_at DESC");
    $stmt->execute([$uid]);
    $registrations = $stmt->fetchAll();

    sendJson([
        'user' => $user,
        'bookings' => $bookings,
        'registrations' => $registrations
    ]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $displayName = $data['displayName'] ?? '';
    $phone = $data['phone'] ?? null;
    $bio = $data['bio'] ?? null;

    if (empty($displayName)) {
        sendJson(['error' => 'Display name required'], 400);
    }

    $stmt = $pdo->prepare("UPDATE users SET displayName = ?, phone = ?, bio = ? WHERE uid = ?");
    if ($stmt->execute([$displayName, $phone, $bio, $uid])) {
        sendJson(['success' => true]);
    } else {
        sendJson(['error' => 'Update failed'], 500);
    }
}

sendJson(['error' => 'Invalid method'], 405);
?>
