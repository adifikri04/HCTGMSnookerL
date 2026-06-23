<?php
require_once 'db.php';

$action = $_GET['action'] ?? '';
$data = json_decode(file_get_contents('php://input'), true) ?? [];

if ($action === 'get') {
    $stmt = $pdo->query("SELECT * FROM ongoing_tournament LIMIT 1");
    sendJson($stmt->fetch() ?: null);
}

// ADMIN ONLY below
checkAdmin($pdo);

if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if row exists
    $stmt = $pdo->query("SELECT id FROM ongoing_tournament LIMIT 1");
    $row = $stmt->fetch();
    
    if ($row) {
        // Update existing row
        $stmt = $pdo->prepare("
            UPDATE ongoing_tournament SET 
                badge_text=?, title=?, description=?, 
                stat1_value=?, stat1_label=?, 
                stat2_value=?, stat2_label=?, 
                stat3_value=?, stat3_label=?,
                updated_at=CURRENT_TIMESTAMP
            WHERE id=?
        ");
        $stmt->execute([
            $data['badge_text'], $data['title'], $data['description'],
            $data['stat1_value'], $data['stat1_label'],
            $data['stat2_value'], $data['stat2_label'],
            $data['stat3_value'], $data['stat3_label'],
            $row['id']
        ]);
    } else {
        // Insert new row if doesn't exist (failsafe)
        $stmt = $pdo->prepare("
            INSERT INTO ongoing_tournament (badge_text, title, description, stat1_value, stat1_label, stat2_value, stat2_label, stat3_value, stat3_label)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['badge_text'], $data['title'], $data['description'],
            $data['stat1_value'], $data['stat1_label'],
            $data['stat2_value'], $data['stat2_label'],
            $data['stat3_value'], $data['stat3_label']
        ]);
    }
    
    sendJson(['success' => true]);
}

sendJson(['error' => 'Invalid action'], 400);
?>
