<?php
require_once 'config/Database.php';
require_once 'models/User.php';

// Definimos el Controlador para ver que sigue el patrón Arquitectónico
class UserController {
    private $db;
    private $userModel;

    public function __construct() {
        // AQUÍ ES DONDE ACTÚA EL PATRÓN SINGLETON
        // En vez de hacer: $db = new Database(); (lo cual abre múltiples conexiones por request)
        // Solicitamos la única instancia global compartida:
        $database = Database::getInstance();
        $this->db = $database->getConnection();
        
        // Inyectamos la conexión compartida en nuestro modelo Usuario
        $this->userModel = new User($this->db);
    }

    public function showUsers() {
        // El controlador le pide los datos al Modelo
        $users = $this->userModel->getAll();
        
        // El controlador carga la Vista para mostrar los datos
        require_once 'views/users_list.php';
    }
}

// Ejecutamos el flujo
try {
    $controller = new UserController();
    $controller->showUsers();
} catch (Exception $e) {
    // Si el Singleton falló al conectar (ej. BD caída), lo atrapamos
    echo "Error crítico: " . $e->getMessage();
}
?>
