

<?php

// Listado de las categorías
$url = HTTP_BASE . "/controller/ClienteController.php?ope=filterall";
$response = file_get_contents($url);
$responseData = json_decode($response, true);
$records = $responseData['DATA']; // Las categorías están guardadas en $records

// Manejo del método POST y además la creación de JSON
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $id_cliente = $_POST['id_cliente'];
    $razon_social = $_POST['razon_social'];

    // Validar los datos antes de enviarlos
    if ($id_cliente && $razon_social) {
        // Preparar la URL para la solicitud POST
        $url = HTTP_BASE . "/controller/ClienteController.php";

        // Crear datos para enviar
        $data = array(
            'ope' => 'insert', // Operación de inserción
            'id_cliente' => $id_cliente,
            'razon_social' => $razon_social,
        );

        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => "Content-Type: application/json",
                'content' => json_encode($data),
            ]
        ]);

        $response = file_get_contents($url, false, $context);
        $result = json_decode($response, true);

        // Manejar la respuesta
        if ($result["ESTADO"]) {
            echo '<script>alert("Cliente agregado exitosamente.");</script>';
            echo '<script>window.location.href ="' . HTTP_BASE . '/productos/prod-listado"</script>';
        } else {
            echo '<script>alert("Ha ocurrido un error.");</script>';
        }
    } else {
        echo '<script>alert("Todos los campos son obligatorios");</script>';
    }
}

?>

<?php require(ROOT_VIEW . '/templates/header.php') ?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="container">
                <div class="card">
                    <div class="card-body">
                        <h3>Crear Nuevo Cliente</h3>
                        <form action="<?= HTTP_BASE ?>/productos/prod-crear" method="POST">
                            <div class="form-group">
                                <label for="id_cliente">ID Cliente:</label>
                                <input type="text" class="form-control" id="id_cliente" name="id_cliente" required>
                            </div>
                            <div class="form-group">
                                <label for="razon_social">Razón Social:</label>
                                <input type="text" class="form-control" id="razon_social" name="razon_social" required>
                            </div>
                            <!-- Otros campos del cliente -->
                            <button type="submit" class="btn btn-primary">Crear Cliente</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require(ROOT_VIEW . '/templates/footer.php') ?>


