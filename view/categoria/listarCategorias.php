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

$url = HTTP_BASE . "/controller/CategoriaController.php?ope=filterSearch&page=" . $page . "&filter=" . $filter;
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

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="container">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Categorias</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nombre Categoria</th>
                                        <th>Editar Categoria</th>
                                        <th>Mostrar Productos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($records as $categoria) : ?>
                                        <tr>
                                            <td><?= htmlspecialchars($categoria['id_categoria'] ?? '') ?></td>
                                            <td><?= htmlspecialchars($categoria['nombre_categoria'] ?? '') ?></td>
                                            <td>
                                                <a href="<?= HTTP_BASE . '/categorias/editar/' . $categoria['id_categoria'] ?>" class="btn btn-warning">Modificar</a>
                                            </td>
                                            <td>
                                                
                                                <a href="<?= HTTP_BASE . '/categorias/filtrarCategoria/' . $categoria['id_categoria'] ?>" class="btn btn-info">Mostrar productos</a>
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


<?php require(ROOT_VIEW . '/templates/footer.php') ?>