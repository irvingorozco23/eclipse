<?php
class User {
    private $conn;
    private $table_name = "users";

    public $id;
    public $username;
    public $password;
    public $role;
    public $created_at;

    // Se inyecta la conexión (que viene del Singleton) al inicializar el Modelo
    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para obtener todos los usuarios
    public function getAll() {
        $query = "SELECT id, username, password, role, created_at FROM " . $this->table_name . " ORDER BY id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }
}
?>
