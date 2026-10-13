<?php
require_once 'config/Database.php';

class AuthView {
    private $db;

    public function __construct() {
        $database = Database::getInstance();
        $this->db = $database->getConnection();
    }

    public function handleRequest() {
        $action = isset($_GET['action']) ? $_GET['action'] : 'login';
        
        switch($action) {
            case 'authenticate':
                $this->authenticate();
                break;
            case 'logout':
                $this->logout();
                break;
            case 'login':
            default:
                $this->showLogin();
                break;
        }
    }

    private function showLogin() {
        require_once 'templates/login.php';
    }

    private function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->execute([':username' => $username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['tier'] = $user['tier'] ?? null;
                
                header("Location: index.php?view=reservation&action=list");
                exit;
            } else {
                header("Location: index.php?view=auth&action=login&error=1");
                exit;
            }
        }
    }

    private function logout() {
        session_destroy();
        header("Location: index.php?view=auth&action=login");
        exit;
    }
}
?>
