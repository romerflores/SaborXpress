<?php
$page = 1;
$ope = "filterSearch";
$filter = $_GET['id_categoria'] ?? '';
$items_per_page = 5;
$total_pages = 1;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $filter = urlencode(trim(isset($_POST['filter']) ? $_POST['filter'] : ''));
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
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="container">
                <form action="" method="POST">
                    <div class="form-group" style="max-width: 500px;">
                        <div class="input-group">
                            <input type="filter" class="form-control" placeholder="Buscar" aria-label="Recipient's username" value="<?php echo $filter; ?>" name="filter">
                            <div class="input-group-append">
                                <button class="btn btn-sm btn-primary" type="submit">Buscar Producto</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Productos</h4>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Descripcion</th>
                                        <th>Precio</th>
                                        <th>Estado</th>
                                        <th>Categoria</th>
                                        <th>Cantidad</th>
                                        <th>Agregar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($records as $producto) : ?>
                                        <tr>
                                            <form method="POST" action="<?php echo HTTP_BASE.'/ventas/agregarProducto'?>">
                                                <td><?= htmlspecialchars($producto['id_producto'] ?? '') ?></td>
                                                <td><?= htmlspecialchars($producto['descripcion_producto'] ?? '') ?></td>
                                                <td><?= htmlspecialchars($producto['precio_producto'] ?? '') ?></td>
                                                <td>
                                                    <?php
                                                    $estado = htmlspecialchars($producto['estado_producto'] ?? '');
                                                    if ($estado == 'ACTIVO') {
                                                        echo '<div class="badge badge-info">' . $estado . '</div>';
                                                    } else {
                                                        echo '<div class="badge badge-danger">' . $estado . '</div>';
                                                    }
                                                    ?>
                                                </td>
                                                <td><?= htmlspecialchars($producto['nombre_categoria'] ?? '') ?></td>
                                                <div class="input-group">
                                                    <input type="hidden" class="form-control" name="id_producto" value="<?= htmlspecialchars($producto['id_producto'] ?? '') ?>">
                                                </div>
                                                <div class="input-group">
                                                    <input type="hidden" class="form-control" name="descripcion_producto" value="<?= htmlspecialchars($producto['descripcion_producto'] ?? '') ?>">
                                                </div>
                                                <div class="input-group">
                                                    <input type="hidden" class="form-control" name="precio_producto" value="<?= htmlspecialchars($producto['precio_producto'] ?? '') ?>">
                                                </div>
                                                <div class="input-group">
                                                    <input type="hidden" class="form-control" name="categoria_id_categoria" value="<?= htmlspecialchars($producto['categoria_id_categoria'] ?? '') ?>">
                                                </div>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">Cant</span>
                                                            </div>
                                                            <input type="number" class="form-control" name="cantidad">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button class="btn btn-danger" type="submit">Agregar</button>
                                                </td>
                                            </form>

                                        </tr>
                                    <?php endforeach; ?>
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