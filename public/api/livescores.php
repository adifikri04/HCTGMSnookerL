<?php
require_once 'db.php';

$action = $_GET['action'] ?? '';
$data = json_decode(file_get_contents('php://input'), true) ?? [];

// PUBLIC: list all matches
if ($action === 'list') {
    $rows = $pdo->query("SELECT * FROM live_scores ORDER BY CASE status WHEN 'live' THEN 1 WHEN 'upcoming' THEN 2 WHEN 'completed' THEN 3 ELSE 4 END, created_at DESC")->fetchAll();
    sendJson($rows);
}

// PUBLIC: get single match
if ($action === 'get') {
    $id = $_GET['id'] ?? 0;
    $stmt = $pdo->prepare("SELECT * FROM live_scores WHERE id=?");
    $stmt->execute([$id]);
    sendJson($stmt->fetch() ?: null);
}

// ADMIN ONLY below
checkAdmin($pdo);

if ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("INSERT INTO live_scores (match_title,player1_name,player2_name,player1_score,player2_score,player1_frames,player2_frames,status,table_number,notes) VALUES (?,?,?,?,?,?,?,?,?,?)");
    $stmt->execute([$data['match_title'],$data['player1_name'],$data['player2_name'],
        $data['player1_score']??0,$data['player2_score']??0,
        $data['player1_frames']??0,$data['player2_frames']??0,
        $data['status']??'upcoming',$data['table_number']??'Table 1',$data['notes']??'']);
    sendJson(['success'=>true,'id'=>$pdo->lastInsertId()]);
}

if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("UPDATE live_scores SET match_title=?,player1_name=?,player2_name=?,player1_score=?,player2_score=?,player1_frames=?,player2_frames=?,status=?,table_number=?,notes=? WHERE id=?");
    $stmt->execute([$data['match_title'],$data['player1_name'],$data['player2_name'],
        $data['player1_score']??0,$data['player2_score']??0,
        $data['player1_frames']??0,$data['player2_frames']??0,
        $data['status']??'upcoming',$data['table_number']??'Table 1',$data['notes']??'',$data['id']]);
    sendJson(['success'=>true]);
}

// Quick score update (just scores & frames, no form needed)
if ($action === 'update_score' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("UPDATE live_scores SET player1_score=?,player2_score=?,player1_frames=?,player2_frames=?,status=? WHERE id=?");
    $stmt->execute([$data['player1_score'],$data['player2_score'],$data['player1_frames'],$data['player2_frames'],$data['status'],$data['id']]);
    sendJson(['success'=>true]);
}

if ($action === 'delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo->prepare("DELETE FROM live_scores WHERE id=?")->execute([$data['id']]);
    sendJson(['success'=>true]);
}

sendJson(['error'=>'Invalid action'],400);
?>
