<?php
include_once("../core/ModeloBasePDO.php");

class Detalle_CajaModel extends ModeloBasePDO
{
    public function __construct()
    {
        parent::__construct();
    }
    public function findAll()
    {
        $sql = "SELECT id_detalle, monto_inicio, monto_final, fecha_inicio, fecha_fin, hora_inicio, hora_fin FROM detalle_caja";
        $param = array();
        return parent::gselect($sql, $param);
    }
    public function findid($p_id_detalle)
    {
        $sql = "SELECT id_detalle, monto_inicio, monto_final, fecha_inicio, fecha_fin, hora_inicio, hora_fin 
        FROM detalle_caja 
        WHERE id_detalle=:p_detalle";
        $param = array();
        array_push($param, [':p_id_detalle', $p_id_detalle, PDO::PARAM_INT]);
        return parent::gselect($sql, $param);
    }
    public function findpaginateall($p_filtro, $p_limit, $p_offset)
    {
        $sql = "SELECT id_detalle, monto_inicio, monto_final, fecha_inicio, fecha_fin, hora_inicio, hora_fin 
        FROM detalle_caja 
        WHERE upper(concat(IFNULL(id_detalle,''),IFNULL(monto_inicio,''),IFNULL(fecha_inicio,''),IFNULL(fecha_fin,''),IFNULL(hora_inicio,''),IFNULL(hora_fin,''))) 
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
        FROM detalle_caja 
        WHERE upper(concat(IFNULL(id_detalle,''),IFNULL(monto_inicio,''),IFNULL(fecha_inicio,''),IFNULL(fecha_fin,''),IFNULL(hora_inicio,''),IFNULL(hora_fin,''))) 
        like concat('%',upper(IFNULL(:p_filtro,'')),'%')  ";
        $param = array();
        array_push($param, [':p_filtro', $p_filtro, PDO::PARAM_STR]);
        $var1 =  parent::gselect($sqlcount, $param);
        $var['LENGTH'] = $var1['DATA'][0]['cant'];
        return $var;
    }
    public function abrirCaja( $p_monto_inicio)//abrir caja
    {
        $sql = "INSERT INTO detalle_caja(monto_inicio, fecha_inicio, hora_inicio) 
        VALUES (:p_monto_inicio,CURDATE(),CURTIME())";
        $param = array();
        array_push($param, [':p_monto_inicio', $p_monto_inicio, PDO::PARAM_STR]);
        return parent::ginsert($sql, $param);
    }
    public function cerrarCaja( $p_id_detalle,$p_monto_final)//cerrar caja
    {
        $sql = "UPDATE `detalle_caja` 
        SET 
        `monto_final`=:p_monto_final,
        `fecha_fin`=CURDATE(),
        `hora_fin`=CURTIME() 
        WHERE id_detalle=:p_id_detalle";
        $param = array();
        array_push($param, [':p_id_detalle', $p_id_detalle, PDO::PARAM_STR]);
        array_push($param, [':p_monto_fin', $p_monto_final, PDO::PARAM_STR]);
        return parent::gupdate($sql, $param);
    }
    public function findDate($p_inicio,$p_fin) //filtrar por un rango de fechas
    {
        $sql="SELECT 
        `id_detalle`, 
        `monto_inicio`, 
        `monto_final`, 
        `fecha_inicio`, 
        `fecha_fin`, 
        `hora_inicio`, 
        `hora_fin`
        FROM 
        `detalle_caja`
        WHERE 
        `fecha_inicio` BETWEEN :p_inicio AND :p_fin";
        $param = array();
        array_push($param, [':p_inicio', $p_inicio, PDO::PARAM_STR]);
        array_push($param, [':p_fin', $p_fin, PDO::PARAM_STR]);

        return parent::gselect($sql,$param);

    }
    public function findLast()
    {
        $sql = "SELECT id_caja, monto_inicio, monto_final, fecha_inicio, hora_inicio, fecha_fin, hora_fin 
                FROM detalle_caja 
                ORDER BY fecha_y_hora_alta DESC 
                LIMIT 1";
        $param = array(); // No se necesitan parámetros para esta consulta
    
        return parent::gselect($sql, $param); // Llamada al método de selección de la clase base del modelo
    }    
    //agregar funcion iniciar caja y cerrar caja
}
