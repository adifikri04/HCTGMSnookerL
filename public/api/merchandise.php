<?php
require_once 'db.php';
checkAdmin($pdo);

$action = $_GET['action'] ?? '';
$data = json_decode(file_get_contents('php://input'), true);
if (empty($data)) {
    $data = $_POST;
}

if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = __DIR__ . '/../img/merch/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
    $filename = time() . '_' . basename($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $filename);
    $data['image_url'] = '/img/merch/' . $filename;
}
if ($action === 'list') {
    $rows = $pdo->query("SELECT * FROM merchandise ORDER BY created_at DESC")->fetchAll();
    sendJson($rows);
}

if ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("INSERT INTO merchandise (name, description, price, stock, image_url) VALUES (?,?,?,?,?)");
    $stmt->execute([$data['name'], $data['description'] ?? null, $data['price'] ?? 0, $data['stock'] ?? 0, $data['image_url'] ?? null]);
    sendJson(['success' => true, 'id' => $pdo->lastInsertId()]);
}

if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("UPDATE merchandise SET name=?, description=?, price=?, stock=?, image_url=? WHERE id=?");
    $stmt->execute([$data['name'], $data['description'] ?? null, $data['price'] ?? 0, $data['stock'] ?? 0, $data['image_url'] ?? null, $data['id']]);
    sendJson(['success' => true]);
}

if ($action === 'delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo->prepare("DELETE FROM merchandise WHERE id=?")->execute([$data['id']]);
    sendJson(['success' => true]);
}

sendJson(['error' => 'Invalid action'], 400);
?>
