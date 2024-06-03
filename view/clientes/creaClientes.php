<?php
// Incluir encabezado
require(ROOT_VIEW . '/templates/header.php');

// Verificar si la solicitud es POST para manejar la creación del cliente
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $id_cliente = trim($_POST['id_cliente']);
    $razon_social = trim($_POST['razon_social']);
    try {
        $data = array(
            'ope' => 'create',
            'id_cliente' => $id_cliente,
            'razon_social' => $razon_social,
        );
        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => "Content-Type: application/json",
                'content' => json_encode($Data),
            ]
        ]);
        $url = HTTP_BASE . "/controller/ClienteController.php";
        $response = file_get_contents($url, false, $context);
        $result = json_decode($response, true);
        if ($result["ESTADO"]) {
            echo '<script>alert("Registro Guardado Exitosamente.");</script>';
        }else{
            echo '<script>alert("No se Puede Guardar.");</script>';
        }
    } catch (Exception $e) {
        echo '<script>alert("Ocurrió un error al guardar.");</script>';
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