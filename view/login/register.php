<?php
if($_SERVER['REQUEST_METHOD']== 'POST')
{
    $ope='register';
    $p_nombre=$_POST['nombre']; //debe estar asi en formulario de captura, para todos
    $p_apellido=$_POST['apellido'];
    $p_ci=$_POST['ci'];//clave primaria
    $p_fecha_nacimiento=$_POST['fecha_nacimiento'];// enviar en formato: YYYY-MM-DD
    $p_rol=$_POST['rol']; //tiene que ser un checkbox con Admin, Mesero, Cajero
    $p_password=$_POST['password'];
    //echo $p_fecha_nacimiento;
    //sugiero validar;
    //en el formulario y aqui tambien
    try
    {
        $data=[
            'ope'=>$ope,
            'nombre'=>$p_nombre,
            'apellido'=>$p_nombre,
            'ci'=>$p_ci,
            'fecha_nacimiento'=>$p_fecha_nacimiento,
            'rol'=>$p_rol,
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
        //var_dump($response);
        $result= json_decode($response,true);
        
        if($result['ESTADO'])
        {
            echo "<script>alert('Se registro Correctamente')</script>";
        }
        else{
            echo "<script>alert('No se puedo registrar')</script>";
        }

    }catch(Exception $e)
    {
        echo "<script>alert('No se puedo registrar, verifique que ningun campo este vacio, caso contrario contactese con Sistemas')</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>CelestialUI Admin</title>
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
              <h4>New here?</h4>
              <h6 class="font-weight-light">Signing up is easy. It only takes a few steps</h6>
              <form class="pt-3" method="POST" action="">
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="exampleInputUsername1" placeholder="Nombre" name="nombre">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" placeholder="Apellido" name="apellido">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" placeholder="Carnet de Identidad" name="ci">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" placeholder="Contraseña" name="password">
                </div>
                <div class="form-group">
                  <input type="date" class="form-control form-control-lg" placeholder="Fecha de Nacimiento" name="fecha_nacimiento">
                </div>
                <div class="form-group">
                  <select class="form-control form-control-lg" id="exampleFormControlSelect2" name="rol">
                    <option>Admin</option>
                    <option>Mesero</option>
                    <option>Cajero</option>
                  </select>
                </div>
                <div class="mt-3">
                  <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" type="submit">REGISTRARSE</button>
                </div>
                <div class="text-center mt-4 font-weight-light">
                  ¿Tienes ya una cuenta? <a href="<?php echo HTTP_BASE?>/login/login" class="text-primary">Logearse</a>
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
