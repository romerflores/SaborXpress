<?php
include_once ('../core/ModeloBasePDO.php');

class Detalle_PedidoModel extends ModeloBasePDO
{
    public function __construct()
    {
        parent::__construct();
    }
    public function findAll() //sugiero cambiar a findallPedidos
    {
        $sql = "SELECT id_detalle_pedido, cantidad, producto_id_producto, pedido_numero_pedido, pedido_Venta_id_venta FROM detalle_pedido";
        $param = array();
        return parent::gselect($sql, $param);
    }

    //filtrar detalle pedido por id
    public function findid($p_id_detalle_pedido)
    {
        $sql = "SELECT id_detalle_pedido, cantidad, producto_id_producto, pedido_numero_pedido, pedido_Venta_id_venta 
        FROM detalle_pedido 
        WHERE id_detalle_pedido=:p_id_detalle_pedido";
        $param = array();
        //tenemos el atributo como string ya que el id(carnet o nit) puede tener complemento
        array_push($param, [':p_id_detalle_pedido', $p_id_detalle_pedido, PDO::PARAM_INT]);
        return parent::gselect($sql, $param);
    }

    public function findpaginateall($p_filtro, $p_limit, $p_offset)
    {
        $sql = "SELECT id_detalle_pedido, cantidad, producto_id_producto, pedido_numero_pedido, pedido_Venta_id_venta 
        FROM detalle_pedido
        WHERE upper(concat(IFNULL(id_detalle_pedido,''),IFNULL(cantidad,''),IFNULL(producto_id_producto,''),IFNULL(pedido_numero_pedido,''),IFNULL(pedido_Venta_id_venta,''))) 
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
        FROM caja 
        WHERE upper(concat(IFNULL(id_caja,''),IFNULL(monto_final,''),IFNULL(monto_inicio,''),IFNULL(fecha,''),IFNULL(hora_inicio,''),IFNULL(hora_fin,''))) 
        like concat('%',upper(IFNULL(:p_filtro,'')),'%') ";
        $param = array();
        array_push($param, [':p_filtro', $p_filtro, PDO::PARAM_STR]);
        $var1 =  parent::gselect($sqlcount, $param);
        $var['LENGTH'] = $var1['DATA'][0]['cant'];
        return $var;
    }
    
}
?>