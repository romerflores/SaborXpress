<?php
session_start();
require_once ('./config/global.php');

$request = $_SERVER['REQUEST_URI'];
$request = parse_url($request, PHP_URL_PATH);
$segments = explode('/', trim($request, '/'));
function home()
{
    http_response_code(200);
    require ROOT_DIR . '/view/home.php';
    exit;
}
function login()
{
    session_destroy();
    http_response_code(200);
    require ROOT_DIR . '/view/login/login.php';
    exit;
}
function error404()
{
    http_response_code(404);
    //echo "404 not found";
    require ROOT_DIR . '/view/templates/error404.php';
    exit;
}
function verificarLogin()
{
    if(!isset($_SESSION['login']['ci_usuario']))
    {
        echo '<script>window.location.href="'.HTTP_BASE.'/login/login"</script>';
    }
}
function verificarLoginActivo()
{
    http_response_code(302);
    if(isset($_SESSION['login']['ci_usuario']))
    {
        echo '<script>window.location.href="'.HTTP_BASE.'/home"</script>';
    }
}

if ($segments[0] === 'SaborXpress' || $segments[0]=== 'saborxpress') {
    switch ($segments[1] ?? '') {

        case 'login':
            switch ($segments[2] ?? '')
            {
                case 'login':
                    verificarLoginActivo();
                    require ROOT_VIEW.'/login/login.php';
                    break;
                case 'register':
                    //verificarLogin();
                    require ROOT_VIEW.'/login/register.php';
                    break;
                case 'logout':
                    session_destroy();
                    echo '<script>window.location.href="'.HTTP_BASE.'/login/login"</script>';
                    break;
                default:
                    error404();
                    break;
                
            }
            break;
        case 'clientes':
                verificarlogin();
                require ROOT_VIEW.'/clientes/creaClientes.php';
                require ROOT_VIEW.'/clientes/deleteClientes.php';
                require ROOT_VIEW.'/clientes/editClientes.php';
                require ROOT_VIEW.'/clientes/listarClientes.php';
                break; 
        case 'productos':
            verificarlogin();
            require ROOT_VIEW.'/productos/creaProductos.php';
            require ROOT_VIEW.'/productos/deleteProductos.php';
            require ROOT_VIEW.'/productos/editProductos.php';
            require ROOT_VIEW.'/productos/listarProductos.php';
            break;
        case 'pedidos':
            verificarlogin();
            require ROOT_VIEW.'/pedidos/creaPedidos.php';
            require ROOT_VIEW.'/pedidos/deletePedidos.php';
            require ROOT_VIEW.'/pedidos/editPedidos.php';
            require ROOT_VIEW.'/pedidos/listarPedidos.php';
            break;               
        case 'home':
            verificarlogin();
            home();
            break;
        case '':
            verificarlogin();
            home();
            break;
        default:
            error404();
            break;
    }
} else {
    error404();
}

// Incluir el pie de página después de procesar la solicitud
require ROOT_VIEW.'/templates/footer.php';
?>

