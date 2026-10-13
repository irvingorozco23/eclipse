<?php
require_once 'config/Database.php';
$db = Database::getInstance()->getConnection();
$pwd = password_hash('cliente123', PASSWORD_DEFAULT);
$stmt = $db->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?) ON CONFLICT (username) DO UPDATE SET password=EXCLUDED.password, role=EXCLUDED.role");
$stmt->execute(['cliente', $pwd, 'cliente']);
echo 'Usuario cliente insertado exitosamente con pw cliente123.';
?>
