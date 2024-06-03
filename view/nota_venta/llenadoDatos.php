<?php

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
                        <h4 class="card-title">Llenado de Datos para la Nota</h4>
                        <form class="forms-sample" method="POST" action="<?php echo HTTP_BASE;?>/ventas/terminar">
                            <div class="form-group">
                                <label for="ci">NIT/CI/CEX</label>
                                <input type="text" class="form-control" id="ci" placeholder="Email" name="id_cliente" value="<?php echo $_SESSION['venta']['id_cliente']?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="ex">Razon Social</label>
                                <input type="text" class="form-control" id="ex" placeholder="razon_social" value="<?php echo $_SESSION['venta']['razon_social']?>" disabled>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Total Bs</span>
                                    </div>
                                </div>
                                <input type="text" class="form-control" id="total" value="<?php echo $_SESSION['venta']['total']; ?>" disabled>

                                <input type="hidden" class="form-control" id="total" value="<?php echo $_SESSION['venta']['total']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="nombreUsuario">Usuario</label>
                                <input type="text" class="form-control" id="nombreUsuario" placeholder="Password" disabled value="<?php echo $_SESSION['login']['nombre'] . '.' . $_SESSION['login']['apellido'] ?>">
                                <input type="hidden" class="form-control" id="usuario" placeholder="Password" value="<?php echo $_SESSION['login']['ci_usuario'] ?>">
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">Finalizar</button>
                            <button class="btn btn-light">Cancel</button>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Pedidos</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Descripcion</th>
                                        <th>Cantidad</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $suma = 0;
                                    foreach ($_SESSION['venta']['producto'] as $producto) {
                                        echo "<tr>";
                                        echo "<th>" . $producto[0] . "</th>";
                                        echo "<th>" . $producto[1] . "</th>";
                                        echo "<th>" . $producto[2] . "</th>";
                                        echo "<th>" . $producto[3] * $producto[2] . "</th>";
                                        echo "</tr>";
                                        $suma = $suma + $producto[3] * $producto[2];
                                    }
                                    $_SESSION['venta']['total'] = $suma;
                                    ?>

                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require(ROOT_VIEW . '/templates/footer.php') ?>