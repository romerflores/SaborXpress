<?php require(ROOT_VIEW . '/templates/header.php') ?>

<?php

$id_cliente = $_POST['id_cliente'] ?? null;
$data = null;

if ($id_cliente && $_POST['razon_social']=='') {
    // Preparar la URL para obtener los detalles del producto
    $url = HTTP_BASE . "/controller/ClienteController.php?ope=filterId&id_cliente=" . $id_cliente;

    // Obtener detalles del producto
    $response = file_get_contents($url);
    $responseData = json_decode($response, true);

    // Validar si se encontró el producto y si la clave 'id_cliente' está definida
    if ($responseData && $responseData['ESTADO'] == 1 && !empty($responseData['DATA'])) {
        $datos_cliente = $responseData['DATA'][0];
        $_SESSION['venta']['id_cliente']=$datos_cliente['id_cliente'];
        $_SESSION['venta']['razon_social']=$datos_cliente['razon_social'];
    } else {
        
        echo '<script>alert("Cliente no encontrado, llenar datos");</script>';
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['razon_social']!='')
{
    $id_cliente = $_POST['id_cliente'];
    $razon_social = $_POST['razon_social'];
    try {
        $data = array(
            'ope' => 'update',
            'id_cliente' => $id_cliente,
            'razon_social' => $razon_social,
        );
        $context = stream_context_create([
            'http' => [
                'method' => 'PUT',
                'header' => "Content-Type: application/json",
                'content' => json_encode($data),
            ]
        ]);
        $url = HTTP_BASE . "/controller/ClienteController.php";
        $response = file_get_contents($url, false, $context);
        $result = json_decode($response, true);
        if ($result["ESTADO"]) {
            $_SESSION['venta']['id_cliente']=$_POST['id_cliente'];
            $_SESSION['venta']['razon_social']=$_POST['razon_social'];
            echo '<script>alert("Registro Guardado Exitosamente.");</script>';
            echo '<script>window.location.href="' . HTTP_BASE . '/ventas/llenarDatos"</script>';
        }else{
            echo '<script>alert("No se Puede Guardar.");</script>';
        }
    } catch (Exception $e) {
        echo '<script>alert("Ocurrió un error al guardar.");</script>';
    }
}


?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="container">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Datos Cliente</h4>
                        <form class="forms-sample" method="POST" action="">
                            <div class="form-group">
                                <label for="ci">NIT/CI/CEX</label>
                                <input type="text" class="form-control" id="ci" placeholder="Email" name="id_cliente" required value="<?php echo $id_cliente;?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputName1">Razon Social</label>
                                <input type="text" class="form-control" id="exampleInputName1" name="razon_social" placeholder="razon_social" value="<?php echo isset($datos_cliente['razon_social'])?$datos_cliente['razon_social']:''?>">
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">Verificar</button>
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