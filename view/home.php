
<?php require(ROOT_VIEW . '/templates/header.php') ?>
<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0 font-weight-bold">Bienvenido!!</h3>
                <p></p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 d-flex grid-margin stretch-card">
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="card">
                <a href="<?php echo HTTP_BASE;?>/ventas/ventas">
                    <button type="button" class="btn btn-primary btn-lg btn-block">
                        <i class="typcn typcn-user"></i>
                        Ventas
                    </button>
                </a>
            </div>
        </div>
    </div>
    <!-- content-wrapper ends -->
    <!-- partial -->
</div>
<!-- main-panel ends -->
<?php require(ROOT_VIEW . '/templates/footer.php') ?>