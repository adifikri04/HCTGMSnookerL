<?php
session_start();

$pg_host = "aws-1-ap-northeast-1.pooler.supabase.com";
$pg_db = "postgres";
$pg_user = "postgres.lqdswbqcvxojqabkghdb";
$pg_pass = "hadifakri123"; // UPDATE THIS WITH YOUR ACTUAL PASSWORD!
$pg_port = "5432";

try {
    $pdo = new PDO("pgsql:host=$pg_host;port=$pg_port;dbname=$pg_db;sslmode=require", $pg_user, $pg_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die(json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]));
}

function sendJson($data, $status = 200) {
    http_response_code($status);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

function checkAuth() {
    if (!isset($_SESSION['user_uid'])) {
        sendJson(['error' => 'Unauthorized'], 401);
    }
    return $_SESSION['user_uid'];
}

function checkAdmin($pdo) {
    $uid = checkAuth();
    $stmt = $pdo->prepare("SELECT role FROM users WHERE uid = ?");
    $stmt->execute([$uid]);
    $user = $stmt->fetch();
    if (!$user || $user['role'] !== 'admin') {
        sendJson(['error' => 'Forbidden - Admin only'], 403);
    }
    return $uid;
}
?>
