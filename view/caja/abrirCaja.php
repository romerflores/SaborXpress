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
                        <h3>Apertura  de Caja</h3>
                        <form action="<?= HTTP_BASE ?>/Detalle_CajaController.php" method="POST">
                            <div class="form-group">
                                <label for="monto_inicio">Monto de Inicio:</label>
                                <input type="number" class="form-control" id="monto_inicio" name="monto_inicio" required>
                            </div>
                            <div class="form-group">
                                <label for="fecha_inicio">Fecha de Inicio:</label>
                                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
                            </div>
                            <div class="form-group">
                                <label for="hora_inicio">Hora de Inicio:</label>
                                <input type="time" class="form-control" id="hora_inicio" name="hora_inicio" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Iniciar Caja</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require(ROOT_VIEW . '/templates/footer.php') ?>

