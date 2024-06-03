<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Content-Type: application/json; charset=UTF-8");


session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . "/SaborXpress/config/global.php");
require_once(ROOT_DIR . "/model/Nota_VentaModel.php");


$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);
try {
    $Path_Info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : (isset($_SERVER['ORIG_PATH_INFO']) ? $_SERVER['ORIG_PATH_INFO'] : '');
    $request = explode('/', trim($Path_Info, '/'));
} catch (Exception $e) {
    echo $e->getMessage();
}
switch ($method) {

    case 'GET': //consulta
        $p_ope = !empty($input['ope']) ? $input['ope'] : $_GET['ope'];
        if (!empty($p_ope)) {

            if ($p_ope == 'filterId' || $p_ope == 'filterid') {
                filterId($input);
            } elseif ($p_ope == 'filterSearch') {
                filterPaginateAll($input);
            } elseif ($p_ope ==  'filterall') {
                filterAll($input);
            } elseif ($p_ope ==  'filterbyDate'|| $p_ope ==  'filterbydate') {
                filterbyDate($input);
            }
        }

        break;
    case 'POST': //inserta}
        insert($input);
        break;
        // case 'PUT': //actualiza
        //     update($input);
        //     break;
        // case 'DELETE': //elimina
        //     delete($input);
        //     break;
    default: //metodo NO soportado
        echo 'METODO NO SOPORTADO';
        break;
}

function filterAll($input)
{
    $obj_Nota_Venta = new Nota_VentaModel();
    $var = $obj_Nota_Venta->findall();
    echo json_encode($var);
}

function filterId($input)
{
    //aca consulto por el &id_producto=x
    $p_nro_venta = !empty($input['nro_venta']) ? $input['nro_venta'] : $_GET['nro_venta'];
    $obj_Nota_Venta = new Nota_VentaModel();
    $var = $obj_Nota_Venta->findid($p_nro_venta);
    echo json_encode($var);
}

function filterbyDate($input)
{
    $p_fecha_inicio = !empty($input['fecha_inicio']) ? $input['fecha_inicio'] : $_GET['fecha_inicio'];
    $p_fecha_fin = !empty($input['fecha_fin']) ? $input['fecha_fin'] : $_GET['fecha_fin'];
    $obj_Nota_Venta = new Nota_VentaModel();
    $var = $obj_Nota_Venta->filterDate($p_fecha_inicio, $p_fecha_fin);
    echo json_encode($var);
}

function filterPaginateAll($input)
{
    $page = !empty($input['page']) ? $input['page'] : $_GET['page'];
    $filter = !empty($input['filter']) ? $input['filter'] : $_GET['filter'];
    $nro_record_page = 10;
    $p_limit = 10;
    $p_offset = 0;
    $p_offset = abs(($page - 1) * $nro_record_page);

    $obj_Nota_Venta = new Nota_VentaModel();
    $var = $obj_Nota_Venta->findpaginateall($filter, $p_limit, $p_offset);
    echo json_encode($var);
}

function insert($input)
{
    $p_total = !empty($input['total']) ? $input['total'] : $_POST['total'];
    $p_cliente_id_cliente = !empty($input['cliente_id_cliente']) ? $input['cliente_id_cliente'] : $_POST['cliente_id_cliente'];
    $p_usuario_ci_usuario = !empty($input['usuario_ci_usuario']) ? $input['usuario_ci_usuario'] : $_POST['usuario_ci_usuario'];
    $obj_Nota_Venta = new Nota_VentaModel();
    $var = $obj_Nota_Venta->insert($p_total, $p_cliente_id_cliente, $p_usuario_ci_usuario);
    echo json_encode($var);
}
