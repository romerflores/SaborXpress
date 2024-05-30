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