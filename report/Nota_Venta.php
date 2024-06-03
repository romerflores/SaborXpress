<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/SaborXpress/config/global.php");
require_once(ROOT_DIR . "/model/Nota_VentaModel.php");
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
$query = "SELECT nv.nro_venta, nv.fecha_venta, nv.hora_venta, nv.total,
c.razon_social AS cliente_nombre,
GROUP_CONCAT(CONCAT(p.descripcion_producto, ' (', pe.cantidad, ' x ', p.precio_producto, ' ', 'Bs.)') SEPARATOR ', ') AS productos
FROM nota_venta nv
JOIN cliente c ON nv.cliente_id_cliente = c.id_cliente
JOIN pedido pe ON pe.nota_venta_nro_venta = nv.nro_venta
JOIN producto p ON pe.producto_id_producto = p.id_producto
WHERE nv.nro_venta = ?";

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
// Encabezado
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(190, 10, 'SaborXpress', 0, 1, 'C'); // Nombre de la empresa
$pdf->SetFont('Arial', '', 12);
// Definición de la función convertxt()
function convertxt($text, $x, $y) {
    // Código para convertir el texto según sea necesario
}

// Llamada a la función convertxt()
convertxt("Fecha de Emisión: " . ($venta['fecha_venta']), 0, 1);





$pdf->SetFont('Arial', '', 12);
$pdf->Cell(130, 7, 'ID Venta: ' . $venta['nro_venta'], 0, 0);
$pdf->Cell(60, 7, 'Fecha: ' . $venta['fecha_venta'], 0, 1); // Cambiado a fecha_venta

$pdf->Cell(130, 7, 'Cliente: ' . $venta['cliente_nombre'], 0, 0);
$pdf->Cell(60, 7, 'Total: ' . number_format($venta['total'], 2) . ' ' . BOLIVIANOS, 0, 1); // Cambiado a total


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
$query_detalle = "SELECT p.descripcion_producto AS producto, pe.cantidad, p.precio_producto AS precio_unitario, pe.sub_total AS subtotal
                  FROM producto p
                  INNER JOIN pedido pe ON p.id_producto = pe.producto_id_producto
                  WHERE pe.nota_venta_nro_venta = ?";

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
