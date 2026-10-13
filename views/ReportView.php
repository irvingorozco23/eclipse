<?php
require_once 'config/Database.php';

class ReportView {
    private $db;

    public function __construct() {
        $database = Database::getInstance();
        $this->db = $database->getConnection();
    }

    public function handleRequest() {
        // Validation: Only admin or gerente can view reports
        if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'gerente')) {
            echo "Acceso denegado. No tienes permisos para ver reportes.";
            exit;
        }

        $action = isset($_GET['action']) ? $_GET['action'] : 'view';
        
        switch($action) {
            case 'download':
                $this->downloadPDF();
                break;
            case 'view':
            default:
                $this->viewReports();
                break;
        }
    }

    private function viewReports() {
        // Query 1: Total Reservations
        $stmt1 = $this->db->query("SELECT COUNT(*) as total FROM reservations");
        $totalReservations = $stmt1->fetchColumn();

        // Query 2: Reservations by Status
        $stmt2 = $this->db->query("SELECT status, COUNT(*) as count FROM reservations GROUP BY status");
        $statusCounts = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        // Query 3: Most used Tables
        $stmt3 = $this->db->query("
            SELECT t.number, COUNT(r.id) as used_count 
            FROM tables t 
            LEFT JOIN reservations r ON t.id = r.table_id 
            GROUP BY t.number 
            ORDER BY used_count DESC 
            LIMIT 5
        ");
        $topTables = $stmt3->fetchAll(PDO::FETCH_ASSOC);

        require_once 'templates/reports.php';
    }

    private function downloadPDF() {
        require_once 'libs/tfpdf/tfpdf.php';

        // Query 1: Total Reservations
        $stmt1 = $this->db->query("SELECT COUNT(*) as total FROM reservations");
        $totalReservations = $stmt1->fetchColumn();

        // Query 2: Reservations by Status
        $stmt2 = $this->db->query("SELECT status, COUNT(*) as count FROM reservations GROUP BY status");
        $statusCounts = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        // Query 3: Most used Tables
        $stmt3 = $this->db->query("
            SELECT t.number, COUNT(r.id) as used_count 
            FROM tables t 
            LEFT JOIN reservations r ON t.id = r.table_id 
            GROUP BY t.number 
            ORDER BY used_count DESC 
            LIMIT 5
        ");
        $topTables = $stmt3->fetchAll(PDO::FETCH_ASSOC);

        $pdf = new tFPDF();
        $pdf->AddPage();

        // Check if Font exists to avoid fatal error, otherwise use standard Arial
        if (file_exists('libs/tfpdf/font/unifont/DejaVuSansCondensed.ttf')) {
            $pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
            $pdf->AddFont('DejaVu','B','DejaVuSansCondensed-Bold.ttf',true);
            $font = 'DejaVu';
        } else {
            $font = 'Arial';
        }

        // Title
        $pdf->SetFont($font, 'B', 20);
        $pdf->Cell(0, 15, "Reporte Administrativo - L'Éclipse", 0, 1, 'C');
        $pdf->Ln(5);

        // General Stats
        $pdf->SetFont($font, 'B', 14);
        $pdf->Cell(0, 10, "Resumen General", 0, 1);
        $pdf->SetFont($font, '', 12);
        $pdf->Cell(0, 10, "Total de Reservas Históricas: " . $totalReservations, 0, 1);
        $pdf->Ln(5);

        // Status Breakdown
        $pdf->SetFont($font, 'B', 14);
        $pdf->Cell(0, 10, "Estado de Reservas", 0, 1);
        $pdf->SetFont($font, '', 12);
        foreach ($statusCounts as $statusRow) {
            $pdf->Cell(0, 10, "- " . ucfirst($statusRow['status']) . ": " . $statusRow['count'], 0, 1);
        }
        $pdf->Ln(5);

        // Top Tables
        $pdf->SetFont($font, 'B', 14);
        $pdf->Cell(0, 10, "Áreas Más Solicitadas", 0, 1);
        $pdf->SetFont($font, 'B', 12);
        $pdf->Cell(90, 10, "Área / Número de Mesa", 1, 0, 'C');
        $pdf->Cell(90, 10, "Frecuencia de Uso", 1, 1, 'C');
        
        $pdf->SetFont($font, '', 12);
        foreach ($topTables as $table) {
            $pdf->Cell(90, 10, "Área VIP #" . $table['number'], 1, 0, 'C');
            $pdf->Cell(90, 10, $table['used_count'] . " reservaciones", 1, 1, 'C');
        }

        // Output and force download
        $pdf->Output('D', 'Reporte_Reservas_LEclipse.pdf');
        exit;
    }
}
?>
