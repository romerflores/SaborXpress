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

// Verificar si id_pedido está presente en la URL
if (!isset($_GET['id_pedido'])) {
    echo "ID de pedido no especificado.";
    exit();
}

$id_pedido = $_GET['id_pedido'];

//la consulta
$query = "SELECT p.id_pedido, p.cantidad, p.sub_total, p.nota_venta_nro_venta, 
        prod.descripcion_producto AS producto, prod.precio_producto, cat.nombre_categoria AS categoria_nombre
        FROM pedido p
        JOIN producto prod ON p.producto_id_producto = prod.id_producto
        JOIN categoria cat ON prod.categoria_id_categoria = cat.id_categoria
        WHERE p.id_pedido = ?";

// Usar prepared statement para ejecutar la consulta
$stmt = $mysqli->prepare($query);
$stmt->bind_param('i', $id_pedido);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $pedido = $result->fetch_assoc();
} else {
    echo "No se encontró el pedido.";
    exit();
}

// Crear el PDF
$pdf = new FPDF('P', 'mm', array(80, 86)); // Tamaño ticket 80mm x 150 mm (largo aprox)
$pdf->AddPage();

// CABECERA
$pdf->SetFont('Helvetica', 'B', 12);
$pdf->Cell(60, 4, 'PEDIDO NRO ' . $pedido['id_pedido'], 0, 1, 'C');
$pdf->SetFont('Helvetica', '', 8);
$pdf->Cell(60, 4, 'SaborXpress', 0, 1, 'C');
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
$pdf->SetFont('Helvetica', 'B', 7);
$pdf->Ln(2);
$pdf->Cell(30, 10, 'PRODUCTO', 0);
$pdf->Cell(10, 10, 'CANT', 0);
$pdf->Cell(20, 10, 'SUBTOTAL', 0, 0, 'R');
$pdf->Ln(5);

// Detalles del pedido
$pdf->Cell(30, 10, $pedido['producto'], 0);
$pdf->Cell(10, 10, $pedido['cantidad'], 0);
$pdf->Cell(20, 10, number_format($pedido['sub_total'], 2, ',', ' ') . BOLIVIANOS, 0, 0, 'R');
$pdf->Ln(5);

$total = $pedido['sub_total']; // Calcula el total
$pdf->Ln(6);
$pdf->Cell(60, 10, 'TOTAL: ' . number_format($total, 2, ',', ' ') . BOLIVIANOS, 0, 0, 'R');
$pdf->Ln(10);

// PIE DE PAGINA
$texto = '"EN CASO DE NO RECIBIR SU PEDIDO USE ESTE TICKET"';
$pdf->SetFont('Arial', '', 6); // Puedes ajustar el tamaño de la fuente según sea necesario
$pdf->MultiCell(60, 5, $texto, 0, 'C');

$pdf->Output('ticket.pdf', 'I');
?>
