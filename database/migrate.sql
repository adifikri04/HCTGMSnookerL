USE hctgmsnooker;

CREATE TABLE IF NOT EXISTS merchandise (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    stock INT DEFAULT 0,
    image_url VARCHAR(500),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS club_players (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255),
    level ENUM('Beginner','Intermediate','Advanced','Professional') DEFAULT 'Beginner',
    wins INT DEFAULT 0,
    tournaments_played INT DEFAULT 0,
    points INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Add some sample players
INSERT IGNORE INTO club_players (id, name, email, level, wins, tournaments_played, points) VALUES
(1, 'Marcus Chen', 'marcus@example.com', 'Professional', 8, 12, 892100),
(2, 'David Thompson', 'david@example.com', 'Professional', 6, 18, 412500),
(3, 'Simon Thorne', 'simon@example.com', 'Advanced', 4, 15, 398000),
(4, 'Viktor Petrov', 'viktor@example.com', 'Advanced', 5, 20, 345900),
(5, 'James Harrison', 'james@example.com', 'Advanced', 4, 17, 312200);

-- Add some sample merchandise
INSERT IGNORE INTO merchandise (id, name, description, price, stock) VALUES
(1, 'HC TGM Cue Chalk', 'Professional grade billiard chalk for maximum spin control.', 8.00, 50),
(2, 'Club Polo Shirt', 'Official HC TGM Snooker Club embroidered polo shirt.', 45.00, 30),
(3, 'Cue Tip Kit', 'Complete tip replacement kit with glue and shaper.', 15.00, 25);
