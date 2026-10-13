<?php
session_start();

require_once 'views/ReservationView.php';
require_once 'views/AuthView.php';
require_once 'views/ReportView.php';

try {
    $viewName = isset($_GET['view']) ? $_GET['view'] : 'reservation';
    $action = isset($_GET['action']) ? $_GET['action'] : 'list';

    // Session validation
    if (!isset($_SESSION['user_id'])) {
        // Only allow auth views if not logged in
        if ($viewName !== 'auth') {
            header("Location: index.php?view=auth&action=login");
            exit;
        }
    }

    if ($viewName === 'auth') {
        $view = new AuthView();
        $view->handleRequest();
    } elseif ($viewName === 'reservation') {
        $view = new ReservationView();
        $view->handleRequest();
    } elseif ($viewName === 'report') {
        $view = new ReportView();
        $view->handleRequest();
    } else {
        echo "View not found.";
    }

} catch (Exception $e) {
    // Si hay un error de conexión, mostrar la vista del test de la BD
    $status = 'error';
    $message = $e->getMessage();
    require_once 'views/test_db.php';
}
?>
