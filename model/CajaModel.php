<?php
include_once("../core/ModeloBasePDO.php");

class CajaModel extends ModeloBasePDO
{
    public function __construct()
    {
        parent::__construct();
    }
    public function findAll()
    {
        $sql = "SELECT id_caja, monto_final, monto_inicio, fecha, hora_inicio, hora_fin FROM caja";
        $param = array();
        return parent::gselect($sql, $param);
    }
    public function findid($p_id_caja)
    {
        $sql = "SELECT id_caja, monto_final, monto_inicio, fecha, hora_inicio, hora_fin FROM caja WHERE id_caja=:p_id_caja";
        $param = array();
        //tenemos el atributo como string ya que el id(carnet o nit) puede tener complemento
        array_push($param, [':p_id_caja', $p_id_caja, PDO::PARAM_INT]);
        return parent::gselect($sql, $param);
    }
    public function findpaginateall($p_filtro, $p_limit, $p_offset)
    {
        $sql = "SELECT id_caja, monto_final, monto_inicio, fecha, hora_inicio, hora_fin 
        FROM caja 
        WHERE upper(concat(IFNULL(id_caja,''),IFNULL(monto_final,''),IFNULL(monto_inicio,''),IFNULL(fecha,''),IFNULL(hora_inicio,''),IFNULL(hora_fin,''))) 
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
    public function insert($p_id_caja, $p_monto_final, $p_monto_inicio)
    {
        $sql = "INSERT INTO caja(id_caja, monto_final, monto_inicio, fecha) 
        VALUES (:p_id_caja,:p_monto_final,:p_monto_inicio,NOW())";
        $param = array();
        array_push($param, [':p_id_caja', $p_id_caja, PDO::PARAM_STR]);
        array_push($param, [':p_monto_final', $p_monto_final, PDO::PARAM_STR]);
        array_push($param, [':p_monto_inicio', $p_monto_inicio, PDO::PARAM_STR]);

        return parent::ginsert($sql, $param);
    }

    //agregar funcion iniciar caja y cerrar caja
}
