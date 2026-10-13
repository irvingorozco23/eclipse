<?php
// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Variables globales basadas en la sesión
$userRole = $_SESSION['role'] ?? 'cliente'; // Por defecto cliente si no hay rol
$userTier = $_SESSION['tier'] ?? '';
$isMesero = ($userRole === 'mesero' || $userRole === 'admin');
$username = $_SESSION['username'] ?? 'Invitado';

// 1. Cargar el diseño principal (CSS y Barra de navegación)
include 'templates/header.php';

// 2. Cargar el contenido central dependiendo del rol del usuario
if ($userRole === 'admin' || $userRole === 'gerente') {
    // Si tienes una vista para admin, inclúyela aquí. Por ahora mostraremos el mapa.
    include 'templates/mesero_mapa.php'; 
} elseif ($userRole === 'mesero') {
    include 'templates/mesero_mapa.php';
} else {
    include 'templates/cliente_dashboard.php';
}

// 3. Cierre de la página
include 'templates/footer.php';
?>