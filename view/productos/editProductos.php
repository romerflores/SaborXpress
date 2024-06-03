<?php

$id_producto = $_GET['id_producto'] ?? null;
$data = null;

if ($id_producto) {
    // Preparar la URL para obtener los detalles del producto
    $url = HTTP_BASE . "/controller/ProductoController.php?ope=filterId&id_producto=" . $id_producto;

    // Obtener detalles del producto
    $response = file_get_contents($url);
    $responseData = json_decode($response, true);

    // Validar si se encontró el producto y si la clave 'id_producto' está definida
    if ($responseData && $responseData['ESTADO'] == 1 && !empty($responseData['DATA'])) {
        $datos_producto = $responseData['DATA'][0];
    } else {
        $datos_producto = null;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $id_producto = $_POST['id_producto'];
    $descripcion = $_POST['descripcion_producto'];
    $precio = $_POST['precio_producto'];
    $estado = $_POST['estado_producto'];
    $estado= strtoupper($estado);
    $categoria = $_POST['categoria_id_categoria'];

    // Validar los datos antes de enviarlos
    if ($id_producto && $descripcion && $precio && $estado && $categoria) {
        // Preparar la URL para la solicitud POST
        // echo $id_producto."<br>";
        // echo $descripcion."<br>";
        // echo $precio."<br>";
        // echo $estado."<br>";
        // echo $categoria."<br>";
        $url = HTTP_BASE . "/controller/ProductoController.php";
        // Crear datos para enviar
        $updateData = [
            'ope' => 'update', // Operación de actualización
            'id_producto' => $id_producto,
            'descripcion_producto' => $descripcion,
            'precio_producto' => $precio,
            'estado_producto' => $estado,
            'categoria_id_categoria' => $categoria,

        ];
        $context = stream_context_create([
            'http' => [
                'method' => 'PUT',
                'header' => "Content-Type: application/json",
                'content' => json_encode($updateData),
            ]
        ]);
        $response = file_get_contents($url, false, $context);
        $result = json_decode($response, true);
        //var_dump($result);
        if ($result["ESTADO"]) {
            echo '<script>alert("Registro Guardado  Exitosamente.");</script>';
            echo '<script>window.location.href ="' . HTTP_BASE . '/productos/prod-listado"</script>';
        } else {
            echo '<script>alert("No se Puede Guardar.");</script>';
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
                        <h4 class="card-title">Editar Producto</h4>
                        <p class="card-description">
                            Rellena los detalles con cada campo Obligatorio
                        </p>
                        <form class="forms-sample" action="" method="POST">
                            <div class="form-group">
                                <input type="hidden" class="form-control" id="exampleInputName0" placeholder="Id" name="id_producto" value="<?php echo $datos_producto['id_producto'] ?? ''; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputName1">Descripcion Producto</label>
                                <input type="text" class="form-control" id="exampleInputName1" placeholder="Descripcion Producto" name="descripcion_producto" value="<?php echo $datos_producto['descripcion_producto'] ?? ''; ?>" required>
                            </div>
                            <div class="form-group" style="max-width: 300px;">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Bs</span>
                                    </div>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">0.00</span>
                                    </div>
                                    <input type="number" class="form-control" name="precio_producto" value="<?php echo $datos_producto['precio_producto'] ?? ''; ?>" required>
                                </div>
                            </div>
                            <div class="form-group" style="max-width: 200px;">
                                <label for="exampleSelectEstado">Estado</label>
                                <select class="form-control" id="exampleSelectEstado" name="estado_producto" required>
                                    <option>Activo</option>
                                    <option>Inactivo</option>
                                </select>
                            </div>
                            <div class="form-group" style="max-width: 500px;">
                                <label for="exampleFormControlCategoria">Categoria</label>
                                <select class="form-control form-control-sm" id="exampleFormControlCategoria" name="categoria_id_categoria" required>
                                    <?php foreach ($records as $categoria) : ?>
                                        <option value="<?= htmlspecialchars($categoria['id_categoria']) ?>"><?= htmlspecialchars($categoria['nombre_categoria']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">Actualizar Producto</button>
                            <button class="btn btn-light" type="reset">Reiniciar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php require(ROOT_VIEW . '/templates/footer.php'); ?>