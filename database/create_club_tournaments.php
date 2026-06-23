<?php
// database/create_club_tournaments.php

$pg_host = "aws-1-ap-northeast-1.pooler.supabase.com";
$pg_db = "postgres";
$pg_user = "postgres.lqdswbqcvxojqabkghdb";
$pg_pass = "hadifakri123";
$pg_port = "5432";

try {
    $pgsql = new PDO("pgsql:host=$pg_host;port=$pg_port;dbname=$pg_db;sslmode=require", $pg_user, $pg_pass);
    $pgsql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected to Supabase PostgreSQL.\n";

    $sql = "
        CREATE TABLE IF NOT EXISTS club_tournaments (
            id SERIAL PRIMARY KEY,
            date VARCHAR(255) NOT NULL,
            title VARCHAR(255) NOT NULL,
            description TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
    ";
    
    $pgsql->exec($sql);
    echo "Table 'club_tournaments' created successfully.\n";

} catch (Exception $e) {
    die("Failed: " . $e->getMessage() . "\n");
}
?>
