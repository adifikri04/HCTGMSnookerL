<?php
require_once 'db.php';

$action = $_GET['action'] ?? '';
$data = json_decode(file_get_contents('php://input'), true) ?? [];

// Public: list merchandise
if ($action === 'list') {
    $rows = $pdo->query("SELECT * FROM merchandise ORDER BY created_at DESC")->fetchAll();
    sendJson($rows);
}

// Auth required below
$uid = checkAuth();

// Place an order
if ($action === 'buy' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $merch_id = $data['merchandise_id'] ?? 0;
    $qty      = max(1, intval($data['quantity'] ?? 1));

    $stmt = $pdo->prepare("SELECT * FROM merchandise WHERE id = ?");
    $stmt->execute([$merch_id]);
    $item = $stmt->fetch();

    if (!$item) sendJson(['error' => 'Item not found'], 404);
    if ($item['stock'] < $qty) sendJson(['error' => 'Not enough stock. Only ' . $item['stock'] . ' left.'], 400);

    $userStmt = $pdo->prepare("SELECT displayName, email FROM users WHERE uid = ?");
    $userStmt->execute([$uid]);
    $user = $userStmt->fetch();

    $total = $item['price'] * $qty;

    $user_name = $user['displayname'] ?? $user['displayName'] ?? 'Unknown';

    $pdo->prepare("INSERT INTO orders (user_uid, user_name, user_email, merchandise_id, merchandise_name, price, quantity, total) VALUES (?,?,?,?,?,?,?,?)")
        ->execute([$uid, $user_name, $user['email'], $merch_id, $item['name'], $item['price'], $qty, $total]);

    $pdo->prepare("UPDATE merchandise SET stock = stock - ? WHERE id = ?")->execute([$qty, $merch_id]);

    sendJson(['success' => true, 'total' => $total]);
}

// List my orders
if ($action === 'my_orders') {
    $rows = $pdo->prepare("SELECT * FROM orders WHERE user_uid = ? ORDER BY created_at DESC");
    $rows->execute([$uid]);
    sendJson($rows->fetchAll());
}

// Admin: list all orders
if ($action === 'list_all') {
    checkAdmin($pdo);
    $rows = $pdo->query("SELECT * FROM orders ORDER BY created_at DESC")->fetchAll();
    sendJson($rows);
}

// Admin: update order status
if ($action === 'update_status' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    checkAdmin($pdo);
    $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?")->execute([$data['status'], $data['id']]);
    sendJson(['success' => true]);
}

// Admin: delete order
if ($action === 'delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    checkAdmin($pdo);
    $pdo->prepare("DELETE FROM orders WHERE id = ?")->execute([$data['id']]);
    sendJson(['success' => true]);
}

sendJson(['error' => 'Invalid action'], 400);
?>
