<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Content-Type: application/json; charset=UTF-8");


session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . "/pollosCristians/config/global.php");
require_once(ROOT_DIR . "/model/ClienteModel.php");


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

            if ($p_ope == 'filterId') {
                filterId($input);
            } elseif ($p_ope == 'filterSearch') {
                filterPaginateAll($input);
            } elseif ($p_ope ==  'filterall') {
                filterAll($input);
            }
        }

        break;
    case 'POST': //inserta}
        
        insert($input);
        break;
    case 'PUT': //actualiza
        update($input);
        break;
    // case 'DELETE': //elimina
    //     delete($input);
    //     break;
    default: //metodo NO soportado
        echo 'METODO NO SOPORTADO';
        break;
}

function filterAll($input)
{
    $obj_Cliente=new ClienteModel();
    $var = $obj_Cliente->findall();
    echo json_encode($var);
}

function filterId($input)
{
    //aca consulto por el &id_producto=x
    $p_id_cliente = !empty($input['id_cliente']) ? $input['id_cliente'] : $_GET['id_cliente'];
    $obj_Cliente = new ClienteModel();
    $var = $obj_Cliente->findid($p_id_cliente);
    echo json_encode($var);
}
function filterPaginateAll($input)
{
    $page = !empty($input['page']) ? $input['page'] : $_GET['page'];
    $filter = !empty($input['filter']) ? $input['filter'] : $_GET['filter'];
    $nro_record_page = 10;
    $p_limit = 10;
    $p_offset=0;
    $p_offset=abs(($page-1)* $nro_record_page);

    $obj_Cliente = new ClienteModel();
    $var = $obj_Cliente->findpaginateall($filter,$p_limit,$p_offset);
    echo json_encode($var);

}

function insert($input)
{
    $p_id_cliente = !empty($input['id_cliente']) ? $input['id_cliente'] : $_POST['id_cliente'];
    $p_nombre = !empty($input['nombre']) ? $input['nombre'] : $_POST['nombre'];
   

    $obj_Cliente = new ClienteModel();
    $var = $obj_Cliente->insert($p_id_cliente,$p_nombre);
    echo json_encode($var);
}
function update($input)
{
    $p_id_cliente = !empty($input['id_cliente']) ? $input['id_cliente'] : $_POST['id_cliente'];
    $p_nombre = !empty($input['nombre']) ? $input['nombre'] : $_POST['nombre'];

    $obj_Cliente = new ClienteModel();
    $var = $obj_Cliente->update($p_id_cliente,$p_nombre);
    echo json_encode($var);
}
?>