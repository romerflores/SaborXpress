<?php
// Incluir encabezado
require(ROOT_VIEW . '/templates/header.php');

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
            echo "Error al crear el producto.";
        } else {
            echo "Producto creado exitosamente.";
        }
    } else {
        echo "Todos los campos son obligatorios.";
    }
}
?>

<div class="col-lg-6 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Crear Producto</h4>
            <p class="card-description">
                <code>Formulario</code>
            </p>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="descripcion_producto">Descripción</label>
                    <input type="text" class="form-control" id="descripcion_producto" name="descripcion_producto" required>
                </div>
                <div class="form-group">
                    <label for="precio_producto">Precio</label>
                    <input type="text" class="form-control" id="precio_producto" name="precio_producto" required>
                </div>
                <div class="form-group">
                    <label for="estado_producto">Estado</label>
                    <input type="text" class="form-control" id="estado_producto" name="estado_producto" required>
                </div>
                <div class="form-group">
                    <label for="categoria_id_categoria">Categoría</label>
                    <input type="text" class="form-control" id="categoria_id_categoria" name="categoria_id_categoria" required>
                </div>
                <button type="submit" class="btn btn-primary">Crear Producto</button>
            </form>
        </div>
    </div>
</div>

<?php
// Incluir pie de página
require(ROOT_VIEW . '/templates/footer.php');
?>
