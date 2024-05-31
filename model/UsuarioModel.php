<?php
include_once "../core/ModeloBasePDO.php";
class UsuarioModel extends ModeloBasePDO
{
    public function __construct()
    {
        parent::__construct();
    }
    //consultar si se añadira el campo de rol
    public function findAll()
    {
        $sql = "SELECT id_usuario, nombre, apellido, ci, fecha_nacimiento, fecha_alta FROM usuario";
        $param = array();
        return parent::gselect($sql, $param);
    }
    public function findid($p_id_usuario)
    {
        $sql="SELECT id_usuario, nombre, apellido, ci, fecha_nacimiento, fecha_alta FROM usuario WHERE id_usuario=:p_id_usuario";
        $param= array();
        //tenemos el atributo como string ya que el id(carnet o nit) puede tener complemento
        array_push($param,[':p_id_usuario',$p_id_usuario,PDO::PARAM_INT]);
        return parent::gselect($sql, $param);
    }
    public function findpaginateall($p_filtro, $p_limit, $p_offset)
    {
        $sql = "SELECT id_usuario, nombre, apellido, ci, fecha_nacimiento, fecha_alta 
        FROM usuario 
        WHERE upper(concat(IFNULL(id_usuario,''),IFNULL(nombre,''),IFNULL(apellido,''),IFNULL(ci,''),IFNULL(fecha_nacimiento,''),IFNULL(fecha_alta,''))) 
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
        FROM usuario
        WHERE upper(concat(IFNULL(id_usuario,''),IFNULL(nombre,''),IFNULL(apellido,''),IFNULL(ci,''),IFNULL(fecha_nacimiento,''),IFNULL(fecha_alta,''))) 
        like concat('%',upper(IFNULL(:p_filtro,'')),'%')";
        $param = array();
        array_push($param, [':p_filtro', $p_filtro, PDO::PARAM_STR]);
        $var1 =  parent::gselect($sqlcount, $param);
        $var['LENGTH'] = $var1['DATA'][0]['cant'];
        return $var;
    }
    public function register($p_nombre,$p_apellido,$p_ci,$p_fecha_nacimiento,$p_password,$p_rol)
    {
        $sql="INSERT INTO usuario(nombre, apellido, ci, fecha_nacimiento, fecha_alta,password,rol) 
        VALUES (:p_nombre,:p_apellido,:p_ci,:p_fecha_nacimiento,NOW(),:p_password,:p_rol);";
        $param=array();
        array_push($param,[':p_nombre',$p_nombre,PDO::PARAM_STR]);
        array_push($param,[':p_apellido',$p_apellido,PDO::PARAM_STR]);
        array_push($param,[':p_ci',$p_ci,PDO::PARAM_STR]);
        array_push($param,[':p_fecha_nacimiento',$p_fecha_nacimiento,PDO::PARAM_STR]);
        array_push($param,[':p_password',$p_password,PDO::PARAM_STR]);
        array_push($param,[':p_rol',$p_rol,PDO::PARAM_STR]);

        return parent::ginsert($sql, $param);
    }

    public function update($p_id_usuario,$p_nombre,$p_apellido,$p_ci,$p_fecha_nacimiento)
    {
        $sql = "UPDATE usuario 
        SET nombre=':p_nombre',apellido=':p_apellido',ci=':p_ci',fecha_nacimiento=':p_fecha_nacimiento' 
        WHERE id_usuario=':p_id_usuario';";
        $param = array();

        array_push($param, [':p_id_usuario', $p_id_usuario, PDO::PARAM_INT]);
        array_push($param,[':p_nombre',$p_nombre,PDO::PARAM_STR]);
        array_push($param,[':p_apellido',$p_apellido,PDO::PARAM_STR]);
        array_push($param,[':p_ci',$p_ci,PDO::PARAM_STR]);
        array_push($param,[':p_fecha_nacimiento',$p_fecha_nacimiento,PDO::PARAM_STR]);
        return parent::gupdate($sql, $param);
    }

    public function verificarLogin($p_ci,$p_password)
    {
        $sql="SELECT nombre,apellido,ci,password
        FROM usuario 
        WHERE ci=:p_ci AND password=:p_password";
        $param = array();

        array_push($param, [':p_ci', $p_ci, PDO::PARAM_STR]);
        array_push($param,[':p_password',$p_password,PDO::PARAM_STR]);
        return parent::gselect($sql,$param);
    }

}