<?php
class Reservation {
    private $conn;
    private $table_name = "reservations";

    public $id;
    public $customer_name;
    public $customer_email;
    public $reservation_date;
    public $table_id;
    public $status;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  (customer_name, customer_email, reservation_date, table_id) 
                  VALUES (:customer_name, :customer_email, :reservation_date, :table_id)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':customer_name', $this->customer_name);
        $stmt->bindParam(':customer_email', $this->customer_email);
        $stmt->bindParam(':reservation_date', $this->reservation_date);
        $stmt->bindParam(':table_id', $this->table_id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getAll() {
        $query = "SELECT r.*, t.number as table_number FROM " . $this->table_name . " r
                  LEFT JOIN tables t ON r.table_id = t.id
                  ORDER BY r.reservation_date DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function updateStatus($id, $new_status) {
        $query = "UPDATE " . $this->table_name . " SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $new_status);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
