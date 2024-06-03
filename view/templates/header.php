<!DOCTYPE html>
<html lang="es">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>PollosXpress</title>
  <!-- base:css -->
  <link rel="stylesheet" href="<?php echo URL_RESOURCES; ?>/AdminCelestial/template/vendors/typicons.font/font/typicons.css">
  <link rel="stylesheet" href="<?php echo URL_RESOURCES; ?>/AdminCelestial/template/vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="<?php echo URL_RESOURCES; ?>/AdminCelestial/template/css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="<?php echo URL_RESOURCES; ?>/images/favicon.ico" />
</head>

<body>
  <div class="row" id="proBanner">
    <div class="col-12">
      <span class="">
        <!-- <p>Bienvenido <?php echo $_SESSION['login']['ci'] ?></p> -->
        <!-- <a href="https://www.bootstrapdash.com/product/celestial-admin-template/?utm_source=organic&utm_medium=banner&utm_campaign=free-preview" target="_blank" class="btn download-button purchase-button ml-auto">Upgrade To Pro</a> -->
        <i class="typcn typcn-delete-outline" id="bannerClose"></i>
      </span>
    </div>
  </div>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="<?php echo HTTP_BASE; ?>/home">
          <img src="<?php echo URL_RESOURCES; ?>images/logo.png" alt="logo" style="max-width: 2000px; height: auto; border-radius: 100%;" />
          <h2 class="h4">SaborXpress</h2>
        </a>
        <a class="navbar-brand brand-logo-mini" href="index.html"><img src="images/logo-mini.svg" alt="logo" style="max-width: 30px; height: auto;" />
        </a>
        <button class="navbar-toggler navbar-toggler align-self-center d-none d-lg-flex" type="button" data-toggle="minimize">
          <span class="typcn typcn-th-menu"></span>
        </button>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <ul class="navbar-nav mr-lg-2">
          <?php
          if(isset($_SESSION['venta']['producto']) && count($_SESSION['venta']['producto'])>0)
          {
            echo '<li class="nav-item  d-none d-lg-flex">
            <a class="nav-link" href="'.HTTP_BASE.'/ventas/seleccionarCategoria">
              Continuar Venta
            </a>
          </li>';
          }
          ?>
          <li class="nav-item  d-none d-lg-flex">
            <a class="nav-link active" href="#">
              Principal
            </a>
          </li>
        </ul>
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item d-none d-lg-flex  mr-2">
            <a class="nav-link" href="https://github.com/romerflores">
              Github Proyecto
            </a>
          </li>
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle  pl-0 pr-0" href="#" data-toggle="dropdown" id="profileDropdown">
              <i class="typcn typcn-user-outline mr-0"></i>
              <span class="nav-profile-name"><?php echo $_SESSION['login']['nombre'] . " " . $_SESSION['login']['apellido'] ?></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
              <a class="dropdown-item">
                <i class="typcn typcn-cog text-primary"></i>
                Ajustes
              </a>
              <a class="dropdown-item" href="<?php echo HTTP_BASE; ?>/login/logout">
                <i class="typcn typcn-power text-primary"></i>
                Cerrar Sesion
              </a>
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="typcn typcn-th-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_settings-panel.html -->
      <div class="theme-setting-wrapper">
        <div id="settings-trigger"><i class="typcn typcn-cog-outline"></i></div>
        <div id="theme-settings" class="settings-panel">
          <i class="settings-close typcn typcn-delete-outline"></i>
          <p class="settings-heading">SIDEBAR SKINS</p>
          <div class="sidebar-bg-options" id="sidebar-light-theme">
            <div class="img-ss rounded-circle bg-light border mr-3"></div>
            Light
          </div>
          <div class="sidebar-bg-options selected" id="sidebar-dark-theme">
            <div class="img-ss rounded-circle bg-dark border mr-3"></div>
            Dark
          </div>
          <p class="settings-heading mt-2">HEADER SKINS</p>
          <div class="color-tiles mx-0 px-4">
            <div class="tiles success"></div>
            <div class="tiles warning"></div>
            <div class="tiles danger"></div>
            <div class="tiles primary"></div>
            <div class="tiles info"></div>
            <div class="tiles dark"></div>
            <div class="tiles default border"></div>
          </div>
        </div>
      </div>
      <!-- partial -->
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item mt-4">
            <a class="nav-link" href="<?php echo HTTP_BASE; ?>/home">
              <i class="typcn typcn-device-desktop menu-icon"></i>
              <span class="menu-title">Inicio</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
              <i class="typcn typcn-briefcase menu-icon"></i>
              <span class="menu-title">Productos</span>
              <i class="typcn typcn-chevron-right menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="<?php echo HTTP_BASE; ?>/productos/prod-listado">Listar Productos</a></li>
                <li class="nav-item"> <a class="nav-link" href="<?php echo HTTP_BASE; ?>/productos/prod-agregar">Agregar Producto</a></li>
                <li class="nav-item"> <a class="nav-link" href="<?php echo HTTP_BASE; ?>/categorias/cat-listado">Listar Categorias</a></li>
                <li class="nav-item"> <a class="nav-link" href="<?php echo HTTP_BASE; ?>/categorias/cat-agregar">Agregar Categorias</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
              <i class="typcn typcn-film menu-icon"></i>
              <span class="menu-title">Clientes</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="form-elements">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"><a class="nav-link" href="<?php echo HTTP_BASE; ?>/clientes/cli-listado">Listar Clientes</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo HTTP_BASE; ?>/clientes/cli-agregar">Agregar Clientes</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#charts" aria-expanded="false" aria-controls="charts">
              <i class="typcn typcn-chart-pie-outline menu-icon"></i>
              <span class="menu-title">Pedidos</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="charts">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="<?php echo HTTP_BASE; ?>/pedidos/listado">Listar Pedidos</a></li>
              </ul>
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="<?php echo HTTP_BASE; ?>/pedidos/editar">Modificar Pedidos</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
              <i class="typcn typcn-document-text menu-icon"></i>
              <span class="menu-title">Reportes</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="tables">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="<?= HTTP_BASE . '/report/rpt_Productos.php' ?>" target="_blank">Reporte Productos</a></li>s
              </ul>
            </div>
          </li>
          <!-- <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#icons" aria-expanded="false" aria-controls="icons">
              <i class="typcn typcn-compass menu-icon"></i>
              <span class="menu-title">Icons</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="icons">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="pages/icons/mdi.html">Mdi icons</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
              <i class="typcn typcn-user-add-outline menu-icon"></i>
              <span class="menu-title">User Pages</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="auth">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="pages/samples/login.html"> Login </a></li>
                <li class="nav-item"> <a class="nav-link" href="pages/samples/register.html"> Register </a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#error" aria-expanded="false" aria-controls="error">
              <i class="typcn typcn-globe-outline menu-icon"></i>
              <span class="menu-title">Error pages</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="error">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="pages/samples/error-404.html"> 404 </a></li>
                <li class="nav-item"> <a class="nav-link" href="pages/samples/error-500.html"> 500 </a></li>
              </ul>
            </div>
          </li> -->
          <li class="nav-item">
            <a class="nav-link" href="<?php echo HTTP_BASE; ?>/caja/cerrar">
              <!-- <i class="typcn typcn-document-text menu-icon"></i> -->
              <svg class="mr-3" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 24 24">
                <path fill="currentColor" d="M21 4H3a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h18a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2M3 6h8v12H3zm18 12h-9V6h9.003zm-1-4.5c0-.275-.225-.5-.5-.5h-1c-.275 0-.5.225-.5.5v3c0 .275.225.5.5.5h1c.275 0 .5-.225.5-.5zm-3-6c0-.275-.225-.5-.5-.5h-3c-.275 0-.5.225-.5.5v5c0 .275.225.5.5.5h3c.275 0 .5-.225.5-.5zm1.5 2.5h1c.275 0 .5-.225.5-.5s-.225-.5-.5-.5h-1c-.275 0-.5.225-.5.5s.225.5.5.5m0 2h1c.275 0 .5-.225.5-.5s-.225-.5-.5-.5h-1c-.275 0-.5.225-.5.5s.225.5.5.5m-5 3h3c.275 0 .5-.225.5-.5s-.225-.5-.5-.5h-3c-.275 0-.5.225-.5.5s.225.5.5.5m3 1h-3c-.275 0-.5.225-.5.5s.225.5.5.5h3c.275 0 .5-.225.5-.5s-.225-.5-.5-.5m2-8h1c.275 0 .5-.225.5-.5s-.225-.5-.5-.5h-1c-.275 0-.5.225-.5.5s.225.5.5.5M10 7.5c0-.275-.225-.5-.5-.5h-5c-.275 0-.5.225-.5.5v3c0 .275.225.5.5.5h5c.275 0 .5-.225.5-.5zM9.501 14h-5c-.274 0-.5.225-.5.5s.226.5.5.5h5c.274 0 .499-.225.499-.5s-.225-.5-.499-.5m0-2h-5c-.274 0-.5.225-.5.5s.226.5.5.5h5c.274 0 .499-.225.499-.5s-.225-.5-.499-.5m0 4h-5c-.274 0-.5.225-.5.5s.226.5.5.5h5c.274 0 .499-.225.499-.5s-.225-.5-.499-.5" />
              </svg>
              <span class="menu-title"> Cerrar Caja</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo HTTP_BASE; ?>/caja/abrir">
              <!-- <i class="typcn typcn-document-text menu-icon"></i> -->
              <svg class="mr-3" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 24 24">
                <path fill="currentColor" d="M21 4H3a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h18a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2M3 6h8v12H3zm18 12h-9V6h9.003zm-1-4.5c0-.275-.225-.5-.5-.5h-1c-.275 0-.5.225-.5.5v3c0 .275.225.5.5.5h1c.275 0 .5-.225.5-.5zm-3-6c0-.275-.225-.5-.5-.5h-3c-.275 0-.5.225-.5.5v5c0 .275.225.5.5.5h3c.275 0 .5-.225.5-.5zm1.5 2.5h1c.275 0 .5-.225.5-.5s-.225-.5-.5-.5h-1c-.275 0-.5.225-.5.5s.225.5.5.5m0 2h1c.275 0 .5-.225.5-.5s-.225-.5-.5-.5h-1c-.275 0-.5.225-.5.5s.225.5.5.5m-5 3h3c.275 0 .5-.225.5-.5s-.225-.5-.5-.5h-3c-.275 0-.5.225-.5.5s.225.5.5.5m3 1h-3c-.275 0-.5.225-.5.5s.225.5.5.5h3c.275 0 .5-.225.5-.5s-.225-.5-.5-.5m2-8h1c.275 0 .5-.225.5-.5s-.225-.5-.5-.5h-1c-.275 0-.5.225-.5.5s.225.5.5.5M10 7.5c0-.275-.225-.5-.5-.5h-5c-.275 0-.5.225-.5.5v3c0 .275.225.5.5.5h5c.275 0 .5-.225.5-.5zM9.501 14h-5c-.274 0-.5.225-.5.5s.226.5.5.5h5c.274 0 .499-.225.499-.5s-.225-.5-.499-.5m0-2h-5c-.274 0-.5.225-.5.5s.226.5.5.5h5c.274 0 .499-.225.499-.5s-.225-.5-.499-.5m0 4h-5c-.274 0-.5.225-.5.5s.226.5.5.5h5c.274 0 .499-.225.499-.5s-.225-.5-.499-.5" />
              </svg>
              <span class="menu-title"> Abrir Caja</span>
            </a>
          </li>
        </ul>
        <ul class="sidebar-legend">
          <li>
            <p class="sidebar-menu-title">Redes Sociales</p>
          </li>
          <li class="nav-item"><a target="_blank" href="https://www.facebook.com/Isabellaelalto" class="nav-link">#Instagram</a></li>
          <li class="nav-item"><a target="_blank" href="https://www.facebook.com/profile.php?id=61554076509372" class="nav-link">#Facebook</a></li>
          <!-- <li class="nav-item"><a href="#" class="nav-link">Youtube</a></li> -->
        </ul>
      </nav>