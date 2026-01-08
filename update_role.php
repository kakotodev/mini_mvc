<?php
require __DIR__ . '/vendor/autoload.php';

use Mini\Core\Database;

try {
    $pdo = Database::getPDO();
    echo "Connected to database.\n";

    // 1. Check/Add 'role' column
    $stmt = $pdo->prepare("SHOW COLUMNS FROM user LIKE 'role'");
    $stmt->execute();
    if (!$stmt->fetch()) {
        echo "Adding column 'role'...\n";
        $pdo->exec("ALTER TABLE user ADD COLUMN role VARCHAR(50) DEFAULT 'Membre'");
        echo "Column 'role' added.\n";
    } else {
        echo "Column 'role' already exists.\n";
    }

    // 2. Update Admin User (ID 16)
    $stmt = $pdo->prepare("UPDATE user SET role = 'Admin', nom = 'admin', email = 'admin@admin.com' WHERE id = 16");
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        echo "User ID 16 updated to Admin.\n";
    } else {
        echo "User ID 16 not found or already is Admin.\n";
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
