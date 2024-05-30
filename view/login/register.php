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
        $result= json_decode($response,true);

        if($result["ESTADO"])
        {
            echo "<script>alert('Se registro Correctamente')</script>";
        }
        else{
            echo "<script>alert('No se puedo registrar, verifique que ningun campo este vacio, caso contrario contactese con Sistemas')</script>";
        }

    }catch(Exception $e)
    {
        echo "<script>alert('No se puedo registrar, verifique que ningun campo este vacio, caso contrario contactese con Sistemas')</script>";
    }
}
?>