<?php
include_once('../core/ModeloBasePDO.php');

class Nota_VentaModel extends ModeloBasePDO
{
    public function __construct()
    {
        parent::__construct();
    }

    public function findAll()
    {
        $sql = "SELECT 
        nv.nro_venta, 
        nv.fecha_venta, 
        nv.hora_venta, 
        nv.total, 
        nv.cliente_id_cliente, 
        nv.usuario_ci_usuario,
        p.id_pedido, 
        p.cantidad, 
        p.sub_total,
        pr.descripcion_producto, 
        pr.precio_producto
        FROM nota_venta nv
        JOIN pedido p ON nv.nro_venta = p.nota_venta_nro_venta
        JOIN producto pr ON p.producto_id_producto = pr.id_producto;";
        $param = array();
        return parent::gselect($sql,$param);
    }
    public function findid($p_nro_venta)
    {
        $sql = "SELECT 
        nv.nro_venta, 
        nv.fecha_venta, 
        nv.hora_venta, 
        nv.total, 
        nv.cliente_id_cliente, 
        nv.usuario_ci_usuario,
        p.id_pedido, 
        p.cantidad, 
        p.sub_total,
        pr.descripcion_producto, 
        pr.precio_producto
        FROM nota_venta nv
        JOIN pedido p ON nv.nro_venta = p.nota_venta_nro_venta
        JOIN producto pr ON p.producto_id_producto = pr.id_producto
        WHERE nv.nro_venta=:p_nro_venta";
        $param = array();
        array_push($param,[':p_nro_venta',$p_nro_venta,PDO::PARAM_INT]);

        return parent::gselect($sql,$param);
    }
    public function findpaginateall($p_filtro, $p_limit, $p_offset)
    {
        $sql = "SELECT 
        nv.nro_venta, 
        nv.fecha_venta, 
        nv.hora_venta, 
        nv.total, 
        nv.cliente_id_cliente, 
        nv.usuario_ci_usuario,
        p.id_pedido, 
        p.cantidad, 
        p.sub_total,
        pr.descripcion_producto, 
        pr.precio_producto
        FROM nota_venta nv
        JOIN pedido p ON nv.nro_venta = p.nota_venta_nro_venta
        JOIN producto pr ON p.producto_id_producto = pr.id_producto
        WHERE upper(concat(IFNULL(nro_venta,''),IFNULL(fecha_venta,''),IFNULL(hora_venta,''),IFNULL(total,''),IFNULL(cliente_id_cliente,''),IFNULL(usuario_ci_usuario,''),IFNULL(p.id_pedido,''),IFNULL(p.cantidad,''),IFNULL(p.sub_total,''),IFNULL(pr.descripcion_producto,''),IFNULL(pr.precio_producto,''))) 
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
        FROM nota_venta nv
        JOIN pedido p ON nv.nro_venta = p.nota_venta_nro_venta
        JOIN producto pr ON p.producto_id_producto = pr.id_producto
        WHERE upper(concat(IFNULL(nro_venta,''),IFNULL(fecha_venta,''),IFNULL(hora_venta,''),IFNULL(total,''),IFNULL(cliente_id_cliente,''),IFNULL(usuario_ci_usuario,''),IFNULL(p.id_pedido,''),IFNULL(p.cantidad,''),IFNULL(p.sub_total,''),IFNULL(pr.descripcion_producto,''),IFNULL(pr.precio_producto,''))) 
        like concat('%',upper(IFNULL(:p_filtro,'')),'%') ";
        $param = array();
        array_push($param, [':p_filtro', $p_filtro, PDO::PARAM_STR]);
        $var1 =  parent::gselect($sqlcount, $param);
        $var['LENGTH'] = $var1['DATA'][0]['cant'];
        return $var;
    }

    public function insert($p_total, $p_cliente_id_cliente, $p_usuario_ci_usuario) //crear nota de venta
    {
        $sql="INSERT 
        INTO nota_venta( fecha_venta, hora_venta, total, cliente_id_cliente, usuario_ci_usuario) 
        VALUES (CURDATE(),CURTIME(),:p_total,:p_cliente_id_cliente,:p_usuario_ci_usuario)";

        $param = array();

        array_push($param,[':p_total'],$p_total,PDO::PARAM_STR);
        array_push($param,[':p_cliente_id_cliente'],$p_cliente_id_cliente,PDO::PARAM_STR);
        array_push($param,[':p_usuario_ci_usuario'],$p_usuario_ci_usuario,PDO::PARAM_STR);

        return parent::ginsert($sql,$param);
    }
    //borrar nota de venta
    
}
