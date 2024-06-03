<?php
$id_producto=$_POST['id_producto'];
$descripcion_producto=$_POST['descripcion_producto'];
$cantidad=$_POST['cantidad'];
$precio_producto=$_POST['precio_producto'];
array_push($_SESSION['venta']['producto'],[$id_producto,$descripcion_producto,$cantidad,$precio_producto]);
echo '<script>window.location.href ="' . HTTP_BASE . '/ventas/seleccionarCategoria"</script>';
?>