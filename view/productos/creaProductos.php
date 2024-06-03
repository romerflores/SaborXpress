<?php

//listado de las categorias
$url = HTTP_BASE . "/controller/CategoriaController.php?ope=filterall";
$response = file_get_contents($url);
$responseData = json_decode($response, true);
$records = $responseData['DATA']; //las categorias estan guardads en records


// Manejo del método POST y ademaas la creacion de json
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $descripcion = $_POST['descripcion_producto'];
    $precio = $_POST['precio_producto'];
    $estado = $_POST['estado_producto'];
    $estado= strtoupper($estado);
    $categoria = $_POST['categoria_id_categoria'];

    // Validar los datos antes de enviarlos
    if ($descripcion && $precio && $estado && $categoria) {
        // Preparar la URL para la solicitud POST
        $url = HTTP_BASE . "/controller/ProductoController.php";

        // Crear datos para enviar
        $data = array(
            'ope' => 'insert', // Operación de inserción
            'descripcion_producto' => $descripcion,
            'precio_producto' => $precio,
            'estado_producto' => $estado,
            'categoria_id_categoria' => $categoria,
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
        //var_dump($result);
        // Manejar la respuesta
        if ($result["ESTADO"]) {
            echo '<script>alert("Producto agregado exitosamente.");</script>';
            echo '<script>window.location.href ="' . HTTP_BASE . '/productos/listado"</script>';
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
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Agregar Producto</h4>
                        <p class="card-description">
                            Rellena los detalles con cada campo Obligatorio
                        </p>
                        <form class="forms-sample" action="" method="POST">
                            <div class="form-group">
                                <label for="exampleInputName1">Descripcion Producto</label>
                                <input type="text" class="form-control" id="exampleInputName1" placeholder="Descripcion Producto" name="descripcion_producto" required>
                            </div>
                            <div class="form-group" style="max-width: 300px;">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Bs</span>
                                    </div>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">0.00</span>
                                    </div>
                                    <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)" name="precio_producto" required>
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
                                    <?php foreach ($records as $module) : ?>
                                        <option value="<?= htmlspecialchars($module['id_categoria']) ?>"><?= htmlspecialchars($module['nombre_categoria']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">Crear Producto</button>
                            <button class="btn btn-light" type="reset">Reiniciar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<?php require(ROOT_VIEW . '/templates/footer.php') ?>