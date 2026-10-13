<?php
require_once 'config/Database.php';

try {
    $db = Database::getInstance()->getConnection();
    
    // Add is_private column to tables
    $db->exec("ALTER TABLE tables ADD COLUMN IF NOT EXISTS is_private BOOLEAN DEFAULT FALSE;");
    
    // Set table #3 as private
    $db->exec("UPDATE tables SET is_private = TRUE WHERE number = 3;");

    // Add socio (miembro VIP) user
    $pass = password_hash('123456', PASSWORD_BCRYPT);
    $db->exec("INSERT INTO users (username, password, role) VALUES ('socio', '$pass', 'miembro') ON CONFLICT (username) DO NOTHING;");

    echo "Database migrations applied successfully.";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
