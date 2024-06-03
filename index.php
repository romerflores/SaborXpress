<?php
session_start();
require_once('./config/global.php');

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
    if (!isset($_SESSION['login']['ci_usuario'])) {
        echo '<script>window.location.href="' . HTTP_BASE . '/login/login"</script>';
    }
}
function verificarRegister()
{
    if (isset($_SESSION['login']['ci_usuario']) && ($_SESSION['login']['rol_usuario'] == 'Admin')) {
        echo '<script>alert("Solo en Administrador puede crear una Cuenta");</script>';
        echo '<script>window.location.href="' . HTTP_BASE . '/login/login"</script>';
    }
}
function verificarLoginActivo()
{
    http_response_code(302);
    if (isset($_SESSION['login']['ci_usuario'])) {
        echo '<script>window.location.href="' . HTTP_BASE . '/home"</script>';
    }
}

if ($segments[0] === 'SaborXpress' || $segments[0] === 'saborxpress') {
    switch ($segments[1] ?? '') {

        case 'login':
            switch ($segments[2] ?? '') {
                case 'login':
                    verificarLoginActivo();
                    require ROOT_VIEW . '/login/login.php';
                    break;
                case 'register':
                    verificarRegister();
                    require ROOT_VIEW . '/login/register.php';
                    break;
                case 'logout':
                    session_destroy();
                    echo '<script>window.location.href="' . HTTP_BASE . '/login/login"</script>';
                    break;
                default:
                    error404();
                    break;
            }
            break;
        case 'ventas':
            verificarLogin();
            switch ($segments[2] ?? '') {
                case 'ventas':
                    verificarLogin();
                    require ROOT_VIEW . '/nota_venta/ventas.php';
                    break;
                case 'nuevaVenta':
                    verificarLogin();
                    require ROOT_VIEW . '/nota_venta/nuevaVenta.php';
                    break;
                case 'seleccionarCategoria':
                    verificarLogin();

                    require ROOT_VIEW . '/nota_venta/seleccionarCategoria.php';
                    break;
                case 'seleccionarProducto':
                    verificarLogin();
                    if (isset($segments[3])) {
                        $_GET['id_categoria'] = $segments[3];
                        require ROOT_VIEW . '/nota_venta/seleccionarProductos.php';
                    } else {
                        error404();
                    }
                    break;
                case 'agregarProducto':
                    verificarLogin();
                    require ROOT_VIEW . '/nota_venta/agregarProducto.php';
                    break;
                case 'llenarDatos':
                    verificarLogin();
                    require ROOT_VIEW . '/nota_venta/llenadoDatos.php';
                    break;
                case 'cliente':
                    verificarLogin();
                    require ROOT_VIEW . '/nota_venta/cliente.php';
                    break;
                case 'terminar':
                    verificarLogin();
                    require ROOT_VIEW . '/nota_venta/finalizar.php';
                    break;
                default:
                    error404();
                    break;
            }
            break;
        case 'clientes':
            verificarlogin();
            switch ($segments[2] ?? '') {
                case 'cli-agregar':
                    verificarLogin();
                    require ROOT_VIEW . '/clientes/creaClientes.php';
                    break;
                case 'editar':
                    verificarLogin();
                    require ROOT_VIEW . '/clientes/editClientes.php';
                    break;
                case 'cli-listado':
                    verificarLogin();
                    require ROOT_VIEW . '/clientes/listarClientes.php';
                    break;
                default:
                    error404();
                    break;
            }
            break;
        case 'productos':
            verificarlogin();
            switch ($segments[2] ?? '') {
                case 'prod-listado':
                    verificarlogin();
                    require ROOT_VIEW . '/productos/listarProductos.php';
                    break;
                case 'prod-agregar':
                    verificarLogin();
                    require ROOT_VIEW . '/productos/creaProductos.php';
                    break;
                case 'desactivar':
                    verificarLogin();
                    if (isset($segments[3])) {
                        $_GET['id_producto'] = $segments[3];
                        require ROOT_VIEW . '/productos/deleteProductos.php';
                    } else {
                        error404();
                    }
                    break;
                case 'editar':
                    verificarLogin();
                    if (isset($segments[3])) {
                        $_GET['id_producto'] = $segments[3];
                        require ROOT_VIEW . '/productos/editProductos.php';
                    } else {
                        error404();
                    }
                    break;
                default:
                    error404();
                    break;
            }
            break;
        case 'pedidos':
            verificarlogin();
            switch ($segments[2] ?? '') {
                case 'listado':
                    verificarlogin();
                    require ROOT_VIEW . '/pedidos/listarPedidos.php';
                    break;
                case 'agregar':
                    verificarLogin();
                    require ROOT_VIEW . '/pedidos/creaPedidos.php';
                    break;
                case 'delete':
                    verificarLogin();
                    if (isset($segments[3])) {
                        $_GET['id_pedido'] = $segments[3];
                        require ROOT_VIEW . '/pedidos/deletePedidos.php';
                    } else {
                        error404();
                    }
                    break;
                case 'editar':
                    verificarLogin();
                    if (isset($segments[3])) {
                        $_GET['id_pedido'] = $segments[3];
                        require ROOT_VIEW . '/pedidos/editPedido.php';
                    } else {
                        error404();
                    }
                    break;
                default:
                    error404();
                    break;
            }
            break;
            verificarlogin();
            // require ROOT_VIEW . '/pedidos/creaPedidos.php';
            // require ROOT_VIEW . '/pedidos/deletePedidos.php';
            // require ROOT_VIEW . '/pedidos/editPedidos.php';
            // require ROOT_VIEW . '/pedidos/listarPedidos.php';
            break;
        case 'categorias':
            verificarlogin();
            switch ($segments[2] ?? '') {
                case 'cat-listado':
                    verificarlogin();
                    require ROOT_VIEW . '/categoria/listarCategorias.php';
                    break;
                case 'cat-agregar':
                    verificarLogin();
                    require ROOT_VIEW . '/categoria/agregarCategorias.php';
                    break;
                case 'editar':
                    verificarLogin();
                    if (isset($segments[3])) {
                        $_GET['id_categoria'] = $segments[3];
                        require ROOT_VIEW . '/categoria/editCategorias.php';
                    } else {
                        error404();
                    }
                    break;
                case 'filtrarCategoria':
                    verificarLogin();
                    if (isset($segments[3])) {
                        $_GET['id_categoria'] = $segments[3];
                        require ROOT_VIEW . '/productos/listarProductos.php';
                    } else {
                        error404();
                    }
                    break;
                default:
                    error404();
                    break;
            }
            break;

        case 'caja':
            verificarlogin();
            switch ($segments[2] ?? '') {
                case 'cerrar':
                    verificarlogin();
                    require ROOT_VIEW . '/caja/cerrarCaja.php';
                    break;
                case 'abrir':
                    verificarLogin();
                    require ROOT_VIEW . '/caja/abrirCaja.php';
                    break;
            }
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
require ROOT_VIEW . '/templates/footer.php';
