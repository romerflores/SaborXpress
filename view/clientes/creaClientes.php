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

// Verificar si la solicitud es POST para manejar la creación del cliente
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $id_cliente = trim($_POST['id_cliente']);
    $razon_social = trim($_POST['razon_social']);
    try {
        $data = array(
            'ope' => 'create',
            'id_cliente' => $id_cliente,
            'razon_social' => $razon_social,
        );
        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => "Content-Type: application/json",
                'content' => json_encode($data),
            ]
        ]);
        $url = HTTP_BASE . "/controller/ClienteController.php";
        $response = file_get_contents($url, false, $context);
        $result = json_decode($response, true);
        if ($result["ESTADO"]) {
            echo '<script>alert("Registro Guardado Exitosamente.");</script>';
        } else {
            echo '<script>alert("No se Puede Guardar.");</script>';
        }
    } catch (Exception $e) {
        echo '<script>alert("Ocurrió un error al guardar.");</script>';
    }
}
?>


<?php require(ROOT_VIEW . '/templates/header.php');?>
   <!-- Caja para los formularios -->
   <div class="container-fluid">
       <div class="row">
           <div class="col-lg-12">
               <div class="card">
                   <div class="card-body">
                       <!-- Formularios de Modificar y Crear Cliente -->
                       <div class="row">
                           <!-- Crear Cliente -->
                           <div class="col-lg-6 col-md-6 grid-margin stretch-card">
                               <div class="card">
                                   <div class="card-body">
                                       <h4 class="card-title">Agregar Cliente</h4>
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
                                            <button type="submit" class="btn btn-primary">Agregar Cliente</button>
                                        </form> 
                                   </div>
                               </div>
                           </div>

                           <!-- Modificar Cliente -->
                           <div class="col-lg-6 col-md-6 grid-margin stretch-card">
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
                       </div>
                       <!-- Fin de los formularios -->
                   </div>
               </div>
           </div>
       </div>
   </div>
<?php require(ROOT_VIEW . '/templates/footer.php') ?>



