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
    if(!isset($_SESSION['login']['ci']))
    {
        echo '<script>window.location.href="'.HTTP_BASE.'/login"</script>';
    }
}

if ($segments[0] === 'pollosCristians' || $segments[0]=== 'PollosCristians') {
    switch ($segments[1] ?? '') {

        case 'login':
            switch ($segments[2] ?? '')
            {
                case 'login':
                    require ROOT_VIEW.'/login/login.php';
                    break;
                case 'register':
                    require ROOT_VIEW.'/login/register.php';
                    break;
                case 'logout':
                    session_destroy();
                    echo '<script>window.location.href="'.HTTP_BASE.'/login"</script>';
            }
        case 'home':
            home();
            break;

        default:
            //verificarlogin();
            error404();
            break;
    }
} else {
    error404();
}

