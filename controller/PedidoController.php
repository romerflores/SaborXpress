<?php
//esto se usa para definir las cabeceras http
header("Access-Control-Allow-Origin: *"); //permite que el origen sea cualquiera
header("Access-Control-Allow-Methods: PUT, GET, POST"); //el servidor permitira medotos put get post
header("Access-Control-Allow-Header: Origin, X-Request-Width, Content-Type, Accept"); //
header("Content-Type: application/json; charset=UTF-8"); //nos dice que se devolvera un json

session_start();


require_once($_SERVER['DOCUMENT_ROOT'] . "/SaborXpress/config/global.php"); //importamos la configuracion global
require_once(ROOT_DIR . "/model/PedidoModel.php"); //importamos el modelo de Pedido

//que metodo vendra:
$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true); //recibimos json lo decodeamos, y parametrizamos lo valores

try {
    $Path_Info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : (isset($_SERVER['ORIGIN_PATH_INFO']) ? $_SERVER['ORIGIN_PATH_INFO'] : '');

    $request = explode('/', trim($Path_Info, '/'));
} catch (Exception $e) {

    echo $e->getMessage();
}

//aca haremos un switch case para los metodos que tendremos
switch ($method)
{
    case 'GET':
        $p_ope = !empty($input['ope']) ? $input['ope'] : $_GET['ope'];
        if (!empty($p_ope)) {
            if ($p_ope == 'filterall' || $p_ope == 'filterAll') {
                filterAll($input);
            } elseif ($p_ope == 'filterId' || $p_ope=='filterid') {
                filterId($input);
            } elseif ($p_ope == 'filterSearch' || $p_ope == 'filtersearch') {
                filterPaginateAll($input);
            }
        }
        break;
    case 'POST':
        insert($input);
        break;
    case 'PUT':
         update($input);
         break;
    // case 'DELETE':
    //     delete($input);
    //     break;
    default:
        echo 'No soportado';
}


function filterAll($input)
{
    $obj_Pedido = new PedidoModel();
    $var = $obj_Pedido->findall();
    echo json_encode($var);
}

function filterId($input)
{
    //aca consulto por el &id_producto=x
    $p_id_pedido = !empty($input['id_pedido']) ? $input['id_pedido'] : $_GET['id_pedido'];
    $obj_Pedido = new PedidoModel();
    $var = $obj_Pedido->findid($p_id_pedido);
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

    $obj_Pedido = new PedidoModel();
    $var = $obj_Pedido->findpaginateall($filter,$p_limit,$p_offset);
    echo json_encode($var);

}

function insert($input)
{
    $p_cantidad = !empty($input['cantidad']) ? $input['cantidad'] : $_POST['cantidad'];
    $p_sub_total= !empty($input['sub_total']) ? $input['sub_total'] : $_POST['sub_total'];
    $p_nota_venta_numero_venta= !empty($input['nota_venta_numero_venta']) ? $input['nota_venta_numero_venta'] : $_POST['nota_venta_numero_venta'];
    $p_producto_id_producto = !empty($input['producto_id_producto']) ? $input['producto_id_producto'] : $_POST['producto_id_producto'];
    $p_producto_categoria_id_categoria = !empty($input['producto_categoria_id_categoria']) ? $input['producto_categoria_id_categoria'] : $_POST['producto_categoria_id_categoria'];
    //var_dump($input);
    $obj_Pedido = new PedidoModel();
    $var = $obj_Pedido->insertar($p_cantidad,$p_sub_total, $p_nota_venta_numero_venta, $p_producto_id_producto,$p_producto_categoria_id_categoria);
    echo json_encode($var);

}
?>