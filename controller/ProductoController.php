<?php
//esto se usa para definir las cabeceras http
header("Access-Control-Allow-Origin: *"); //permite que el origen sea cualquiera
header("Access-Control-Allow-Methods: PUT, GET, POST"); //el servidor permitira medotos put get post
header("Access-Control-Allow-Header: Origin, X-Request-Width, Content-Type, Accept"); //
header("Content-Type: application/json; charset=UTF-8"); //nos dice que se devolvera un json

session_start();

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
        break;
    case 'POST':
        break;
    case 'PUT':
        break;
    case 'DELETE':
        break;
    default:
        echo 'no soportado';
}
?>