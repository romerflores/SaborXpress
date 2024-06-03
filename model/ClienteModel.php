<?php
include_once "../core/ModeloBasePDO.php";

class ClienteModel extends ModeloBasePDO
{
    public function __construct()
    {
        parent::__construct();
    }
    //filtrar todos los clientes
    public function findAll()
    {
        $sql = "SELECT id_cliente, razon_social FROM cliente";
        $param = array();
        return parent::gselect($sql, $param);
    }

    //filtrar cliente por id

    public function findid($p_id_cliente)
    {
        $sql="SELECT id_cliente, razon_social FROM cliente WHERE id_cliente=:p_id_cliente";
        $param= array();
        //tenemos el atributo como string ya que el id(carnet o nit) puede tener complemento
        array_push($param,[':p_id_cliente',$p_id_cliente,PDO::PARAM_STR]);
        return parent::gselect($sql, $param);
    }
    public function findpaginateall($p_filtro, $p_limit, $p_offset)
    {
        $sql = "SELECT id_cliente, razon_social 
        FROM cliente 
        WHERE upper(concat(IFNULL(id_cliente,''),IFNULL(razon_social,''))) 
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
        FROM cliente
        WHERE  upper(concat(IFNULL(id_cliente,''),IFNULL(razon_social,''))) 
        like concat('%',upper(IFNULL(:p_filtro,'')),'%')";
        $param = array();
        array_push($param, [':p_filtro', $p_filtro, PDO::PARAM_STR]);
        $var1 =  parent::gselect($sqlcount, $param);
        $var['LENGTH'] = $var1['DATA'][0]['cant'];
        return $var;
    }

    //crear nuevo cliente
    public function insert($p_id_cliente,$p_razon_social)
    {
        $sql="INSERT INTO cliente(id_cliente, razon_social) VALUES (:p_id_cliente,:p_razon_social); ";
        $param=array();
        array_push($param,[':p_id_cliente',$p_id_cliente,PDO::PARAM_STR]);
        array_push($param,[':p_razon_social',$p_razon_social,PDO::PARAM_STR]);

        return parent::ginsert($sql, $param);
    }

    //para modificar un cliente
    public function update($p_id_cliente,$p_razon_social)
    {

        $sql="UPDATE cliente SET razon_social=:p_razon_social WHERE id_cliente=:p_id_cliente";
        $param=array();
        array_push($param,[':p_id_cliente',$p_id_cliente,PDO::PARAM_STR]);
        array_push($param,[':p_razon_social',$p_razon_social,PDO::PARAM_STR]);

        return parent::gupdate($sql,$param);
    }
}

?>