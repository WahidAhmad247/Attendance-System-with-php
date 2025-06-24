<?php

  $links = '<link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">';

  require_once 'bootstrap/init.php';
  require_once 'config.php';

    $id = $_SESSION['id'];

    if(!isset($id)){
        header("Location:users.php");die;
    }

   $users = $conn->query("
    SELECT 
        e.name,
        e.email,
        e.phone,
        e.address,
        e.photo,
        p.title AS position_name,
        s.name AS shift_name,
        d.name AS department_name
    FROM employees e
    LEFT JOIN positions p ON e.position_id = p.position_id
    LEFT JOIN shifts s ON e.shift_id = s.id
    LEFT JOIN departments d ON e.department_id = d.id
    WHERE e.id = '$id'
");

  

 
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
 

  <!-- Navbar -->
 <?php include("Includes/Navbar.php"); ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include("Includes/user_sidebar.php"); ?>

 <table style="width: 90%; margin-left: 60px;  margin-top: 20px; border-collapse: collapse; font-family: Arial;">
    <thead style="background-color: #000; color: #fff; ">
        <tr>
            <th style="padding: 8px; border: 1px solid #ccc;">name</th>
            <th style="padding: 8px; border: 1px solid #ccc;">email</th>
            <th style="padding: 8px; border: 1px solid #ccc;">Phone</th>
            <th style="padding: 8px; border: 1px solid #ccc;">Address</th>
            <th style="padding: 8px; border: 1px solid #ccc;">Position ID</th>
            <th style="padding: 8px; border: 1px solid #ccc;">Shift ID</th>
            <th style="padding: 8px; border: 1px solid #ccc;">Department ID</th>
            <th style="padding: 8px; border: 1px solid #ccc;">Image</th>
            
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $users->fetch_assoc()){  ?>
        <tr>
         <td style="padding: 8px; border: 1px solid #ccc;"><?= $row['name'] ?></td>
<td style="padding: 8px; border: 1px solid #ccc;"><?= $row['email'] ?></td>
<td style="padding: 8px; border: 1px solid #ccc;"><?= $row['phone'] ?></td>
<td style="padding: 8px; border: 1px solid #ccc;"><?= $row['address'] ?></td>
<td style="padding: 8px; border: 1px solid #ccc;"><?= $row['position_name'] ?></td>
<td style="padding: 8px; border: 1px solid #ccc;"><?= $row['shift_name'] ?></td>
<td style="padding: 8px; border: 1px solid #ccc;"><?= $row['department_name'] ?></td>
            <td style="padding: 8px; border: 1px solid #ccc;">
              <img src="
              <?php
              if($row['photo']){
                echo $row['photo']; 
              }else{
                echo "default/profile-user.png";
              } 
          
              ?>" style="border-radius: 50%; width: 50px; height: 50px;" alt=""></td>

        </tr>
        <?php } ?>
    </tbody>
</table>


  
  <?php require_once("Includes/Footer.php"); ?>
