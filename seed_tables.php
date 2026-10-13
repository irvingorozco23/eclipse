<?php
require_once 'config/Database.php';

$db = Database::getInstance()->getConnection();

try {
    // Insertamos hasta 40 mesas para tener suficiente para las vistas (Restaurante y VIP)
    for ($i = 4; $i <= 40; $i++) {
        $capacity = rand(2, 8);
        $stmt = $db->prepare("INSERT INTO tables (number, capacity) VALUES (:n, :c) ON CONFLICT DO NOTHING");
        $stmt->execute([':n' => $i, ':c' => $capacity]);
    }
    
    // Configurar zonas VIP (ej. Mesa 20 a 30) para el cabaret/sotano
    $db->prepare("ALTER TABLE tables ADD COLUMN IF NOT EXISTS is_private BOOLEAN DEFAULT FALSE")->execute();
    $db->prepare("UPDATE tables SET is_private = TRUE WHERE number >= 25")->execute();

    echo "Tables seeded successfully.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
