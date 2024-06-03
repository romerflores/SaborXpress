<?php
$id_producto=$_POST['id_producto'];
$descripcion_producto=$_POST['descripcion_producto'];
$cantidad=$_POST['cantidad'];
$precio_producto=$_POST['precio_producto'];

$categoria_id_categoria=$_POST['categoria_id_categoria'];

array_push($_SESSION['venta']['producto'],[$id_producto,$descripcion_producto,$cantidad,$precio_producto,$categoria_id_categoria]);
echo '<script>window.location.href ="' . HTTP_BASE . '/ventas/seleccionarCategoria"</script>';


// 0=id_producto
// 2=cantidad
// 3=precio_producto
// 4=categoria_id_categoria
?>