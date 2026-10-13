<?php
require_once 'config/Database.php';
$db = Database::getInstance()->getConnection();

try {
    // 1. Agregar columna 'tier' a users
    $db->exec("ALTER TABLE users ADD COLUMN IF NOT EXISTS tier VARCHAR(20) DEFAULT NULL");
    
    // 2. Agregar columna 'zone' a tables  (restaurant, antro, cabaret)
    $db->exec("ALTER TABLE tables ADD COLUMN IF NOT EXISTS zone VARCHAR(20) DEFAULT 'restaurant'");
    
    // 3. Asignar zonas a mesas existentes
    // Mesas 1-24: restaurant (normal)
    $db->exec("UPDATE tables SET zone = 'restaurant' WHERE number < 25");
    // Mesas 25-32: antro (sótano disco)
    $db->exec("UPDATE tables SET zone = 'antro' WHERE number >= 25 AND number <= 32");
    // Mesas 33-40: cabaret (2do piso cabaret privado)
    $db->exec("UPDATE tables SET zone = 'cabaret' WHERE number >= 33");
    
    // 4. Actualizar cliente existente con tier bronce
    $db->exec("UPDATE users SET tier = 'bronce' WHERE username = 'cliente'");
    
    // 5. Crear 3 clientes nuevos
    $pwd_plata    = password_hash('plata123', PASSWORD_DEFAULT);
    $pwd_oro      = password_hash('oro123', PASSWORD_DEFAULT);
    $pwd_diamante = password_hash('diamante123', PASSWORD_DEFAULT);
    
    $stmt = $db->prepare("INSERT INTO users (username, password, role, tier) VALUES (?, ?, 'cliente', ?) ON CONFLICT (username) DO UPDATE SET password=EXCLUDED.password, tier=EXCLUDED.tier");
    $stmt->execute(['cliente_plata',    $pwd_plata,    'plata']);
    $stmt->execute(['cliente_oro',      $pwd_oro,      'oro']);
    $stmt->execute(['cliente_diamante', $pwd_diamante, 'diamante']);
    
    echo "=== Seed completado ===\n";
    echo "Usuarios creados/actualizados:\n";
    echo "  cliente          -> tier: bronce   (pw: cliente123)   -> Acceso: Restaurante\n";
    echo "  cliente_plata    -> tier: plata    (pw: plata123)     -> Acceso: Restaurante + Promos\n";
    echo "  cliente_oro      -> tier: oro      (pw: oro123)       -> Acceso: Restaurante + Antro\n";
    echo "  cliente_diamante -> tier: diamante (pw: diamante123)  -> Acceso: Restaurante + Cabaret\n";
    echo "\nZonas de mesas:\n";
    echo "  Mesas 1-24:  restaurant\n";
    echo "  Mesas 25-32: antro\n";
    echo "  Mesas 33-40: cabaret\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
