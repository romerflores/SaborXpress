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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $id_producto = trim($_POST['id_producto']);
    $descripcion = trim($_POST['descripcion_producto']);
    $precio = trim($_POST['precio_producto']);
    $estado = trim($_POST['estado_producto']);
    $categoria = trim($_POST['categoria_id_categoria']);

    // Validar los datos antes de enviarlos
    if ($id_producto && $descripcion && $precio && $estado && $categoria) {
        // Preparar la URL para la solicitud POST
        $url = HTTP_BASE . "/controller/ProductoController.php";
        
        // Crear datos para enviar
        $data = array(
            'id_producto' => $id_producto,
            'descripcion_producto' => $descripcion,
            'precio_producto' => $precio,
            'estado_producto' => $estado,
            'categoria_id_categoria' => $categoria,
            'ope' => 'update' // Operación de actualización
        );

        // Configurar opciones de la solicitud POST
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );

        // Crear contexto de la solicitud
        $context  = stream_context_create($options);
        
        // Enviar solicitud y obtener respuesta
        $response = file_get_contents($url, false, $context);
        
        // Manejar la respuesta
        if ($response === FALSE) {
            echo "Error al actualizar el producto.";
        } else {
            echo "Producto actualizado exitosamente.";
        }
    } else {
        echo "Todos los campos son obligatorios.";
    }
} else {
    // Obtener el ID del producto a editar de la URL
    $id_producto = isset($_GET['id_producto']) ? $_GET['id_producto'] : '';

    // Validar si se ha proporcionado un ID
    if ($id_producto) {
        // Preparar la URL para obtener los detalles del producto
        $url = HTTP_BASE . "/controller/ProductoController.php?ope=filterId&id_producto=" . $id_producto;

        // Obtener detalles del producto
        $response = file_get_contents($url);
        $producto = json_decode($response, true);

        // Validar si se encontró el producto y si la clave 'id_producto' está definida
        if (!$producto || !isset($producto['id_producto'])) {
            echo "ID de producto no proporcionado o producto no encontrado.";
            exit;
        }
    } else {
        echo "ID de producto no proporcionado.";
    }
}

// Incluir pie de página
require(ROOT_VIEW . '/templates/footer.php'); ?>
