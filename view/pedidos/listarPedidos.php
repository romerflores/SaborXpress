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
?>
<?php require(ROOT_VIEW . '/templates/header.php') ?>
<div class="col-lg-6 grid-margin stretch-card">
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
                        <?php foreach ($records as $producto) : ?>
                            <tr>
                                <td><?= htmlspecialchars($producto['id_pedido']) ?></td>
                                <td><?= htmlspecialchars($producto['cantidad']) ?></td>
                                <td><?= htmlspecialchars($producto['sub_total']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php require(ROOT_VIEW . '/templates/footer.php') ?>