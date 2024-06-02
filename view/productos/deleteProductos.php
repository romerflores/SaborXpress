<?php
$page = 1;
$ope = "filterSearch";
$filter = "";
$items_per_page = 10;
$total_pages = 1;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $filter = urlencode(trim(isset($_POST['filter']) ? $_POST['filter'] : ''));

    if (isset($_POST['delete_id'])) {
        // Obtener el ID del producto a eliminar
        $delete_id = $_POST['delete_id'];
        
        // Preparar la URL para la solicitud POST de eliminación
        $url = HTTP_BASE . "/controller/ProductoController.php";
        
        // Crear datos para enviar
        $data = array(
            'id_producto' => $delete_id,
            'ope' => 'delete' // Operación de eliminación
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
            echo "Error al eliminar el producto.";
        } else {
            echo "Producto eliminado exitosamente.";
        }
    }
}

$url = HTTP_BASE . "/controller/ProductoController.php?ope=filterSearch&page=" . $page . "&filter=" . $filter;
$filter = urldecode($filter);
$response = file_get_contents($url);
$responseData = json_decode($response, true);
$records = $responseData['DATA'];
$totalItems = $responseData['LENGTH'];
try {
    $total_pages = ceil($totalItems / $items_per_page);
} catch (Exception $e) {
    $total_pages = 1;
}
?>
<?php require(ROOT_VIEW . '/templates/header.php') ?>
<div class="col-lg-6 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Listado Productos</h4>
            <p class="card-description">
                 <code>Tabla</code>
            </p>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Descripcion</th>
                            <th>Precio</th>
                            <th>Estado</th>
                            <th>Categoria</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($records as $producto) : ?>
                            <tr>
                                <td><?= htmlspecialchars($producto['id_producto']) ?></td>
                                <td><?= htmlspecialchars($producto['descripcion_producto']) ?></td>
                                <td><?= htmlspecialchars($producto['precio_producto']) ?></td>
                                <td><div class="badge badge-primary"><?= htmlspecialchars($producto['estado_producto']) ?></div></td>
                                
                                <td><?= htmlspecialchars($producto['nombre_categoria']) ?></td>
                                <td>
                                    <form method="POST" action="">
                                        <input type="hidden" name="delete_id" value="<?= htmlspecialchars($producto['id_producto']) ?>">
                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php require(ROOT_VIEW . '/templates/footer.php') ?>
