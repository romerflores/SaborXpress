<?php include ROOT_VIEW . "/template/header.php"; ?>
<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = [
       
        'nombre' => $_POST['nombre'],
        'apellido' => $_POST['apellido'],
        'curso' => $_POST['curso'],
        'nivel' => $_POST['nivel'],
    ];
    $context = stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => "Content-Type: application/json",
            'content' => json_encode($data),
        ]
    ]);
    $url = HTTP_BASE . '/controller/InscripcionesController.php';
    $response = file_get_contents($url, false, $context);
    $result = json_decode($response, true);
    if ($result["ESTADO"]) {
        echo "<script>alert('Operacion realizada con Exito.');</script>";
    } else {
        echo "<script>alert('Hubo un problema, se debe contactar con el adminsitrador.');</script>";
    }
}


?>
<div class="wrapper">
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Modificar Inscrito</h1>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Editar Inscrito</h3>
                            </div>
                            <form action="" method="post">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="nombre">Nombre</label>
                                        <input type="text" class="form-control" name="nombre" required value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="apellido">Apellido</label>
                                        <input type="text" class="form-control" name="apellido" required value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="curso">Curso</label>
                                        <input type="text" class="form-control" name="curso" required value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="nivel">Nivel</label>
                                        <select class="form-control" id="estado" name="nivel">
                                            <option value="Básico" >Básico</option>
                                            <option value="Intermedio" >Intermedio</option>
                                            <option value="Avanzado" >Avanzado</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">GUARDAR</button>
                                    <a class="btn btn-default" href="<?php echo HTTP_BASE; ?>/web/ins/list">Volver</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<?php include ROOT_VIEW . "/template/footer.php"; ?>