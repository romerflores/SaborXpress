<?php
require(ROOT_VIEW . '/templates/header.php');

$id_cliente = '';
$razon_social = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $id_cliente = trim($_POST['id_cliente']);
    $razon_social = trim($_POST['razon_social']);

    // Validar los datos antes de enviarlos
    if ($id_cliente && $razon_social) {
        // Preparar la URL para la solicitud POST
        $url = HTTP_BASE . "/controller/ClienteController.php";
        
        // Crear datos para enviar
        $data = array(
            'id_cliente' => $id_cliente,
            'razon_social' => $razon_social,
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
            echo "Error al actualizar el cliente.";
        } else {
            echo "Cliente actualizado exitosamente.";
        }
    } else {
        echo "Todos los campos son obligatorios.";
    }
} elseif (isset($_GET['id_cliente'])) {
    // Obtener datos del cliente para mostrar en el formulario
    $id_cliente = $_GET['id_cliente'];
    $url = HTTP_BASE . "/controller/ClienteController.php?ope=get&id_cliente=" . urlencode($id_cliente);
    $response = file_get_contents($url);
    $cliente = json_decode($response, true);

    if ($cliente && isset($cliente['DATA'])) {
        $id_cliente = $cliente['DATA']['id_cliente'];
        $razon_social = $cliente['DATA']['razon_social'];
    } else {
        echo "Error al obtener los datos del cliente.";
    }
} else {
    echo "ID de cliente no especificado.";
    
}
?>

<div class="col-lg-6 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Editar Cliente</h4>
            <p class="card-description">
                <code>Formulario</code>
            </p>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="id_cliente">ID Cliente</label>
                    <input type="text" class="form-control" id="id_cliente" name="id_cliente" value="<?= htmlspecialchars($id_cliente) ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="razon_social">Razón Social</label>
                    <input type="text" class="form-control" id="razon_social" name="razon_social" value="<?= htmlspecialchars($razon_social) ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Actualizar Cliente</button>
            </form>
        </div>
    </div>
</div>

<?php
require(ROOT_VIEW . '/templates/footer.php');
?>
