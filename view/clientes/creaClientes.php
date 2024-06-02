<?php
// Incluir encabezado
require(ROOT_VIEW . '/templates/header.php');

// Verificar si la solicitud es POST para manejar la creación del cliente
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
            echo "Error al crear el cliente.";
        } else {
            echo "Cliente creado exitosamente.";
        }
    } else {
        echo "Todos los campos son obligatorios.";
    }
}
?>

<div class="col-lg-6 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Crear Cliente</h4>
            <p class="card-description">
                <code>Formulario</code>
            </p>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="id_cliente">ID Cliente</label>
                    <input type="text" class="form-control" id="id_cliente" name="id_cliente" required>
                </div>
                <div class="form-group">
                    <label for="razon_social">Razón Social</label>
                    <input type="text" class="form-control" id="razon_social" name="razon_social" required>
                </div>
                <button type="submit" class="btn btn-primary">Crear Cliente</button>
            </form>
        </div>
    </div>
</div>

<?php
// Incluir pie de página
require(ROOT_VIEW . '/templates/footer.php');
?>