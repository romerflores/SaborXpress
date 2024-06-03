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

?>
<?php require(ROOT_VIEW . '/templates/header.php') ?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="container">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Pedidos</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Descripcion</th>
                                        <th>Cantidad</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $suma = 0;
                                    foreach ($_SESSION['venta']['producto'] as $producto) {
                                        echo "<tr>";
                                        echo "<th>" . $producto[0] . "</th>";
                                        echo "<th>" . $producto[1] . "</th>";
                                        echo "<th>" . $producto[2] . "</th>";
                                        echo "<th>" . $producto[3] * $producto[2] . "</th>";
                                        echo "</tr>";
                                        $suma = $suma + $producto[3] * $producto[2];
                                    }
                                    $_SESSION['venta']['total']=$suma;
                                    ?>

                                </tbody>

                            </table>
                            <div class="input-group m-4" style="max-width: 500px;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-primary text-white">Total $</span>
                                </div>
                                <input type="text" class="form-control" value="<?php echo $suma ?>" disabled>
                            </div>
                            <a href="<?php echo HTTP_BASE; ?>/ventas/ventas" type="button" class="btn btn-primary btn-rounded btn-fw">Cancelar Venta</a>
                            <?php
                            if (isset($_SESSION['venta']['producto']) && count($_SESSION['venta']['producto']) > 0) {
                                echo '<a href="'.HTTP_BASE.'/ventas/cliente" type="button" class="btn btn-success btn-rounded btn-fw">Generar Boleta</a>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container mt-4" id="categorias">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title">Categorias</h1>
                        <form action="" method="POST">
                            <div class="form-group" style="max-width: 500px;">
                                <div class="input-group">
                                    <input type="filter" class="form-control" placeholder="Buscar" aria-label="Recipient's username" value="<?php echo $filter; ?>" name="filter">
                                    <div class="input-group-append">
                                        <button class="btn btn-sm btn-primary" type="submit">Buscar Categoria</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nombre Categoria</th>
                                        <th>Mostrar Productos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($records as $categoria) : ?>
                                        <tr>
                                            <td><?= htmlspecialchars($categoria['id_categoria'] ?? '') ?></td>
                                            <td><?= htmlspecialchars($categoria['nombre_categoria'] ?? '') ?></td>
                                            <td>
                                                <a href="<?= HTTP_BASE . '/ventas/seleccionarProducto/' . $categoria['id_categoria'] ?>" class="btn btn-info">Mostrar productos</a>
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