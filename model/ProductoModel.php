<?php
include_once "../core/ModeloBasePDO.php";

class ProductoModel extends ModeloBasePDO
{
    public function __construct()
    {
        parent::__construct();
    }

    //filtrar todo
    public function findall()
    {
        $sql = "SELECT id_producto, descripcion_producto, precio, estado FROM producto";
        $param = array();
        return parent::gselect($sql, $param);
    }

    //filtrar por id
    public function findid($p_id_producto)
    {
        $sql = "SELECT id_producto, descripcion_producto, precio, estado FROM producto  WHERE id_producto = :p_id_producto";
        $param = array();
        //aca adicionamos el array de parametros, donde pdo::param_int es para protegernos de sqlinjetion
        array_push($param, [':p_id_producto', $p_id_producto, PDO::PARAM_INT]);
        return parent::gselect($sql, $param);
    }

    //paginacion
    public function findpaginateall($p_filtro, $p_limit, $p_offset)
    {
        $sql = "SELECT id_producto, descripcion_producto, precio, estado 
        FROM producto 
        WHERE upper(concat(IFNULL(id_producto,''),IFNULL(descripcion_producto,''),IFNULL(precio,''),IFNULL(estado,''))) 
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
        FROM producto
        WHERE  upper(concat(IFNULL(id_producto,''),IFNULL(descripcion_producto,''),IFNULL(precio,''),IFNULL(estado,''))) 
        like CONCAT('%',upper(IFNULL(:p_filtro,'' )), '%')";
        $param = array();
        array_push($param, [':p_filtro', $p_filtro, PDO::PARAM_STR]);
        $var1 =  parent::gselect($sqlcount, $param);
        $var['LENGTH'] = $var1['DATA'][0]['cant'];
        return $var;
    }


    //crear nuevo producto
    public function insert($p_descripcion_producto, $p_precio, $p_estado)
    {
        $sql = "INSERT INTO producto(descripcion_producto, precio, estado) 
        VALUES (:p_descripcion_producto, :p_precio, :p_estado)";
        $param = array();

        array_push($param, [':p_descripcion_producto', $p_descripcion_producto, PDO::PARAM_STR]);

        //PREGUNTAR POR FLOAT:
        array_push($param, [':p_precio', $p_precio, PDO::PARAM_INT]);
        array_push($param, [':p_estado', $p_estado, PDO::PARAM_BOOL]);

        return parent::ginsert($sql, $param);
    }

    //deshabilitar un producto
    public function delete($p_id_producto)
    {
        //no se borrara como tal, si no que se pondra activo o no activo
        $p_estado=false;
        $sql = "UPDATE producto SET estado=':p_estado' WHERE id_producto=:p_id_producto";
        $param = array();
        array_push($param, [':p_id_producto', $p_id_producto, PDO::PARAM_INT]);
        array_push($param, [':p_estado', $p_estado, PDO::PARAM_BOOL]);

        return parent::gdelete($sql, $param);
    }

    //actualizar un productos
    public function update($p_id_producto, $p_descripcion_producto, $p_precio, $p_estado)
    {
        $sql = "UPDATE producto 
        SET
        descripcion_producto=':p_descripcion_producto',
        precio=':p_precio',
        estado=':p_estado' 
        WHERE id_producto=':p_id_producto'";
        $param = array();

        array_push($param, [':p_id_producto', $p_id_producto, PDO::PARAM_INT]);
        array_push($param, [':p_descripcion_producto', $p_descripcion_producto, PDO::PARAM_STR]);
        array_push($param, [':p_precio', $p_precio, PDO::PARAM_INT]);
        array_push($param, [':p_estado', $p_estado, PDO::PARAM_BOOL]);

        return parent::gupdate($sql, $param);
    }
    
}