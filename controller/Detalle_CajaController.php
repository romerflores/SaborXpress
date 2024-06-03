    <?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: PUT, GET, POST");
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header("Content-Type: application/json; charset=UTF-8");


    session_start();

    require_once($_SERVER['DOCUMENT_ROOT'] . "/SaborXpress/config/global.php");
    require_once(ROOT_DIR . "/model/Detalle_CajaModel.php");


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

                if ($p_ope == 'filterId' || $p_ope=='filterid') {
                    filterId($input);
                } elseif ($p_ope == 'filterSearch') {
                    filterPaginateAll($input);
                } elseif ($p_ope ==  'filterall') {
                    filterAll($input);
                } elseif ($p_ope ==  'filterDate' || $p_ope ==  'filterdate' ) {
                    filterDate($input);
                }
            }

            break;
        case 'POST': //insertar
            
            abrirCaja($input);
            break;
        case 'PUT': //actualiza
            cerrarCaja($input);
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
        $obj_Detalle=new Detalle_CajaModel();
        $var = $obj_Detalle->findall();
        echo json_encode($var);
    }

    function filterId($input)
    {
        //aca consulto por el &id_producto=x
        $p_id_detalle = !empty($input['id_detalle']) ? $input['id_detalle'] : $_GET['id_detalle'];
        $obj_Detalle = new Detalle_CajaModel();
        $var = $obj_Detalle->findid($p_id_detalle);
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

        $obj_Detalle = new Detalle_CajaModel();
        $var = $obj_Detalle->findpaginateall($filter,$p_limit,$p_offset);
        echo json_encode($var);

    }
    function filterDate($input)
    {
        //aca consulto por el &id_producto=x
        $p_inicio = !empty($input['inicio']) ? $input['inicio'] : $_GET['inicio'];
        $p_fin = !empty($input['fin']) ? $input['fin'] : $_GET['fin'];
        $obj_Detalle = new Detalle_CajaModel();
        $var = $obj_Detalle->findDate($p_inicio,$p_fin);
        echo json_encode($var);
    }

    function abrirCaja($input)
    {
        $p_monto_inicio = !empty($input['monto_inicio']) ? $input['monto_inicio'] : $_POST['monto_inicio'];
        $obj_Detalle = new Detalle_CajaModel();
        $var = $obj_Detalle->abrirCaja( $p_monto_inicio);
        echo json_encode($var);
    }
    function cerrarCaja($input)
    {
        $p_id_detalle = !empty($input['id_detalle']) ? $input['id_detalle'] : $_POST['id_detalle'];
        $p_monto_final = !empty($input['monto_fin']) ? $input['monto_fin'] : $_POST['monto_fin'];

        $obj_Detalle = new Detalle_CajaModel();
        $var = $obj_Detalle->cerrarCaja( $p_id_detalle,$p_monto_final);
        echo json_encode($var);
    }
    ?>