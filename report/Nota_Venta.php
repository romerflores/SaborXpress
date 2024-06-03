<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/SaborXpress/config/global.php");
require_once(ROOT_DIR . "/model/PedidoModel.php");
require_once(ROOT_DIR . "/core/conexionDB.php"); // Ajusta la ruta según corresponda
include(ROOT_CORE . "/fpdf/fpdf.php");

// Definir constantes y configuraciones
define('BOLIVIANOS', 'Bs.'); // Constante con el símbolo de Bolivianos

// Instanciar la conexión
$con = new ConexionBD();
$mysqli = $con->conexion();

// Verificar la conexión
if ($mysqli->connect_errno) {
    echo "Error al conectar a MySQL: " . $mysqli->connect_error;
    exit();
}

// Verificar si id_venta está presente en la URL
if (!isset($_GET['id_venta'])) {
    echo "ID de venta no especificado.";
    exit();
}

$id_venta = $_GET['id_venta'];

// Consulta para obtener los detalles de la venta
$query = "SELECT v.id_venta, v.fecha_venta, v.total_venta, c.nombre AS cliente_nombre
        FROM venta v
        JOIN cliente c ON v.cliente_id_cliente = c.id_cliente
        WHERE v.id_venta = ?";

// Usar prepared statement para ejecutar la consulta
$stmt = $mysqli->prepare($query);
$stmt->bind_param('i', $id_venta);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $venta = $result->fetch_assoc();
} else {
    echo "No se encontró la venta.";
    exit();
}

// Crear el PDF
$pdf = new FPDF('P', 'mm', 'A4'); // Tamaño A4
$pdf->AddPage();

// CABECERA
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(190, 10, 'NOTA DE VENTA', 0, 1, 'C');

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(130, 7, 'ID Venta: ' . $venta['id_venta'], 0, 0);
$pdf->Cell(60, 7, 'Fecha: ' . $venta['fecha_venta'], 0, 1);

$pdf->Cell(130, 7, 'Cliente: ' . $venta['cliente_nombre'], 0, 0);
$pdf->Cell(60, 7, 'Total: ' . number_format($venta['total_venta'], 2) . ' ' . BOLIVIANOS, 0, 1);

$pdf->Ln(10);

// DETALLES DE LA VENTA
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(190, 10, 'Detalles de la Venta', 0, 1);

// Encabezados de columnas
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(40, 10, 'Producto', 1, 0, 'C');
$pdf->Cell(40, 10, 'Cantidad', 1, 0, 'C');
$pdf->Cell(40, 10, 'Precio Unitario', 1, 0, 'C');
$pdf->Cell(40, 10, 'Subtotal', 1, 1, 'C');

// Consulta para obtener los productos de la venta
$query_detalle = "SELECT ";


$stmt_detalle = $mysqli->prepare($query_detalle);
$stmt_detalle->bind_param('i', $id_venta);
$stmt_detalle->execute();
$result_detalle = $stmt_detalle->get_result();

// Mostrar detalles de la venta
$pdf->SetFont('Arial', '', 10);
while ($row = $result_detalle->fetch_assoc()) {
    $pdf->Cell(40, 10, $row['producto'], 1, 0, 'C');
    $pdf->Cell(40, 10, $row['cantidad'], 1, 0, 'C');
    $pdf->Cell(40, 10, number_format($row['precio_unitario'], 2) . ' ' . BOLIVIANOS, 1, 0, 'C');
    $pdf->Cell(40, 10, number_format($row['subtotal'], 2) . ' ' . BOLIVIANOS, 1, 1, 'C');
}

$pdf->Output('nota_venta.pdf', 'I');
?>
