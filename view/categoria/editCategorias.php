<?php

$id_categoria = $_GET['id_categoria'] ?? null;
$data = null;

if ($id_categoria) {
    // Preparar la URL para obtener los detalles del producto
    $url = HTTP_BASE . "/controller/CategoriaController.php?ope=filterId&id_categoria=" . $id_categoria;

    // Obtener detalles del producto
    $response = file_get_contents($url);
    $responseData = json_decode($response, true);

    // Validar si se encontró el producto y si la clave 'id_categoria' está definida
    if ($responseData && $responseData['ESTADO'] == 1 && !empty($responseData['DATA'])) {
        $datos_categoria = $responseData['DATA'][0];
    } else {
        $datos_categoria = null;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $id_categoria = $_POST['id_categoria'];
    $id_categoria= strtoupper($id_categoria);
    $nombre_categoria = $_POST['nombre_categoria'];

    // Validar los datos antes de enviarlos
    if ($id_categoria && $nombre_categoria) {
        // Preparar la URL para la solicitud POST
        $url = HTTP_BASE . "/controller/CategoriaController.php";

        // Crear datos para enviar
        $data = array(
            'ope' => 'update', // Operación de inserción
            'id_categoria' => $id_categoria,
            'nombre_categoria' => $nombre_categoria,
        );
        $context = stream_context_create([
            'http' => [
                'method' => 'PUT',
                'header' => "Content-Type: application/json",
                'content' => json_encode($data),
            ]
        ]);
        $response = file_get_contents($url, false, $context);
        $result = json_decode($response, true);
        if ($result["ESTADO"]) {
            echo '<script>alert("Categoria agregada exitosamente.");</script>';
            echo '<script>window.location.href ="' . HTTP_BASE . '/categorias/listado"</script>';
        } else {
            echo '<script>alert("Ha ocurrido un error.");</script>';
        }
    } else {
        echo '<script>alert("Todos los campos son obligatorios");</script>';
    }
}

//listado de las categorias
$url = HTTP_BASE . "/controller/CategoriaController.php?ope=filterall";
$response = file_get_contents($url);
$responseData = json_decode($response, true);
$records = $responseData['DATA']; //las categorias estan guardads en records




?>
<?php require(ROOT_VIEW . '/templates/header.php') ?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Editar Categoria</h4>
                        <p class="card-description">
                            Rellena los detalles con cada campo Obligatorio
                        </p>
                        <form class="forms-sample" action="" method="POST">
                            <div class="form-group">
                                <input type="hidden" class="form-control" id="exampleInputName0" placeholder="Id" name="id_categoria" value="<?php echo $datos_categoria['id_categoria'] ?? ''; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputName1">Nombre Categoria</label>
                                <input type="text" class="form-control" id="exampleInputName1" placeholder="Nombre Categoria" name="nombre_categoria" value="<?php echo $datos_categoria['nombre_categoria'] ?? ''; ?>" required>
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">Actualizar Categoria</button>
                            <button class="btn btn-light" type="reset">Reiniciar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php require(ROOT_VIEW . '/templates/footer.php'); ?>