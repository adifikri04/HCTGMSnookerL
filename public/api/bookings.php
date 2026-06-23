<?php
require_once 'db.php';

$uid = checkAuth();
$action = $_GET['action'] ?? '';

if ($action === 'list_user') {
    $stmt = $pdo->prepare("SELECT id, user_uid, name, date, time, tableid AS \"tableId\", status, created_at FROM bookings WHERE user_uid = ? ORDER BY date DESC, time DESC");
    $stmt->execute([$uid]);
    sendJson($stmt->fetchAll());
}

if ($action === 'list_all') {
    checkAdmin($pdo);
    $stmt = $pdo->query("SELECT b.id, b.user_uid, b.name, b.date, b.time, b.tableid AS \"tableId\", b.status, b.created_at, u.email FROM bookings b JOIN users u ON b.user_uid = u.uid ORDER BY b.date DESC, b.time DESC");
    sendJson($stmt->fetchAll());
}

if ($action === 'check_slots') {
    $date = $_GET['date'] ?? '';
    $tableId = $_GET['tableId'] ?? '';
    $stmt = $pdo->prepare("SELECT time FROM bookings WHERE date = ? AND tableid = ? AND status != 'cancelled'");
    $stmt->execute([$date, $tableId]);
    sendJson($stmt->fetchAll(PDO::FETCH_COLUMN));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'create') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $name = $data['name'] ?? '';
    $date = $data['date'] ?? '';
    $time = $data['time'] ?? '';
    $tableId = $data['tableId'] ?? '';

    if (!$name || !$date || !$time || !$tableId) {
        sendJson(['error' => 'Missing fields'], 400);
    }

    date_default_timezone_set('Asia/Kuala_Lumpur');
    $currentDateTime = new DateTime();
    $bookingDateTime = new DateTime("$date $time");
    if ($bookingDateTime < $currentDateTime) {
        sendJson(['error' => 'Cannot book past dates or times'], 400);
    }

    $stmt = $pdo->prepare("SELECT id FROM bookings WHERE date = ? AND tableid = ? AND time = ? AND status != 'cancelled'");
    $stmt->execute([$date, $tableId, $time]);
    if ($stmt->fetch()) {
        sendJson(['error' => 'Time slot already booked'], 400);
    }

    $stmt = $pdo->prepare("INSERT INTO bookings (user_uid, name, date, time, tableid) VALUES (?, ?, ?, ?, ?)");
    if ($stmt->execute([$uid, $name, $date, $time, $tableId])) {
        sendJson(['success' => true]);
    } else {
        sendJson(['error' => 'Booking failed'], 500);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'update_status') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'] ?? '';
    $status = $data['status'] ?? '';
    
    // Allow users to cancel their own, but only admin can confirm
    if ($status === 'confirmed') {
        checkAdmin($pdo);
        $stmt = $pdo->prepare("UPDATE bookings SET status = ? WHERE id = ?");
        $stmt->execute([$status, $id]);
    } else if ($status === 'cancelled') {
        // user can cancel own
        $stmt = $pdo->prepare("UPDATE bookings SET status = ? WHERE id = ? AND (user_uid = ? OR (SELECT role FROM users WHERE uid = ?) = 'admin')");
        $stmt->execute([$status, $id, $uid, $uid]);
    }

    sendJson(['success' => true]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'delete') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'] ?? '';
    
    $stmt = $pdo->prepare("DELETE FROM bookings WHERE id = ? AND (user_uid = ? OR (SELECT role FROM users WHERE uid = ?) = 'admin')");
    $stmt->execute([$id, $uid, $uid]);

    sendJson(['success' => true]);
}

sendJson(['error' => 'Invalid action'], 400);
?>
