<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="author" content="Jojama">
    <meta name="theme-color" content="#206A5D">
    <link rel="shortcut icon" href="<?php echo base_url(); ?>favico.ico">  

  <title>Uniclaretiana | Administración</title>


  <!-- <link rel="stylesheet" href="https://cdn/js.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.min.css"> -->
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/ionicons.min.css">

  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/libreria/sweetalert2/dist/sweetalert2.min.css">

  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/estylereal.css">
  <!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/datatable.min.css"> -->



  <!-- Google Font: Source Sans Pro -->
  <link href="<?php echo base_url(); ?>assets/dist/css/googleapis.css" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>     
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge"><?php echo $suma ?></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header"> <?php echo $suma ?> Notificación</span>         
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> <?php echo $docentes ?> Docentes
          </a>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> <?php echo $alumnos ?> Alumnos</span>
          </a>
          <a href="#" class="dropdown-item">
            <i class="fas fa-book mr-2"></i> <?php echo $programas ?> Programas
          </a>
          <a href="#" class="dropdown-item">
            <i class="fas fa-book mr-2"></i> <?php echo $cursos ?> Cursos
          </a>
          </a>
         
      </li>    
    </ul>
  </nav>
  <!-- /.navbar -->
