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
        $sql = "SELECT `id_pedido`, `cantidad`, `sub_total`, `nota_venta_nro_venta`, producto.descripcion_producto, categoria.nombre_categoria 
        FROM pedido 
        INNER JOIN producto 
        ON producto_id_producto= producto.id_producto 
        INNER JOIN categoria 
        ON categoria.id_categoria=producto_categoria_id_categoria; ";
        $param = array();
        return parent::gselect($sql, $param);
    }
    public function findid($p_ci_usuario)//buscar por carnet
    {
        $sql="SELECT `id_pedido`, `cantidad`, `sub_total`, `nota_venta_nro_venta`, producto.descripcion_producto, categoria.nombre_categoria 
        FROM pedido 
        INNER JOIN producto 
        ON producto_id_producto= producto.id_producto 
        INNER JOIN categoria 
        ON categoria.id_categoria=producto_categoria_id_categoria;
        WHERE ";
        $param= array();
        //tenemos el atributo como string ya que el id(carnet o nit) puede tener complemento
        array_push($param,[':p_ci_usuario',$p_ci_usuario,PDO::PARAM_STR]);
        return parent::gselect($sql, $param);
    }
    public function findpaginateall($p_filtro, $p_limit, $p_offset)
    {
        $sql = "SELECT ci_usuario, nombre, apellido, fecha_nacimiento, fecha_y_hora_alta, rol_usuario, estado 
        FROM usuario
        WHERE upper(concat(IFNULL(ci_usuario,''),IFNULL(nombre,''),IFNULL(apellido,''),IFNULL(fecha_nacimiento,''),IFNULL(fecha_y_hora_alta,''),IFNULL(rol_usuario,''),IFNULL(estado,''))) 
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
        WHERE upper(concat(IFNULL(ci_usuario,''),IFNULL(nombre,''),IFNULL(apellido,''),IFNULL(fecha_nacimiento,''),IFNULL(fecha_y_hora_alta,''),IFNULL(rol_usuario,''),IFNULL(estado,''))) 
        like concat('%',upper(IFNULL(:p_filtro,'')),'%') ";
        $param = array();
        array_push($param, [':p_filtro', $p_filtro, PDO::PARAM_STR]);
        $var1 =  parent::gselect($sqlcount, $param);
        $var['LENGTH'] = $var1['DATA'][0]['cant'];
        return $var;
    }
    public function register($p_ci_usuario,$p_nombre,$p_apellido,$p_fecha_nacimiento,$p_rol_usuario,$p_password)
    {
        $p_estado='ACTIVO';
        $sql="INSERT INTO usuario(ci_usuario, nombre, apellido, fecha_nacimiento, fecha_y_hora_alta, rol_usuario, password, estado) 
        VALUES (:p_ci_usuario,:p_nombre,:p_apellido,:p_fecha_nacimiento,NOW(),:p_rol_usuario,:p_password,:p_estado)";
        $param=array();
        array_push($param,[':p_ci_usuario',$p_ci_usuario,PDO::PARAM_STR]);
        array_push($param,[':p_nombre',$p_nombre,PDO::PARAM_STR]);
        array_push($param,[':p_apellido',$p_apellido,PDO::PARAM_STR]);
        array_push($param,[':p_fecha_nacimiento',$p_fecha_nacimiento,PDO::PARAM_STR]);
        array_push($param,[':p_rol_usuario',$p_rol_usuario,PDO::PARAM_STR]);
        array_push($param,[':p_password',$p_password,PDO::PARAM_STR]);
        array_push($param,[':p_estado',$p_estado,PDO::PARAM_STR]);

        return parent::ginsert($sql, $param);
    }

    public function update($p_ci_usuario,$p_nombre,$p_apellido,$p_fecha_nacimiento,$p_rol_usuario,$p_estado)
    {
        $sql = "UPDATE usuario 
        SET nombre=:p_nombre,
        apellido=:p_apellido,
        fecha_nacimiento=:p_fecha_nacimiento,
        rol_usuario=:p_rol_usuario,
        estado=:p_estado
        WHERE ci_usuario=:p_ci_usuario";
        $param = array();

        array_push($param, [':p_ci_usuario', $p_ci_usuario, PDO::PARAM_STR]);
        array_push($param,[':p_nombre',$p_nombre,PDO::PARAM_STR]);
        array_push($param,[':p_apellido',$p_apellido,PDO::PARAM_STR]);
        array_push($param,[':p_fecha_nacimiento',$p_fecha_nacimiento,PDO::PARAM_STR]);
        array_push($param,[':p_rol_usuario',$p_rol_usuario,PDO::PARAM_STR]);
        array_push($param,[':p_estado',$p_estado,PDO::PARAM_STR]);
        return parent::gupdate($sql, $param);
    }

    public function verificarLogin($p_ci_usuario,$p_password)
    {
        $sql="SELECT ci_usuario, nombre, apellido, rol_usuario
        FROM usuario 
        WHERE ci_usuario=:p_ci_usuario AND password=:p_password";
        $param = array();

        array_push($param, [':p_ci_usuario', $p_ci_usuario, PDO::PARAM_STR]);
        array_push($param,[':p_password',$p_password,PDO::PARAM_STR]);
        return parent::gselect($sql,$param);
    }

}