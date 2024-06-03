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
        $sql = "SELECT 
        p.id_producto, 
        p.descripcion_producto, 
        p.precio_producto, 
        p.estado_producto, 
        c.nombre_categoria 
        FROM 
        producto p
        JOIN 
        categoria c 
        ON 
        p.categoria_id_categoria = c.id_categoria;";
        $param = array();
        return parent::gselect($sql, $param);
    }

    //filtrar por id
    public function findid($p_id_producto)
    {
        $sql = "SELECT 
        p.id_producto, 
        p.descripcion_producto, 
        p.precio_producto, 
        p.estado_producto, 
        c.nombre_categoria 
        FROM 
        producto p
        JOIN 
        categoria c 
        ON 
        p.categoria_id_categoria = c.id_categoria
        WHERE 
        p.id_producto = :p_id_producto;";
        $param = array();
        //aca adicionamos el array de parametros, donde pdo::param_int es para protegernos de sqlinjetion
        array_push($param, [':p_id_producto', $p_id_producto, PDO::PARAM_INT]);
        return parent::gselect($sql, $param);
    }

    //paginacion
    public function findpaginateall($p_filtro, $p_limit, $p_offset)
    {
        $sql = "SELECT 
        p.id_producto, 
        p.descripcion_producto, 
        p.precio_producto, 
        p.estado_producto, 
        c.nombre_categoria 
        FROM 
        producto p
        JOIN 
        categoria c 
        ON 
        p.categoria_id_categoria = c.id_categoria
        WHERE upper(concat(IFNULL(id_producto,''),IFNULL(descripcion_producto,''),IFNULL(precio_producto,''),IFNULL(estado_producto,''),IFNULL(c.nombre_categoria,''))) 
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
        FROM 
        producto p
        JOIN 
        categoria c 
        ON 
        p.categoria_id_categoria = c.id_categoria
        WHERE upper(concat(IFNULL(id_producto,''),IFNULL(descripcion_producto,''),IFNULL(precio_producto,''),IFNULL(estado_producto,''),IFNULL(c.nombre_categoria,''))) 
        like concat('%',upper(IFNULL(:p_filtro,'')),'%')";
        $param = array();
        array_push($param, [':p_filtro', $p_filtro, PDO::PARAM_STR]);
        $var1 =  parent::gselect($sqlcount, $param);
        $var['LENGTH'] = $var1['DATA'][0]['cant'];
        return $var;
    }


    //crear nuevo producto
    public function insert($p_descripcion_producto, $p_precio_producto, $p_estado_producto,$p_categoria_id_categoria)
    {
        //sugiero mandar la categoria por medio de un select, ya que solo asumiremos o bien la categoria o el id
        $sql = "INSERT INTO producto(descripcion_producto, precio_producto, estado_producto, categoria_id_categoria) 
        VALUES (:p_descripcion_producto,:p_precio_producto,:p_estado_producto,:p_categoria_id_categoria)";
        $param = array();

        array_push($param, [':p_descripcion_producto', $p_descripcion_producto, PDO::PARAM_STR]);
        array_push($param, [':p_precio_producto', $p_precio_producto, PDO::PARAM_STR]);
        array_push($param, [':p_estado_producto', $p_estado_producto, PDO::PARAM_STR]);
        array_push($param, [':p_categoria_id_categoria', $p_categoria_id_categoria, PDO::PARAM_STR]);

        return parent::ginsert($sql, $param);
    }

    //deshabilitar un producto
    public function delete($p_id_producto)
    {
        //no se borrara como tal, si no que se pondra activo o no activo
        $p_estado_producto = 'INACTIVO';
        $sql = "UPDATE producto SET estado_producto=:p_estado_producto WHERE id_producto=:p_id_producto";
        $param = array();
        array_push($param, [':p_id_producto', $p_id_producto, PDO::PARAM_INT]);
        array_push($param, [':p_estado_producto', $p_estado_producto, PDO::PARAM_STR]);

        return parent::gdelete($sql, $param);
    }

    //actualizar un productos
    public function update($p_id_producto, $p_descripcion_producto, $p_precio_producto, $p_estado_producto,$p_categoria_id_categoria)
    {
        $sql = "UPDATE producto 
        SET
        descripcion_producto=:p_descripcion_producto,
        precio_producto=:p_precio_producto,
        estado_producto=:p_estado_producto,
        categoria_id_categoria=:p_categoria_id_categoria
        WHERE id_producto=:p_id_producto";
        $param = array();

        array_push($param, [':p_id_producto', $p_id_producto, PDO::PARAM_INT]);
        array_push($param, [':p_descripcion_producto', $p_descripcion_producto, PDO::PARAM_STR]);
        array_push($param, [':p_precio_producto', $p_precio_producto, PDO::PARAM_STR]);
        array_push($param, [':p_estado_producto', $p_estado_producto, PDO::PARAM_STR]);
        array_push($param, [':p_categoria_id_categoria', $p_categoria_id_categoria, PDO::PARAM_STR]);

        return parent::gupdate($sql, $param);
    }
}
