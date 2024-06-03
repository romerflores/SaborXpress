<?php require(ROOT_VIEW . '/templates/header.php') ?>
<?php

$_SESSION['venta']['producto'] = [];

?>


<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="container">
                <form method="POST" action="<?php echo HTTP_BASE.'/ventas/nuevaVenta'?>">
                    <button type="submit" class="btn btn-dark btn-icon-text">
                        Nueva venta
                        <i class="typcn typcn-edit btn-icon-append"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>



<?php require(ROOT_VIEW . '/templates/footer.php') ?>