<?php
$page = 1;
$ope = "filterSearch";
$filter = "";
$items_per_page = 10;
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
$half_max_links = floor($max_links / 2);

$start_page = $page - $half_max_links;
$end_page = $page + $half_max_links;

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
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Productos</h4>
                        <div class="table-responsive">
                            <table class="table">
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
                                            <td>
                                                <a href="<?= HTTP_BASE . '/productos/editar/' . $producto['id_producto'] ?>" class="btn btn-secondary">Editar</a>
                                            </td>
                                            <td>
                                                <a href="<?= HTTP_BASE . '/productos/desactivar/' . $producto['id_producto'] ?>" class="btn btn-danger">Desactivar</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <div class="card-footer clearfix">
                                <ul class="pagination">
                                    <?php if ($page > 1) : ?>
                                        <li class="page-item">
                                            <form action="" method="POST">
                                                <input type="hidden" name="page" value="1">
                                                <button type="submit" class="page-link">Primera</button>
                                            </form>
                                        </li>
                                        <li class="page-item">
                                            <form action="" method="POST">
                                                <input type="hidden" name="page" value="<?= $page - 1 ?>">
                                                <button type="submit" class="page-link">&laquo;</button>
                                            </form>
                                        </li>
                                    <?php endif; ?>

                                    <?php for ($i = $start_page; $i <= $end_page; $i++) : ?>
                                        <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                                            <form action="" method="POST">
                                                <input type="hidden" name="page" value="<?= $i ?>">
                                                <button type="submit" class="page-link"><?= $i ?></button>
                                            </form>
                                        </li>
                                    <?php endfor; ?>

                                    <?php if ($page < $total_pages) : ?>
                                        <li class="page-item">
                                            <form action="" method="POST">
                                                <input type="hidden" name="page" value="<?= $page + 1 ?>">
                                                <button type="submit" class="page-link">&raquo;</button>
                                            </form>
                                        </li>
                                        <li class="page-item">
                                            <form action="" method="POST">
                                                <input type="hidden" name="page" value="<?= $total_pages ?>">
                                                <button type="submit" class="page-link">Última</button>
                                            </form>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php require(ROOT_VIEW . '/templates/footer.php') ?>