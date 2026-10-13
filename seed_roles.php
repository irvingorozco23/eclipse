<?php
require_once 'config/Database.php';

try {
    $db = Database::getInstance()->getConnection();
    
    $pass = password_hash('123456', PASSWORD_BCRYPT);
    $queries = [
        "INSERT INTO users (username, password, role) VALUES ('admin2', '$pass', 'admin') ON CONFLICT (username) DO NOTHING;",
        "INSERT INTO users (username, password, role) VALUES ('recepcion', '$pass', 'recepcionista') ON CONFLICT (username) DO NOTHING;",
        "INSERT INTO users (username, password, role) VALUES ('mesero1', '$pass', 'mesero') ON CONFLICT (username) DO NOTHING;",
        "INSERT INTO users (username, password, role) VALUES ('gerente', '$pass', 'gerente') ON CONFLICT (username) DO NOTHING;"
    ];

    foreach ($queries as $q) {
        $db->exec($q);
    }
    echo "Usuarios creados correctamente con password '123456'.\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
