<?php
require_once 'config/Database.php';
require_once 'models/Reservation.php';
require_once 'models/Table.php';

class ReservationView {
    private $db;
    private $reservation;
    private $table;

    public function __construct() {
        // Here we use the Singleton pattern for DB connection
        $database = Database::getInstance();
        $this->db = $database->getConnection();
        
        $this->reservation = new Reservation($this->db);
        $this->table = new Table($this->db);
    }

    public function handleRequest() {
        $action = isset($_GET['action']) ? $_GET['action'] : 'list';
        
        switch($action) {
            case 'create':
                $this->create();
                break;
            case 'update_status':
                $this->updateStatus();
                break;
            case 'list':
            default:
                $this->list();
                break;
        }
    }

    private function updateStatus() {
        if (isset($_GET['id']) && isset($_GET['status'])) {
            if ($this->reservation->updateStatus($_GET['id'], $_GET['status'])) {
                header("Location: index.php?view=reservation&success=updated");
                exit;
            } else {
                echo "Error al actualizar estado.";
            }
        }
    }

    private function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $table_id = $_POST['table_id'];
            
            // Validar acceso por zona y tier del cliente
            $stmt = $this->db->prepare("SELECT is_private, zone FROM tables WHERE id = :id");
            $stmt->execute([':id' => $table_id]);
            $table_info = $stmt->fetch(PDO::FETCH_ASSOC);
            $zone = $table_info['zone'] ?? 'restaurant';
            $role = $_SESSION['role'] ?? '';
            $tier = $_SESSION['tier'] ?? '';

            // Meseros y admins pueden reservar cualquier zona
            if (!in_array($role, ['mesero', 'admin', 'gerente'])) {
                if ($zone === 'antro' && !in_array($tier, ['oro', 'diamante'])) {
                    header("Location: index.php?view=reservation&error=no_antro");
                    exit;
                }
                if ($zone === 'cabaret' && $tier !== 'diamante') {
                    header("Location: index.php?view=reservation&error=no_cabaret");
                    exit;
                }
            }

            // Validar FECHA NO PASADA
            try {
                $res_date = new DateTime($_POST['reservation_date']);
                $now = new DateTime();
                if ($res_date < $now) {
                    header("Location: index.php?view=reservation&error=past_date");
                    exit;
                }
            } catch (Exception $e) {
                header("Location: index.php?view=reservation&error=past_date");
                exit;
            }

            // Validar QUE NO ESTE OCUPADA ESE MISMO DIA
            $stmt_occ = $this->db->prepare("SELECT COUNT(*) FROM reservations WHERE table_id = :tid AND DATE(reservation_date) = DATE(:rdate) AND status != 'cancelled'");
            $stmt_occ->execute([':tid' => $table_id, ':rdate' => $_POST['reservation_date']]);
            if ($stmt_occ->fetchColumn() > 0) {
                header("Location: index.php?view=reservation&error=table_occupied");
                exit;
            }

            $this->reservation->customer_name = $_POST['customer_name'];
            $this->reservation->customer_email = $_POST['customer_email'];
            $this->reservation->reservation_date = $_POST['reservation_date'];
            $this->reservation->table_id = $table_id;

            if($this->reservation->create()) {
                // Marcar la mesa como ocupada en la bdd
                $this->table->updateStatus($table_id, 'occupied');
                header("Location: index.php?view=reservation&success=1");
            } else {
                echo "Error al crear la reserva.";
            }
        }
    }

    private function list() {
        $reservations = $this->reservation->getAll();
        $tables = $this->table->getAll();
        $all_tables = $this->table->getAllForMap(); // Data for visual maps
        require_once 'templates/home.php';
    }
}
?>
