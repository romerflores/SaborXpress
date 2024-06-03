<?php

//crear nota de venta:

$ope = 'insert';
$total = $_SESSION['venta']['total'];
$id_cliente = $_SESSION['venta']['id_cliente'];
$ci_usuario = $_SESSION['login']['ci_usuario'];


// Validar los datos antes de enviarlos
if ($total && $id_cliente && $ci_usuario) {
    // Preparar la URL para la solicitud POST
    $url = HTTP_BASE . "/controller/Nota_VentaController.php";

    // Crear datos para enviar
    try {
        $data = array(
            'ope' => $ope, // Operación de inserción
            'total' => $total,
            'cliente_id_cliente' => $id_cliente,
            'usuario_ci_usuario' => $ci_usuario,
        );
        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => "Content-Type: application/json",
                'content' => json_encode($data),
            ]
        ]);
        $response = file_get_contents($url, false, $context);
        $result = json_decode($response, true);
        // Manejar la respuesta
        if ($result["ESTADO"]) {
            echo '<script>alert("Producto agregado exitosamente.");</script>';
            echo '<script>window.location.href ="' . HTTP_BASE . '/productos/prod-listado"</script>';
        } else {
            echo '<script>alert("Ha ocurrido un error. xd");</script>';
        }
    } catch (Exception $e) {
        echo '<script>alert("Ocurrió un error al guardar.");</script>';
    }
} else {
    echo '<script>alert("Todos los campos son obligatorios");</script>';
}
