<?php
require_once __DIR__ . '/../public/api/db.php';

try {
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS ongoing_tournament (
            id SERIAL PRIMARY KEY,
            badge_text VARCHAR(255) NOT NULL,
            title VARCHAR(255) NOT NULL,
            description TEXT NOT NULL,
            stat1_value VARCHAR(255) NOT NULL,
            stat1_label VARCHAR(255) NOT NULL,
            stat2_value VARCHAR(255) NOT NULL,
            stat2_label VARCHAR(255) NOT NULL,
            stat3_value VARCHAR(255) NOT NULL,
            stat3_label VARCHAR(255) NOT NULL,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
    ");
    
    // Check if row exists, if not seed it
    $stmt = $pdo->query("SELECT COUNT(*) FROM ongoing_tournament");
    if ($stmt->fetchColumn() == 0) {
        $pdo->exec("
            INSERT INTO ongoing_tournament (badge_text, title, description, stat1_value, stat1_label, stat2_value, stat2_label, stat3_value, stat3_label)
            VALUES (
                'June Club Championship',
                'Quarter Final Stage',
                'The top sixteen players are fighting for the monthly title. Matches are played race-to-5, alternate break, with live table updates at the club desk.',
                '16', 'Players',
                '5', 'Frames',
                'RM800', 'Prize'
            )
        ");
    }
    
    echo "Table 'ongoing_tournament' created and seeded successfully.\n";
} catch (PDOException $e) {
    die("DB Error: " . $e->getMessage() . "\n");
}
?>
