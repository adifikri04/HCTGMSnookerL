<?php
require_once 'api/db.php';

try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS tournament_registrations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_uid VARCHAR(255) NOT NULL,
        tournamentName VARCHAR(255) NOT NULL,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        membershipId VARCHAR(100),
        status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_uid) REFERENCES users(uid) ON DELETE CASCADE
    )");
    echo "Table tournament_registrations checked/created successfully.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
