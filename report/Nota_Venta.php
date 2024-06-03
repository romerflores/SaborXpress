<?php
include(ROOT_CORE . "/fpdf/fpdf.php");

// Definir constantes y configuraciones
define('BOLIVIANOS', 'Bs.'); // Constante con el símbolo de Bolivianos


$nro_venta = $_GET['nro_venta'];

$nro_venta = $_GET['nro_venta']??'';
if ($nro_venta) {
    // Preparar la URL para obtener los detalles del producto
    $url = HTTP_BASE . "/controller/Nota_VentaController.php?ope=filterId&nro_venta=" . $nro_venta;

    // Obtener detalles del producto
    $response = file_get_contents($url);
    $responseData = json_decode($response, true);
    // Validar si se encontró el producto y si la clave 'nro_venta' está definida
    if ($responseData && $responseData['ESTADO'] == 1 && !empty($responseData['DATA'])) {
        $venta = $responseData['DATA'];
    } else {
        $venta = null;
    }
}


// Crear el PDF
$pdf = new FPDF('P', 'mm', 'A4'); // Tamaño A4
$pdf->AddPage();


// CABECERA
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(190, 10, 'NOTA DE VENTA', 0, 1, 'C');
// Encabezado
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(190, 10, 'SaborXpress', 0, 1, 'C'); // Nombre de la empresa
$pdf->SetFont('Arial', '', 12);
// Definición de la función convertxt()
function convertxt($text, $x, $y) {
    // Código para convertir el texto según sea necesario
}

// Llamada a la función convertxt()
convertxt("Fecha de Emisión: " . ($venta[0]['fecha_venta']), 0, 1);





$pdf->SetFont('Arial', '', 12);
$pdf->Cell(130, 7, 'ID Venta: ' . $venta[0]['nro_venta'], 0, 0);
$pdf->Cell(60, 7, 'Fecha: ' . $venta[0]['fecha_venta'], 0, 1); // Cambiado a fecha_venta
$pdf->Cell(60, 7, 'Hora: ' . $venta[0]['hora_venta'], 0, 1);

$pdf->Cell(130, 7, 'Razon Social: ' . $venta[0]['razon_social'], 0, 0);
$pdf->Cell(130, 7, 'CI/NIT/CEX: ' . $venta[0]['usuario_ci_usuario'], 0, 1);

$pdf->Cell(130, 7, 'TOTAL VENTA: ' . $venta[0]['total']." Bs", 0, 1);



$pdf->Ln(10);

// DETALLES DE LA VENTA
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(190, 10, 'Detalles de la Venta', 0, 1);

// Encabezados de columnas
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(80, 10, 'Producto', 1, 0, 'C');
$pdf->Cell(30, 10, 'Cantidad', 1, 0, 'C');
$pdf->Cell(30, 10, 'Precio Unitario', 1, 0, 'C');
$pdf->Cell(30, 10, 'Subtotal', 1, 1, 'C');


// Mostrar detalles de la venta
$pdf->SetFont('Arial', '', 10);
foreach ($venta as $row) {
    $pdf->Cell(80, 10, $row['descripcion_producto'], 1, 0, 'C');
    $pdf->Cell(30, 10, $row['cantidad'], 1, 0, 'C');
    $pdf->Cell(30, 10, number_format($row['precio_producto'], 2) . ' ' . BOLIVIANOS, 1, 0, 'C');
    $pdf->Cell(30, 10, number_format($row['sub_total'], 2) . ' ' . BOLIVIANOS, 1, 1, 'C');
}

$pdf->Output('nota_venta.pdf', 'I');
?>
