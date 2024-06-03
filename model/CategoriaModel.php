<?php
include_once "../core/ModeloBasePDO.php";

class categoriaModel extends ModeloBasePDO
{
    public function __construct()
    {
        parent::__construct();
    }
    //filtrar todos los categorias
    public function findAll()
    {
        $sql = "SELECT id_categoria, nombre_categoria FROM categoria";
        $param = array();
        return parent::gselect($sql, $param);
    }

    //filtrar categoria por id

    public function findid($p_id_categoria)
    {
        $sql="SELECT id_categoria, nombre_categoria FROM categoria WHERE id_categoria=:p_id_categoria";
        $param= array();
        //tenemos el atributo como string ya que el id(carnet o nit) puede tener complemento
        array_push($param,[':p_id_categoria',$p_id_categoria,PDO::PARAM_STR]);
        return parent::gselect($sql, $param);
    }
    public function findpaginateall($p_filtro, $p_limit, $p_offset)
    {
        $sql = "SELECT id_categoria, nombre_categoria 
        FROM categoria 
        WHERE upper(concat(IFNULL(id_categoria,''),IFNULL(nombre_categoria,''))) 
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
        FROM categoria
        WHERE  upper(concat(IFNULL(id_categoria,''),IFNULL(nombre_categoria,''))) 
        like concat('%',upper(IFNULL(:p_filtro,'')),'%')";
        $param = array();
        array_push($param, [':p_filtro', $p_filtro, PDO::PARAM_STR]);
        $var1 =  parent::gselect($sqlcount, $param);
        $var['LENGTH'] = $var1['DATA'][0]['cant'];
        return $var;
    }

    //crear nuevo categoria
    public function insert($p_id_categoria,$p_nombre_categoria)
    {
        $sql="INSERT INTO categoria(id_categoria, nombre_categoria) VALUES (:p_id_categoria,:p_nombre_categoria); ";
        $param=array();
        array_push($param,[':p_id_categoria',$p_id_categoria,PDO::PARAM_STR]);
        array_push($param,[':p_nombre_categoria',$p_nombre_categoria,PDO::PARAM_STR]);

        return parent::ginsert($sql, $param);
    }

    //para modificar un categoria
    public function update($p_id_categoria,$p_nombre_categoria)
    {

        $sql="UPDATE categoria SET nombre_categoria=:p_nombre_categoria WHERE id_categoria=:p_id_categoria";
        $param=array();
        array_push($param,[':p_id_categoria',$p_id_categoria,PDO::PARAM_STR]);
        array_push($param,[':p_nombre_categoria',$p_nombre_categoria,PDO::PARAM_STR]);

        return parent::gupdate($sql,$param);
    }

    
}