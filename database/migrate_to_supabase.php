<?php
// database/migrate_to_supabase.php

// 1. Connect to Local MySQL
$mysql = new PDO("mysql:host=localhost;dbname=hctgmsnooker;charset=utf8mb4", "root", "");
$mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// 2. Connect to Supabase PostgreSQL
$pg_host = "aws-1-ap-northeast-1.pooler.supabase.com";
$pg_db = "postgres";
$pg_user = "postgres.lqdswbqcvxojqabkghdb";
$pg_pass = "hadifakri123"; // UPDATE THIS WITH YOUR ACTUAL PASSWORD!
$pg_port = "5432";

try {
    $pgsql = new PDO("pgsql:host=$pg_host;port=$pg_port;dbname=$pg_db;sslmode=require", $pg_user, $pg_pass);
    $pgsql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("Failed to connect to Supabase: " . $e->getMessage() . "\n");
}

echo "Connected to both databases.\n";

// Drop existing tables to avoid conflicts
$pgsql->exec("DROP TABLE IF EXISTS orders, tournament_registrations, bookings, live_scores, merchandise, club_players, users CASCADE;");

$tables = [
    'users' => "
        CREATE TABLE users (
            id SERIAL PRIMARY KEY,
            uid VARCHAR(255) UNIQUE NOT NULL,
            email VARCHAR(255) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL,
            displayName VARCHAR(255) NOT NULL,
            role VARCHAR(50) DEFAULT 'user',
            phone VARCHAR(50) NULL,
            bio TEXT NULL,
            photoURL VARCHAR(500) NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
    ",
    'bookings' => "
        CREATE TABLE bookings (
            id SERIAL PRIMARY KEY,
            user_uid VARCHAR(255) NOT NULL,
            name VARCHAR(255) NOT NULL,
            date DATE NOT NULL,
            time VARCHAR(50) NOT NULL,
            tableId VARCHAR(100) NOT NULL,
            status VARCHAR(50) DEFAULT 'pending',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_uid) REFERENCES users(uid) ON DELETE CASCADE
        );
    ",
    'club_players' => "
        CREATE TABLE club_players (
            id SERIAL PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NULL,
            level VARCHAR(50) DEFAULT 'Beginner',
            wins INT DEFAULT 0,
            tournaments_played INT DEFAULT 0,
            points INT DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
    ",
    'live_scores' => "
        CREATE TABLE live_scores (
            id SERIAL PRIMARY KEY,
            match_title VARCHAR(255) NOT NULL,
            player1_name VARCHAR(255) NOT NULL,
            player2_name VARCHAR(255) NOT NULL,
            player1_score INT DEFAULT 0,
            player2_score INT DEFAULT 0,
            player1_frames INT DEFAULT 0,
            player2_frames INT DEFAULT 0,
            status VARCHAR(50) DEFAULT 'upcoming',
            table_number VARCHAR(50) DEFAULT 'Table 1',
            notes VARCHAR(255) DEFAULT '',
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
    ",
    'merchandise' => "
        CREATE TABLE merchandise (
            id SERIAL PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            description TEXT,
            price DECIMAL(10,2) NOT NULL DEFAULT 0.00,
            stock INT DEFAULT 0,
            image_url VARCHAR(500) DEFAULT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
    ",
    'orders' => "
        CREATE TABLE orders (
            id SERIAL PRIMARY KEY,
            user_uid VARCHAR(255) NOT NULL,
            user_name VARCHAR(255) NOT NULL,
            user_email VARCHAR(255) NOT NULL,
            merchandise_id INT NOT NULL,
            merchandise_name VARCHAR(255) NOT NULL,
            price DECIMAL(10,2) NOT NULL,
            quantity INT DEFAULT 1,
            total DECIMAL(10,2) NOT NULL,
            status VARCHAR(50) DEFAULT 'pending',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_uid) REFERENCES users(uid) ON DELETE CASCADE
        );
    ",
    'tournament_registrations' => "
        CREATE TABLE tournament_registrations (
            id SERIAL PRIMARY KEY,
            user_uid VARCHAR(255) NOT NULL,
            tournamentName VARCHAR(255) NOT NULL,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            membershipId VARCHAR(100) NULL,
            status VARCHAR(50) DEFAULT 'pending',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_uid) REFERENCES users(uid) ON DELETE CASCADE
        );
    "
];

// Order matters due to foreign keys (users must be first)
$tableNames = ['users', 'bookings', 'club_players', 'live_scores', 'merchandise', 'orders', 'tournament_registrations'];

foreach ($tableNames as $tableName) {
    echo "Creating table $tableName...\n";
    $pgsql->exec($tables[$tableName]);
    
    // Fetch from MySQL
    $stmt = $mysql->query("SELECT * FROM `$tableName`");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($rows) > 0) {
        $cols = array_keys($rows[0]);
        $colNames = implode(", ", $cols);
        $placeholders = implode(", ", array_fill(0, count($cols), "?"));
        
        $insertStmt = $pgsql->prepare("INSERT INTO $tableName ($colNames) VALUES ($placeholders)");
        
        $count = 0;
        foreach ($rows as $row) {
            $insertStmt->execute(array_values($row));
            $count++;
        }
        echo "Inserted $count rows into $tableName.\n";
    } else {
        echo "No data in $tableName.\n";
    }
}

// Update the auto-increment sequences so new inserts don't fail with duplicate PK
foreach ($tableNames as $tableName) {
    $pgsql->exec("SELECT setval(pg_get_serial_sequence('$tableName', 'id'), coalesce(max(id)+1, 1), false) FROM $tableName;");
}

echo "\nMigration completed successfully!\n";
?>
