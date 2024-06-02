<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/SaborXpress/config/global.php");
require_once(ROOT_DIR . "/model/ClienteModel.php");
include(ROOT_CORE . "/fpdf/fpdf.php");

define('BOLIVIANOS', 'Bs.'); // Constante con el símbolo de Bolivianos

$pdf = new FPDF('P', 'mm', array(80, 150)); // Tamaño ticket 80mm x 150 mm (largo aprox)

// Agregar una página antes de añadir contenido
$pdf->AddPage();

// CABECERA
$pdf->SetFont('Helvetica', 'B', 12);
$pdf->Cell(60, 4, 'Cierre de Caja', 0, 1, 'C');
$pdf->SetFont('Helvetica', '', 8);
$pdf->Cell(60, 4, 'SaborXpress', 0, 1, 'C');
$pdf->Cell(60, 4, 'Av. Portugal Z. Rectangular #345', 0, 1, 'C');
$pdf->Cell(60, 4, 'Cel. 69904901', 0, 1, 'C');
$pdf->Cell(60, 4, 'SaborXpressS.A.@gmail.com', 0, 1, 'C');

// Configurar la zona horaria adecuada para Bolivia
date_default_timezone_set('America/La_Paz');
$currentDate = date('d/m/Y');
$currentTime = date('H:i:s');

// Agregar fecha y hora actual
$pdf->Ln(1);
$pdf->SetFont('Helvetica', 'B', 7);
$pdf->Cell(60, 4, "Fecha Impresion: $currentDate  $currentTime", 0, 1, 'C');

// COLUMNAS
$pdf->SetFont('Helvetica', '', 7);
$pdf->Ln(2);
$pdf->Cell(25, 10, 'MONTO INICIAL', 0);    
$pdf->Cell(20, 10, '', 0);
$pdf->Cell(15, 10, number_format(round((round(12.25, 2) / 1.21), 2), 2, ',', ' ') . BOLIVIANOS, 0, 0, 'R');
$pdf->Ln(3);    
$pdf->Cell(25, 10, 'MONTO FINAL', 0);    
$pdf->Cell(20, 10, '', 0);
$pdf->Cell(15, 10, number_format(round((round(12.25, 2)), 2) - round((round(2 * 3, 2) / 1.21), 2), 2, ',', ' ') . BOLIVIANOS, 0, 0, 'R');
$pdf->Ln(3);
$pdf->Cell(25, 10, 'FECHA HORA INICIAL', 0);    
$pdf->Cell(20, 10, '', 0);
$pdf->Cell(15, 10, number_format(round((round(12.25, 2)), 2) - round((round(2 * 3, 2) / 1.21), 2), 2, ',', ' ') . BOLIVIANOS, 0, 0, 'R');
$pdf->Ln(3);
$pdf->Cell(25, 10, 'FECHA HORA CIERRE', 0);    
$pdf->Cell(20, 10, '', 0);
$pdf->Cell(15, 10, number_format(round((round(12.25, 2)), 2) - round((round(2 * 3, 2) / 1.21), 2), 2, ',', ' ') . BOLIVIANOS, 0, 0, 'R');
$pdf->Ln(3);
$pdf->Cell(25, 10, 'TOTAL', 0);    
$pdf->Cell(20, 10, '', 0);
$pdf->Cell(15, 10, number_format(round(12.25, 2), 2, ',', ' ') . BOLIVIANOS, 0, 0, 'R');


$pdf->Ln(22);
//FIRMAS ADMIN
$pdf->Cell(60, 0, '', 'T');
$pdf->Ln(3);
$pdf->Cell(60, 4, "FIRMA CAJERO", 0, 1, 'C');

$pdf->Ln(8);
$pdf->Cell(60, 0, '', 'T');
$pdf->Ln(3);
$pdf->Cell(60, 4, "FIRMA ADMIN", 0, 1, 'C');


// PIE DE PAGINA
$pdf->Ln(10);
$texto = '"UNA VEZ DECLARADO SU CIERRE DE CAJA NO SE PUEDE ADICIONAR MAS DINERO"';
$pdf->SetFont('Arial', '', 6); // Puedes ajustar el tamaño de la fuente según sea necesario
$pdf->MultiCell(60, 4, $texto, 0, 'C');


$pdf->Output('ticket.pdf', 'I');
?>
