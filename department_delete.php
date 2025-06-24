<?php


  require_once 'bootstrap/init.php';
  require_once 'config.php';

  $id = $_GET['id'];
  if(!isset($id)){
    header("Location:departments.php");
  }

  $delete = $conn->prepare("DELETE FROM departments WHERE id=?");
  $delete->bind_param("i" , $id);
  $delete->execute();

  header("Location:departments.php");
 

  ?>
<?php require_once("Includes/Head.php"); ?> 
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
              <li><a class="btn btn-primary" href="logout.php">Logout</a></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
 <?php include("Includes/Navbar.php"); ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include("Includes/Sidebar.php"); ?>


  <?php require_once("Includes/Footer.php"); ?>
