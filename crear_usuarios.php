<?php
require_once 'config/Database.php';

try {
    $db = Database::getInstance()->getConnection();
    
    $sql = "
    CREATE TABLE IF NOT EXISTS users (
        id SERIAL PRIMARY KEY,
        username VARCHAR(50) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        role VARCHAR(20) DEFAULT 'admin',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );
    ";
    $db->exec($sql);

    // Contraseña inicial 'admin123'
    $hashedPassword = password_hash('admin123', PASSWORD_BCRYPT);

    $sqlInsert = "
    INSERT INTO users (username, password, role) 
    VALUES ('admin', :password, 'admin') 
    ON CONFLICT (username) DO NOTHING;
    ";
    
    $stmt = $db->prepare($sqlInsert);
    $stmt->execute([':password' => $hashedPassword]);
    
    echo "¡Tabla 'users' creada exitosamente y usuario administrador insertado!\n";
    echo "Usuario: admin\n";
    echo "Contraseña: admin123\n";

} catch (Exception $e) {
    echo "Error al crear la tabla: " . $e->getMessage();
}
