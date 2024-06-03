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

$url = HTTP_BASE . "/controller/PedidoController.php?ope=filterSearch&page=" . $page . "&filter=" . $filter;
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
$half_max_link = floor($max_links / 2);
$start_page = $page - $half_max_link;
$end_page = $page + $half_max_link;
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

<div class="col-lg-10 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Pedidos</h4>
            <p class="card-description">
                <code>Tabla</code>
            </p>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nro Pedido</th>
                            <th>cantidad</th>
                            <th>subTotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($records as $pedido) : ?>
                            <tr>
                                <td><?= htmlspecialchars($pedido['id_pedido']) ?></td>
                                <td><?= htmlspecialchars($pedido['cantidad']) ?></td>
                                <td><?= htmlspecialchars($pedido['sub_total']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
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
                                <input type="hidden" name="page" value="<?php echo ($page - 1); ?>">
                                <button type="submit" class="page-link">&laquo;</button>
                            </form>
                        </li>
                    <?php endif; ?>
                    <?php for ($i = $start_page; $i <= $end_page; $i++) : ?>
                        <li class="page-item <?php echo ($page == $i ? 'active' : '') ?>">
                            <form action="" method="POST">
                                <input type="hidden" name="page" value="<?php echo ($i); ?>">
                                <button type="submit" class="page-link"><?php echo ($i); ?></button>
                            </form>
                        </li>
                    <?php endfor; ?>
                    <?php if ($page < $total_pages) : ?>
                        <li class="page-item">
                            <form action="" method="POST">
                                <input type="hidden" name="page" value="<?php echo ($page + 1); ?>">
                                <button type="submit" class="page-link">&raquo;</button>
                            </form>
                        </li>
                        <li class="page-item">
                            <form action="" method="POST">
                                <input type="hidden" name="page" value="<?php echo $total_pages; ?>">
                                <button type="submit" class="page-link">Ultima</button>
                            </form>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="row">
                <!-- Columna para crear pedido -->
                <div class="col-lg-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Crear Pedido</h4>
                            <p class="card-description">
                                <code>Formulario</code>
                            </p>
                            <form method="POST" action="">
                                <div class="form-group">
                                    <label for="cantidad">Cantidad</label>
                                    <input type="text" class="form-control" id="cantidad" name="cantidad" required>
                                </div>
                                <div class="form-group">
                                    <label for="sub_total">Sub Total</label>
                                    <input type="text" class="form-control" id="sub_total" name="sub_total" required>
                                </div>
                                <div class="form-group">
                                    <label for="nota_venta_nro_venta">Nro. de Venta</label>
                                    <input type="text" class="form-control" id="nota_venta_nro_venta" name="nota_venta_nro_venta" required>
                                </div>
                                <div class="form-group">
                                    <label for="producto_id_producto">ID del Producto</label>
                                    <input type="text" class="form-control" id="producto_id_producto" name="producto_id_producto" required>
                                </div>
                                <div class="form-group">
                                    <label for="producto_categoria_id_categoria">ID de la Categoría del Producto</label>
                                    <input type="text" class="form-control" id="producto_categoria_id_categoria" name="producto_categoria_id_categoria" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Crear Pedido</button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Columna para modificar pedido -->
                <div class="col-lg-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Modificar Pedido</h4>
                            <p class="card-description">
                                <code>Formulario</code>
                            </p>
                            <form method="POST" action="">
                                <!-- Campo oculto para el ID del pedido -->
                                <input type="hidden" name="id_pedido" value="<?= htmlspecialchars($pedido['id_pedido'] ?? '') ?>">
                                <div class="form-group">
                                    <label for="cantidad">Cantidad</label>
                                    <input type="text" class="form-control" id="cantidad" name="cantidad" value="<?= htmlspecialchars($pedido['cantidad'] ?? '') ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="sub_total">Sub Total</label>
                                    <input type="text" class="form-control" id="sub_total" name="sub_total" value="<?= htmlspecialchars($pedido['sub_total'] ?? '') ?>" required>
                                </div>
                                <!-- Puedes agregar más campos según tus necesidades -->

                                <button type="submit" class="btn btn-primary">Actualizar Pedido</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Eliminar Pedidos</h4>
                            <p class="card-description">
                                <code>Tabla</code>
                            </p>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Nro Pedido</th>
                                            <th>Cantidad</th>
                                            <th>SubTotal</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($records as $pedido) : ?>
                                            <tr>
                                                <td><?= htmlspecialchars($pedido['id_pedido']) ?></td>
                                                <td><?= htmlspecialchars($pedido['cantidad']) ?></td>
                                                <td><?= htmlspecialchars($pedido['sub_total']) ?></td>
                                                <td>
                                                    <form method="POST" action="<?= HTTP_BASE . '/controller/PedidoController.php' ?>" onsubmit="return confirm('¿Está seguro de que desea eliminar este pedido?');">
                                                        <input type="hidden" name="id_pedido" value="<?= htmlspecialchars($pedido['id_pedido']) ?>">
                                                        <input type="hidden" name="ope" value="delete">
                                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
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
                                                <input type="hidden" name="page" value="<?= ($page - 1) ?>">
                                                <button type="submit" class="page-link">&laquo;</button>
                                            </form>
                                        </li>
                                    <?php endif; ?>
                                    <?php for ($i = $start_page; $i <= $end_page; $i++) : ?>
                                        <li class="page-item <?= ($page == $i ? 'active' : '') ?>">
                                            <form action="" method="POST">
                                                <input type="hidden" name="page" value="<?= ($i) ?>">
                                                <button type="submit" class="page-link"><?= ($i) ?></button>
                                            </form>
                                        </li>
                                    <?php endfor; ?>
                                    <?php if ($page < $total_pages) : ?>
                                        <li class="page-item">
                                            <form action="" method="POST">
                                                <input type="hidden" name="page" value="<?= ($page + 1) ?>">
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
</div>

<?php require(ROOT_VIEW . '/templates/footer.php') ?>