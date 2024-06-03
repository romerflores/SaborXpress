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

$url = HTTP_BASE . "/controller/ClienteController.php?ope=filterSearch&page=" . $page . "&filter=" . $filter;
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

// Paginación
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

<div class="container">
    <div class="row">
        <!-- Lista Clientes -->
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Clientes</h4>
                    <p class="card-description">
                        <code>Tabla</code>
                    </p>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>CI</th>
                                    <th>Razon Social</th>
                                </tr>
                            </thead>
                            <tbody id="client-list">
                                <?php foreach ($records as $cliente) : ?>
                                    <tr>
                                        <td><?= htmlspecialchars($cliente['id_cliente']) ?></td>
                                        <td><?= htmlspecialchars($cliente['razon_social']) ?></td>
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
                </div>
            </div>
        </div>
    </div>

    <!-- Formularios de Modificar y Crear Cliente -->
    <div class="row">
        <!-- Modificar Cliente -->
        <div class="col-lg-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Modificar Cliente</h4>
                    <p class="card-description">
                        <code>Formulario</code>
                    </p>
                    <form id="form-update-client">
                        <div class="form-group">
                            <label for="update_id_cliente">ID Cliente</label>
                            <input type="text" class="form-control" id="update_id_cliente" name="id_cliente" readonly>
                        </div>
                        <div class="form-group">
                            <label for="update_razon_social">Razón Social</label>
                            <input type="text" class="form-control" id="update_razon_social" name="razon_social" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Actualizar Cliente</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Crear Cliente -->
        <div class="col-lg-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Crear Cliente</h4>
                    <p class="card-description">
                        <code>Formulario</code>
                    </p>
                    <form id="form-create-client">
                        <div class="form-group">
                            <label for="create_id_cliente">ID Cliente</label>
                            <input type="text" class="form-control" id="create_id_cliente" name="id_cliente" required>
                        </div>
                        <div class="form-group">
                            <label for="create_razon_social">Razón Social</label>
                            <input type="text" class="form-control" id="create_razon_social" name="razon_social" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Crear Cliente</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<?php require(ROOT_VIEW . '/templates/footer.php') ?>
