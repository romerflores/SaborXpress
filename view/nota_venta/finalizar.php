<?php

//crear nota de venta:

$ope = 'crearNota';
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
            echo '<script>alert("Venta efectuda exitosamente");</script>';
            //crearemos los pedidos
            $url_pedido = HTTP_BASE . "/controller/PedidoController.php";
            $swtodo = true;
            foreach ($_SESSION['venta']['producto'] as $producto) {
                // 0=id_producto
                // 2=cantidad
                // 3=precio_producto
                // 4=categoria_id_categoria
                $data_pedido = array(
                    'ope' => 'insert', // Operación de inserción
                    'cantidad' => $producto[2],
                    'sub_total' => ($producto[3] * $producto[2]),
                    'producto_categoria_id_categoria' => $producto[4],
                    'producto_id_producto' => $producto[0],
                    'nota_venta_numero_venta' => $result['nro_venta'],
                );
                //echo " cant".$producto[2]." subtotla ".($producto[3] * $producto[2])." id cat ".$producto[4]." id prod".$producto[0]." nro venta".$result['nro_venta'];
                $context_pedido = stream_context_create([
                    'http' => [
                        'method' => 'POST',
                        'header' => "Content-Type: application/json",
                        'content' => json_encode($data_pedido),
                    ]
                ]);
                $response_pedido = file_get_contents($url_pedido, false, $context_pedido);
                $result_pedido = json_decode($response_pedido, true);
                $swtodo = $swtodo && $result_pedido["ESTADO"];
                if (!$result_pedido["ESTADO"]) {
                    echo '<script>alert("Error con pedido");</script>';
                }
            }
            if (!$swtodo) {
                echo '<script>alert("Ha ocurrido un error con alguno de los Campos");</script>';
            } else {
                //reseteamos las sesion
                $_SESSION['venta']['producto'] = [];
                $_SESSION['venta']['total'] = 0;
                $_SESSION['venta']['id_cliente'] = "";
                $_SESSION['venta']['razon_social'] = "";
                echo '<script>window.location.href="' . HTTP_BASE . '/reporte/nota_venta/'.$result['nro_venta'].'"</script>';
            }
        } else {
            echo '<script>alert("Ha ocurrido un error. xd");</script>';
        }
    } catch (Exception $e) {
        echo '<script>alert("Ocurrió un error al guardar.");</script>';
    }
} else {
    echo '<script>alert("Todos los campos son obligatorios");</script>';
}
