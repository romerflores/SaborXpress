<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/SaborXpress/config/global.php");
require_once(ROOT_DIR . "/model/Nota_VentaModel.php");
require_once(ROOT_DIR . "/model/UsuarioModel.php");
require_once(ROOT_DIR . "/model/ProductoModel.php");
include(ROOT_CORE . "/fpdf/fpdf.php");

class PDF extends FPDF {
    function convertxt($p_txt) {
        return iconv('UTF-8', 'ISO-8859-1', $p_txt);
    }

    function Header() {
        $this->SetFont('Arial', 'B', 20);
        $this->Cell(0, 20, "Reporte Notas de Venta - Casa Matriz", 0, 1, 'C');

        $currentDate = date('d/m/Y');
        $currentTime = date('H:i:s');
        $this->SetFont('Arial', '', 11);
        $this->Cell(0, 8, $this->convertxt("Fecha de impresion: $currentDate $currentTime"), 0, 3, 'C');
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(0, 11, $this->convertxt("Página ") . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

// Configurar la zona horaria adecuada para Bolivia
date_default_timezone_set('America/La_Paz');

$rpt = new Nota_VentaModel();
$records = $rpt->findAll();
$records = $records['DATA'];

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

// Cabecera
$pdf->SetFont('helvetica', 'B', 10);
$header = array($pdf->convertxt("Nro Venta"), $pdf->convertxt("Fecha Venta"), $pdf->convertxt("Hora Venta"), $pdf->convertxt("Total"), $pdf->convertxt("ID Cliente"), $pdf->convertxt("CI Usuario"));
$widths = array(28, 30, 30, 30, 35, 30);  // Ajustar los anchos de las celdas si es necesario

// Estilo para la cabecera
$pdf->SetFillColor(173, 216, 230); // Color azul claro de fondo
$pdf->SetTextColor(0, 0, 0); // Color azul nítido para el texto
$pdf->SetDrawColor(0); // Color del borde (negro)

for ($i = 0; $i < count($header); $i++) {
    $pdf->Cell($widths[$i], 6, $header[$i], 1, 0, 'C', true);
}
$pdf->Ln();

// Cuerpo
$pdf->SetFont('Arial', '', 10);
$pdf->SetFillColor(224, 235, 255); // Color de fondo para las filas
$pdf->SetTextColor(0); // Color del texto (negro)
$fill = false; // Alternar el color de fondo

foreach ($records as $row) {
    $pdf->Cell($widths[0], 6, $pdf->convertxt($row['nro_venta']), 1, 0, 'C', $fill);
    $pdf->Cell($widths[1], 6, $pdf->convertxt($row['fecha_venta']), 1, 0, 'C', $fill);
    $pdf->Cell($widths[2], 6, $pdf->convertxt($row['hora_venta']), 1, 0, 'C', $fill);
    $pdf->Cell($widths[3], 6, $pdf->convertxt($row['total']), 1, 0, 'C', $fill);
    $pdf->Cell($widths[4], 6, $pdf->convertxt($row['cliente_id_cliente']), 1, 0, 'C', $fill);
    $pdf->Cell($widths[5], 6, $pdf->convertxt($row['usuario_ci_usuario']), 1, 0, 'C', $fill);
    $pdf->Ln();
    $fill = !$fill; // Alternar el color de fondo
}
$pdf->Output();
?>