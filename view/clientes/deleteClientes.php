<?php include ROOT_VIEW . "/template/header.php"; ?>
<?php
$pId = $_GET['id'] ?? null;

$record = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = [
        'id' => $_POST['id']
    ];
    $context = stream_context_create([
        'http' => [
            'method' => 'DELETE',
            'header' => "Content-Type: application/json",
            'content' => json_encode($data),
        ]
    ]);
    $url = HTTP_BASE . '/controller/InscripcionesController.php';
    $response = file_get_contents($url, false, $context);
    $result = json_decode($response, true);
    if ($result["ESTADO"]) {
        echo "<script>alert('Operacion realizada con Exito.');</script>";
        echo '<script>window.location.href="'.HTTP_BASE.'/web/ins/list'.'";</script>';
    } else {
        echo "<script>alert('Hubo un problema, se debe contactar con el adminsitrador.');</script>";
    }
}
if ($pId) {
    $url = HTTP_BASE . '/controller/InscripcionesController.php?ope=filterId&id=' . $pId;
    $reponse = file_get_contents($url);
    $reponseData = json_decode($reponse, true);
    if ($reponseData &&  $reponseData['ESTADO'] == 1 && !empty($reponseData['DATA'])) {
        $record = $reponseData['DATA'][0];
    } else {
        $record = null;
    }
}

?>
<div class="wrapper">
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Eliminar Inscrito</h1>
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
                                        <label for="id">Nro Registro</label>
                                        <input type="hidden" class="form-control" name="id" value="<?php echo $record['id']; ?>">
                                        <input type="text" class="form-control" value="<?php echo $record['id']; ?>" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="nombre">Nombre</label>
                                        <input type="text" class="form-control" name="nombre" required value="<?php echo $record['nombre']; ?>" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="apellido">Apellido</label>
                                        <input type="text" class="form-control" name="apellido" required value="<?php echo $record['apellido']; ?>" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="curso">Curso</label>
                                        <input type="text" class="form-control" name="curso" required value="<?php echo $record['curso']; ?> " disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="nivel">Nivel</label>
                                        <select class="form-control" id="estado" name="nivel" disabled>
                                            <option value="Básico" <?php echo (isset($record['nivel']) && $record['nivel'] == 'Básico') ? 'selected' : ''; ?>>Básico</option>
                                            <option value="Intermedio" <?php echo (isset($record['nivel']) && $record['nivel'] == 'Intermedio') ? 'selected' : ''; ?>>Intermedio</option>
                                            <option value="Avanzado" <?php echo (isset($record['nivel']) && $record['nivel'] == 'Avanzado') ? 'selected' : ''; ?>>Avanzado</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
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