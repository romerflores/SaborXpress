<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/pollosCristians/config/global.php");
require_once(ROOT_DIR . "/model/ClienteModel.php");
include(ROOT_CORE . "/fpdf/fpdf.php");

class PDF extends FPDF {
    function convertxt($p_txt) {
        return iconv('UTF-8', 'iso-8859-1', $p_txt);
    }

    function Header() {
        $this->SetFont('Arial', 'B', 20);
        $this->Cell(0, 20, "Reporte de Clientes", 0, 1, 'C');
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, $this->convertxt("Página ") . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

$rpt = new ClienteModel();
$records = $rpt->findall();
$records = $records['DATA'];

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

// Cabecera
$pdf->SetFont('Arial', 'B', 12);
$header = array($pdf->convertxt("IdCliente"), $pdf->convertxt("Nombre"));
$widths = array(40, 60);  // Ajustar los anchos de las celdas si es necesario

for ($i = 0; $i < count($header); $i++) {
    $pdf->Cell($widths[$i], 7, $header[$i], 1);
}
$pdf->Ln();

// Cuerpo
$pdf->SetFont('Arial', '', 12);

foreach ($records as $row) {
    $pdf->Cell($widths[0], 6, $pdf->convertxt($row['id_cliente']), 1);
    $pdf->Cell($widths[1], 6, $pdf->convertxt($row['nombre']), 1);
    $pdf->Ln();
}

$pdf->Output();
?>
