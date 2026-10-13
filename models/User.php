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

    public function tieneAccesoArea($tier_cliente, $area_solicitada) {
        // Mapa de accesos con jerarquía acumulativa
        $permisos = [
            'Bronce'   => ['restaurant'],
            'Plata'    => ['restaurant', 'promociones'],
            'Oro'      => ['restaurant', 'promociones', 'antro'],
            'Diamante' => ['restaurant', 'promociones', 'antro', 'cabaret']
        ];

        // Verificamos si el área solicitada está en el array de permisos de su nivel
        if (isset($permisos[$tier_cliente]) && in_array($area_solicitada, $permisos[$tier_cliente])) {
            return true;
        }
        return false;
    }
}
?>
