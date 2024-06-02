<?php
// Incluir encabezado
require(ROOT_VIEW . '/templates/header.php');

// Verificar si la solicitud es POST para manejar la creación del pedido
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $cantidad = trim($_POST['cantidad']);
    $sub_total = trim($_POST['sub_total']);

    // Validar los datos antes de enviarlos
    if ($cantidad && $sub_total) {
        // Preparar la URL para la solicitud POST
        $url = HTTP_BASE . "/controller/PedidoController.php";
        
        // Crear datos para enviar
        $data = array(
            'cantidad' => $cantidad,
            'sub_total' => $sub_total,
            'ope' => 'create' // Operación de creación
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
            echo "Error al crear el pedido.";
        } else {
            echo "Pedido creado exitosamente.";
        }
    } else {
        echo "Todos los campos son obligatorios.";
    }
}
?>

<div class="col-lg-6 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Crear Pedido</h4>
            <p class="card-description">
                <code>Formulario</code>
            </p>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="cantidad">Cantidad</label>
                    <input type="text" class="form-control" id="cantidad" name="cantidad" required>
                </div>
                <div class="form-group">
                    <label for="sub_total">Sub Total</label>
                    <input type="text" class="form-control" id="sub_total" name="sub_total" required>
                </div>
                <button type="submit" class="btn btn-primary">Crear Pedido</button>
            </form>
        </div>
    </div>
</div>

<?php
// Incluir pie de página
require(ROOT_VIEW . '/templates/footer.php');
?>
