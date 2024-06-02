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

// Manejo del método POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $descripcion = trim($_POST['descripcion_producto']);
    $precio = trim($_POST['precio_producto']);
    $estado = trim($_POST['estado_producto']);
    $categoria = trim($_POST['categoria_id_categoria']);

    // Validar los datos antes de enviarlos
    if ($descripcion && $precio && $estado && $categoria) {
        // Preparar la URL para la solicitud POST
        $url = HTTP_BASE . "/controller/ProductoController.php";
        
        // Crear datos para enviar
        $data = array(
            'descripcion_producto' => $descripcion,
            'precio_producto' => $precio,
            'estado_producto' => $estado,
            'categoria_id_categoria' => $categoria,
            'ope' => 'insert' // Operación de inserción
        );

        // Configurar opciones de la solicitud POST
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/json\r\n",
                'method'  => 'POST',
                'content' => json_encode($data)
            )
        );

        // Crear contexto de la solicitud
        $context  = stream_context_create($options);
        
        // Enviar solicitud y obtener respuesta
        $response = file_get_contents($url, false, $context);
        
        // Manejar la respuesta
        if ($response === FALSE) {
            echo "Error al crear el producto.";
        } else {
            echo "Producto creado exitosamente.";
        }
    } else {
        echo "Todos los campos son obligatorios.";
    }
}


require(ROOT_VIEW . '/templates/footer.php'); ?>
