<?php


  require_once 'bootstrap/init.php';
  require_once 'config.php';



  $data_attendance = $conn->query("SELECT attendance.*, employees.name AS user_name
FROM attendance
JOIN employees ON attendance.user_id = employees.id;
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
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
 <?php include("Includes/Navbar.php"); ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include("Includes/Sidebar.php"); ?>

<h2 style="margin-left: 10px; margin-top: 30px; text-align: center;">Attendance</h2>
<a href="index.php" class="btn btn-dark " style="margin-left: 63px;" >Back</a>
  <table style="width: 90%; margin: 0px auto; margin-top: 20px; border-collapse: collapse; font-family: Arial;">
    <thead style="background-color: #000; color: #fff; ">
        <tr>
            <th style="padding: 8px; border: 1px solid #ccc;">User</th>
            <th style="padding: 8px; border: 1px solid #ccc;">check In Time</th>
            <th style="padding: 8px; border: 1px solid #ccc;">check Out Time</th>
        </tr>
    </thead>
    <tbody>
      <?php while($row = $data_attendance->fetch_assoc()){  ?>
        <tr>
           <td style="padding: 8px; border: 1px solid #ccc;"> <?php echo $row['user_name']; ?></td>
           <td style="padding: 8px; border: 1px solid #ccc;"> <?php echo $row['checkin_time']; ?></td>
           <td style="padding: 8px; border: 1px solid #ccc;"> <?php echo $row['checkout_time']; ?></td>
          </tr>
            <?php }?>
    </tbody>
  </table>
  <a class="btn btn-success mt-3 ml-3" href="export_attendance.php">Export Attendance</a>


  
  <?php require_once("Includes/Footer.php"); ?>
