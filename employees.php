<?php

    require_once "bootstrap/init.php";
    require_once "config.php";

$page = isset($_GET['page'])? $_GET['page']: 1 ;

$rowPerPage = 5;
$offset = ($page - 1) * $rowPerPage;


  $records = $conn->query("SELECT * FROM employees ");
  $num_rows = $records->num_rows;
  $pages = ceil($num_rows / $rowPerPage);
  $sql = "SELECT e.*, 
               p.title AS position_title,
               s.name AS shift_name,
               d.name AS department_name
        FROM employees e
        LEFT JOIN positions p ON e.position_id = p.position_id
        LEFT JOIN shifts s ON e.shift_id = s.id
        LEFT JOIN departments d ON e.department_id = d.id LIMIT $offset , $rowPerPage";

$result = $conn->query($sql);


 
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


  <div class="container mt-2">
    <h2 style="text-align: center; "> Employees</h2>
    <a href="signup.php" class="btn btn-dark my-3"> Add Employee</a>
    <a href="index.php" class="btn btn-dark my-3">Back</a>
 

<table class="table table-bordered shadow-sm">
  <thead class="table-dark text-light">
    <tr>
      <th>Photo</th>
      <th>Name</th>
      <th>Position</th>
      <th>Shift</th>
      <th>Department</th>
      <th>Email</th>
      <th>Phone</th>
      <th>Role</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($row = $result->fetch_assoc()){  ?>
      <tr>
        <td>
          <?php if (!empty($row['photo'])): ?>
            <img src="<?= $row['photo'] ?>" width="50" height="50" style="text-align: center; margin: auto; display:block; object-fit: cover; border-radius: 50%;">
          <?php else: ?>
            <img style="width: 50px; height: 50px; border-radius: 50%;" src="<?= "default/profile-user.png";  ?>" alt="">
          <?php endif; ?>
        </td>
        <td><?= $row['name'] ?></td>
        <td><?= $row['position_title'] ?? '—' ?></td>
        <td><?= $row['shift_name'] ?? '—' ?></td>
        <td><?= $row['department_name'] ?? '—' ?></td>
        <td><?= $row['email'] ?></td>
        <td><?= $row['phone'] ?></td>
        <td><?= $row['user_role'] ?></td>
        <td>
          <a href="employee_edit.php?id=<?= $row['id'] ?>" style="color: #2196F3;">Edit</a> |
          <a href="employee_delete.php?id=<?= $row['id'] ?>" 
             style="color: #f44336;"
             onclick="return confirm('Are you sure you want to delete this employee?')">Delete</a>
        </td>
      </tr>
    <?php } ?>
  </tbody>
</table>

       <div class=" d-flex justify-content-between" >
         <?php if($page > 1){  ?>
          <a class="btn btn-dark" href="employees.php?page=<?= $page - 1;?>">Previous</a>
          <?php }else{  ?>
            <span></span>
            <?php }  ?>
          
          <?php if($page < $pages){  ?>
            <a class="btn btn-dark" href="employees.php?page=<?= $page + 1;?>">next</a>
            <?php } ?>
       </div>
          
        </div>
 
  <?php require_once("Includes/Footer.php"); ?>
