<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/SaborXpress/config/global.php");
require_once(ROOT_DIR . "/model/Detalle_CajaModel.php");
include(ROOT_CORE . "/fpdf/fpdf.php");

class PDF extends FPDF {
    function convertxt($p_txt) {
        return iconv('UTF-8', 'ISO-8859-1', $p_txt);
    }

    function Header() {
        $this->SetFont('Arial', 'B', 20);
        $this->Cell(0, 20, "Reporte Cierre de Caja", 0, 1, 'C');

        $currentDate = date('d/m/Y');
        $currentTime = date('H:i:s');
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(0, 8, $this->convertxt("Fecha: $currentDate Hora: $currentTime"), 0, 3, 'R');
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(0, 11, $this->convertxt("Página ") . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

// Configurar la zona horaria adecuada para Bolivia
date_default_timezone_set('America/La_Paz');

$rpt = new Detalle_Caja();
$records = $rpt->findAll();
$records = $records['DATA'];

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

// Cabecera
$pdf->SetFont('Courier', 'B', 11);
$header = array(
    $pdf->convertxt("ID"),
    $pdf->convertxt("Monto Inicial"),
    $pdf->convertxt("Monto Final"),

);
$widths = array(10, 15, 13, 12, 15, 15);  // Ajustar los anchos de las celdas si es necesario

for ($i = 0; $i < count($header); $i++) {
    $pdf->Cell($widths[$i], 10, $header[$i], 1);
}
$pdf->Ln();

// Cuerpo
$pdf->SetFont('Arial', '', 1.5);

foreach ($records as $row) {
    $pdf->Cell($widths[0], 3, $pdf->convertxt($row['id_caja']), 1);
    $pdf->Cell($widths[1], 3, $pdf->convertxt($row['monto_inicio']), 1);
    $pdf->Cell($widths[2], 3, $pdf->convertxt($row['monto_final']), 1);

    $pdf->Ln();
}

$pdf->Output();
?>
