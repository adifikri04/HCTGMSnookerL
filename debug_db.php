<?php
require_once 'api/db.php';
$stmt = $pdo->query("DESCRIBE tournament_registrations");
echo json_encode($stmt->fetchAll());
?>
