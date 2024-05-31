<?php
if($_SERVER['REQUEST_METHOD']== 'POST')
{
    $ope='login';
    $p_ci=$_POST['ci'];//clave primaria
    $p_password=$_POST['password'];

    try
    {
        $data=[
            'ope'=>$ope,
            'ci'=>$p_ci,
            'password'=>$p_password
        ];
        $context= stream_context_create(
            [
                'http'=>
                [
                    'method'=>'POST',
                    'header'=>'Content-Type: application/json',
                    'content'=>json_encode($data)
                ]
            ]
        );
        $url = HTTP_BASE."/controller/LoginController.php";
        $response = file_get_contents($url,false,$context);
        $result= json_decode($response,true);
        if($result["ESTADO"] && isset($result['DATA']) && !empty($result['DATA']))
        {
            $_SESSION['login']= $result['DATA'][0];
            if(isset($_SESSION['login']['ci']))
            {
                echo "<script>alert('Se Logeo Correctamente')</script>";
                echo '<script>window.location.href="'.HTTP_BASE.'/home";</script>';
            }
            else{
                
            }
            
        }
        else{
            echo "<script>alert('No se pudo logear, contactese con Sistemas')</script>";
        }

    }catch(Exception $e)
    {
        echo "<script>alert('No se puedo registrar, verifique que ningun campo este vacio, caso contrario contactese con Sistemas')</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Login</title>
  <!-- base:css -->
  <link rel="stylesheet" href="<?php echo URL_RESOURCES;?>AdminCelestial/template/vendors/typicons.font/font/typicons.css">
  <link rel="stylesheet" href="<?php echo URL_RESOURCES;?>AdminCelestial/template/vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="<?php echo URL_RESOURCES;?>AdminCelestial/template/css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="<?php echo URL_RESOURCES;?>AdminCelestial/template/images/favicon.png" />
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo">
                <img src="<?php echo URL_RESOURCES;?>AdminCelestial/template/images/logo.svg" alt="logo">
              </div>
              <h4>Hello! let's get started</h4>
              <h6 class="font-weight-light">Sign in to continue.</h6>
              <form class="pt-3" method="POST" action="">
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Carnet de Identidad" name="ci">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Contraseña" name="password">
                </div>
                <div class="mt-3">
                  <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" type="submit"> LOGEARSE</button>
                </div>
                <div class="my-2 d-flex justify-content-between align-items-center">
                  <a class="auth-link text-black">¿Olvidaste la contraseña?</a>
                </div>
                <div class="text-center mt-4 font-weight-light">
                  Quieres crear cuenta?<a href="<?php echo HTTP_BASE;?>/login/register" class="text-primary">Crear Cuenta</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- base:js -->
  <script src="<?php echo URL_RESOURCES;?>AdminCelestial/template/vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="<?php echo URL_RESOURCES;?>AdminCelestial/template/js/off-canvas.js"></script>
  <script src="<?php echo URL_RESOURCES;?>AdminCelestial/template/js/hoverable-collapse.js"></script>
  <script src="<?php echo URL_RESOURCES;?>AdminCelestial/template/js/template.js"></script>
  <script src="<?php echo URL_RESOURCES;?>AdminCelestial/template/js/settings.js"></script>
  <script src="<?php echo URL_RESOURCES;?>AdminCelestial/template/js/todolist.js"></script>
  <!-- endinject -->
</body>

</html>
