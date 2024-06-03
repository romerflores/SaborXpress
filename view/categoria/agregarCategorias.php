<?php


// Manejo del método POST y ademaas la creacion de json
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $id_categoria = $_POST['id_categoria'];
    $id_categoria= strtoupper($id_categoria);
    $nombre_categoria = $_POST['nombre_categoria'];

    // Validar los datos antes de enviarlos
    if ($id_categoria && $nombre_categoria) {
        // Preparar la URL para la solicitud POST
        $url = HTTP_BASE . "/controller/CategoriaController.php";

        // Crear datos para enviar
        $data = array(
            'ope' => 'insert', // Operación de inserción
            'id_categoria' => $id_categoria,
            'nombre_categoria' => $nombre_categoria,
        );
        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => "Content-Type: application/json",
                'content' => json_encode($data),
            ]
        ]);
        $response = file_get_contents($url, false, $context);
        $result = json_decode($response, true);
        //var_dump($result);
        // Manejar la respuesta
        if ($result["ESTADO"]) {
            echo '<script>alert("Categoria agregada exitosamente.");</script>';
            echo '<script>window.location.href ="' . HTTP_BASE . '/categorias/listado"</script>';
        } else {
            echo '<script>alert("Ha ocurrido un error.");</script>';
        }
    } else {
        echo '<script>alert("Todos los campos son obligatorios");</script>';
    }
}

?>
<?php require(ROOT_VIEW . '/templates/header.php') ?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Agregar Categoria</h4>
                        <p class="card-description">
                            Rellena los detalles con cada campo Obligatorio
                        </p>
                        <form class="forms-sample" action="" method="POST">
                            <div class="form-group">
                                <label for="exampleInputName1">Id Categoria</label>
                                <input type="text" class="form-control" id="exampleInputName1" placeholder="Identificador de Categoira" name="id_categoria" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputName2">Nombre Categoria</label>
                                <input type="text" class="form-control" id="exampleInputName2" placeholder="Nombre Categoria" name="nombre_categoria" required>
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">Crear Categoria</button>
                            <button class="btn btn-light" type="reset">Reiniciar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<?php require(ROOT_VIEW . '/templates/footer.php') ?>