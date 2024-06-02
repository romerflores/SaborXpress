<?php
// Incluir encabezado
require(ROOT_VIEW . '/templates/header.php');

// Verificar si la solicitud es POST para manejar la actualización del pedido
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $id_pedido = trim($_POST['id_pedido']);
    $cantidad = trim($_POST['cantidad']);
    $sub_total = trim($_POST['sub_total']);

    // Validar los datos antes de enviarlos
    if ($id_pedido && $cantidad && $sub_total) {
        // Preparar la URL para la solicitud POST
        $url = HTTP_BASE . "/controller/PedidoController.php";
        
        // Crear datos para enviar
        $data = array(
            'id_pedido' => $id_pedido,
            'cantidad' => $cantidad,
            'sub_total' => $sub_total,
            'ope' => 'update' // Operación de actualización
        );

        // Configurar opciones de la solicitud POST
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );

        // Crear contexto de la solicitud
        $context  = stream_context_create($options);
        
        // Enviar solicitud y obtener respuesta
        $response = file_get_contents($url, false, $context);
        
        // Manejar la respuesta
        if ($response === FALSE) {
            echo "Error al actualizar el pedido.";
        } else {
            echo "Pedido actualizado exitosamente.";
        }
    } else {
        echo "Todos los campos son obligatorios.";
    }
} else {
    // Obtener el ID del pedido a editar de la URL
    $id_pedido = isset($_GET['id_pedido']) ? $_GET['id_pedido'] : '';

    // Validar si se ha proporcionado un ID
    if ($id_pedido) {
        // Preparar la URL para obtener los detalles del pedido
        $url = HTTP_BASE . "/controller/PedidoController.php?ope=filterId&id_pedido=" . $id_pedido;

        // Obtener detalles del pedido
        $response = file_get_contents($url);
        $pedido = json_decode($response, true);

        // Validar si se encontró el pedido
        $p_id_pedido = isset($pedido['id_pedido']) ? $pedido['id_pedido'] : null;
        if ($p_id_pedido === null) {
            echo "ID de pedido no proporcionado.";
            exit;
        }
    }
}
?>

<div class="col-lg-6 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Modificar Pedido</h4>
            <p class="card-description">
                <code>Formulario</code>
            </p>
            <form method="POST" action="">
                <input type="hidden" name="id_pedido" value="<?= htmlspecialchars($pedido['id_pedido'] ?? '') ?>">
                <div class="form-group">
                    <label for="cantidad">Cantidad</label>
                    <input type="text" class="form-control" id="cantidad" name="cantidad" value="<?= htmlspecialchars($pedido['cantidad'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label for="sub_total">Sub Total</label>
                    <input type="text" class="form-control" id="sub_total" name="sub_total" value="<?= htmlspecialchars($pedido['sub_total'] ?? '') ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Actualizar Pedido</button>
            </form>
        </div>
    </div>
</div>

<?php
// Incluir pie de página
require(ROOT_VIEW . '/templates/footer.php');
?>
