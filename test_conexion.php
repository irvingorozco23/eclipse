<?php
require_once 'config/Database.php';

$status = null;
$message = null;

try {
    // Intentar obtener la instancia, lo cual intentará conectar a la BD
    $database = Database::getInstance();
    $conn = $database->getConnection();
    
    if ($conn) {
        $status = 'success';
        $message = '¡Conectado exitosamente a la base de datos PostgreSQL!';
    }
} catch (Exception $e) {
    $status = 'error';
    $message = $e->getMessage();
}

require_once 'views/test_db.php';
