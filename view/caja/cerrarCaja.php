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

$url = HTTP_BASE . "/controller/Detalle_CajaController.php?ope=filterSearch&page=" . $page . "&filter=" . $filter;
$filter = urldecode($filter);
$response = file_get_contents($url);
$responseData = json_decode($response, true);
// Verificación de la respuesta del servidor
if (isset($responseData['DATA']) && isset($responseData['LENGTH'])) {
    $records = $responseData['DATA'];
    $totalItems = $responseData['LENGTH'];
    try {
        $total_pages = ceil($totalItems / $items_per_page);
    } catch (Exception $e) {
        $total_pages = 1;
    }
} else {
    $records = [];
    $totalItems = 0;
    $total_pages = 1;
}

require(ROOT_VIEW . '/templates/header.php') ?>


<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="container">
                <div class="card">
                    <div class="card-body">
                        <h3>Cierre de Caja</h3>
                        <form action="<?= HTTP_BASE ?>/Detalle_CajaController.php" method="POST">
                            <div class="form-group">
                                <label for="monto_final">Monto Final:</label>
                                <input type="number" class="form-control" id="monto_final" name="monto_final" required>
                            </div>
                            <div class="form-group">
                                <label for="fecha_fin">Fecha de Cierre:</label>
                                <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required>
                            </div>
                            <div class="form-group">
                                <label for="hora_fin">Hora de Cierre:</label>
                                <input type="time" class="form-control" id="hora_fin" name="hora_fin" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Cerrar e Iniciar caja</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <button type="button" class="btn btn-info btn-icon-text" onclick="window.location.href='<?= HTTP_BASE ?>/report/rpt_cierre_Caja.php'">
            Cerrar Caja y Generar Reporte
            <i class="typcn typcn-printer btn-icon-append"></i>
        </button>
    </div>
</div>
<?php require(ROOT_VIEW . '/templates/footer.php') ?>
