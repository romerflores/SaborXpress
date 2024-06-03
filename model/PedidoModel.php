<?php
include_once "../core/ModeloBasePDO.php";
class PedidoModel extends ModeloBasePDO
{
    public function __construct()
    {
        parent::__construct();
    }
    public function findAll() //Esto listara todos los pedidos con su producto y categoria respectiva
    {
        $sql = "SELECT id_pedido, cantidad, sub_total, nota_venta_nro_venta, producto.descripcion_producto, categoria.nombre_categoria 
        FROM pedido 
        INNER JOIN producto 
        ON producto_id_producto= producto.id_producto 
        INNER JOIN categoria 
        ON categoria.id_categoria=producto_categoria_id_categoria; ";
        $param = array();
        return parent::gselect($sql, $param);
    }
    public function findid($p_id_pedido) //buscar por carnet
    {
        $sql = "SELECT id_pedido, cantidad, sub_total, nota_venta_nro_venta, producto.descripcion_producto, categoria.nombre_categoria 
        FROM pedido 
        INNER JOIN producto 
        ON producto_id_producto= producto.id_producto 
        INNER JOIN categoria 
        ON categoria.id_categoria=producto_categoria_id_categoria
        WHERE id_pedido=:p_id_pedido";
        $param = array();
        //tenemos el atributo como string ya que el id(carnet o nit) puede tener complemento
        array_push($param, [':p_id_pedido', $p_id_pedido, PDO::PARAM_STR]);
        return parent::gselect($sql, $param);
    }
    public function findpaginateall($p_filtro, $p_limit, $p_offset)
    {
        $sql = "SELECT id_pedido, cantidad, sub_total, nota_venta_nro_venta, producto.descripcion_producto, categoria.nombre_categoria 
        FROM pedido 
        INNER JOIN producto 
        ON producto_id_producto= producto.id_producto 
        INNER JOIN categoria 
        ON categoria.id_categoria=producto_categoria_id_categoria
        WHERE upper(concat(IFNULL(id_pedido,''),IFNULL(cantidad,''),IFNULL(sub_total,''),IFNULL(nota_venta_nro_venta,''),IFNULL(producto.descripcion_producto,''),IFNULL(categoria.nombre_categoria,''))) 
        like concat('%',upper(IFNULL(:p_filtro,'')),'%') 
        limit :p_limit
        offset :p_offset"; //limit es para la cantidad de registros que se mostrara, y el offset es para decir desde que numero empezara la consulta
        $param = array();
        array_push($param, [':p_filtro', $p_filtro, PDO::PARAM_STR]);
        array_push($param, [':p_limit', $p_limit, PDO::PARAM_INT]);
        array_push($param, [':p_offset', $p_offset, PDO::PARAM_INT]);

        //toda la respuesta a la consulta de la busqueda se guarda en la variable var
        $var = parent::gselect($sql, $param);
        //esto es para contar
        $sqlcount = "SELECT count(1) as cant
        FROM pedido 
        INNER JOIN producto 
        ON producto_id_producto= producto.id_producto 
        INNER JOIN categoria 
        ON categoria.id_categoria=producto_categoria_id_categoria
        WHERE upper(concat(IFNULL(id_pedido,''),IFNULL(cantidad,''),IFNULL(sub_total,''),IFNULL(nota_venta_nro_venta,''),IFNULL(producto.descripcion_producto,''),IFNULL(categoria.nombre_categoria,''))) 
        like concat('%',upper(IFNULL(:p_filtro,'')),'%')  ";
        $param = array();
        array_push($param, [':p_filtro', $p_filtro, PDO::PARAM_STR]);
        $var1 =  parent::gselect($sqlcount, $param);
        $var['LENGTH'] = $var1['DATA'][0]['cant'];
        return $var;
    }
    public function insertar($p_cantidad, $p_sub_total, $p_nota_venta_nro_venta, $p_producto_id_producto, $p_producto_categoria_id_categoria) //crear pedido
    {
        $p_estado = 'ACTIVO';
        $sql = "INSERT INTO pedido(cantidad, sub_total, nota_venta_nro_venta, producto_id_producto, producto_categoria_id_categoria) 
        VALUES (:p_cantidad,:p_sub_total,:p_nota_venta_nro_venta,:p_producto_id_producto,:p_producto_categoria_id_categoria)";
        $param = array();
        array_push($param, [':p_cantidad', $p_cantidad, PDO::PARAM_INT]);
        array_push($param, [':p_sub_total', $p_sub_total, PDO::PARAM_STR]);
        array_push($param, [':p_nota_venta_nro_venta', $p_nota_venta_nro_venta, PDO::PARAM_INT]);
        array_push($param, [':p_producto_id_producto', $p_producto_id_producto, PDO::PARAM_INT]);
        array_push($param, [':p_producto_categoria_id_categoria', $p_producto_categoria_id_categoria, PDO::PARAM_STR]);

        return parent::ginsert($sql, $param);
    }
}
