<?php
$page = 1;
$ope = "filterSearch";
<<<<<<< Updated upstream
$filter = "";
$items_per_page = 10;
=======
$filter = $_GET['id_categoria'] ?? '';
$items_per_page = 5;
>>>>>>> Stashed changes
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


//paginacion
$max_links = 5;
<<<<<<< Updated upstream
$half_max_link = floor($max_links / 2);
$start_page = $page - $half_max_link;
$end_page = $page + $half_max_link;
=======
$half_max_links = floor($max_links / 2);

$start_page = $page - $half_max_links;
$end_page = $page + $half_max_links;

>>>>>>> Stashed changes
if ($start_page < 1) {
    $end_page += abs($start_page) + 1;
    $start_page = 1;
}
if ($end_page > $total_pages) {
    $start_page -= ($end_page - $total_pages);
    $end_page = $total_pages;
    if ($start_page < 1) {
        $start_page = 1;
    }
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
                                        <th>Editar</th>
                                        <th>Desactivar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($records as $producto) : ?>
                                        <tr>
                                            <td><?= htmlspecialchars($producto['id_producto'] ?? '') ?></td>
                                            <td><?= htmlspecialchars($producto['descripcion_producto'] ?? '') ?></td>
                                            <td><?= htmlspecialchars($producto['precio_producto'] ?? '') ?></td>
                                            <td>
                                                <div class="badge badge-primary"><?= htmlspecialchars($producto['estado_producto'] ?? '') ?></div>
                                            </td>
                                            <td><?= htmlspecialchars($producto['nombre_categoria'] ?? '') ?></td>
                                            <td>
                                                <a href="<?= HTTP_BASE . '/productos/editar/'. $producto['id_producto'] ?>" class="btn btn-secondary">Editar</a>
                                            </td>
                                            <td>
                                            <a href="<?= HTTP_BASE . '/productos/desactivar/'. $producto['id_producto'] ?>" class="btn btn-danger">Desactivar</a>
                                            </td>
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

<<<<<<< Updated upstream

=======
>>>>>>> Stashed changes
<?php require(ROOT_VIEW . '/templates/footer.php') ?>