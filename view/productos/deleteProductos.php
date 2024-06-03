<?php

$id_producto=$_GET['id_producto'] ?? NULL;



$updateData = [
    'id_producto' => $id_producto
];
$context = stream_context_create([
    'http' => [
        'method' => 'DELETE',
        'header' => "Content-Type: application/json",
        'content' => json_encode($updateData),
    ]
]);
$response = file_get_contents(HTTP_BASE . '/controller/ProductoController.php', false, $context);
$result = json_decode($response, true);
if ($result["ESTADO"]) {
    echo '<script>alert("Desctivado Correctamente.");</script>';
    echo '<script>window.location.href ="' . HTTP_BASE . '/productos/listado"</script>';
} else {
    echo '<script>alert("No se Puedo desactivar");</script>';
}
?>