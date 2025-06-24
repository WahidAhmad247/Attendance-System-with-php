  <?php

  require_once "bootstrap/init.php";
  require_once "config.php";
  $result = $conn->query("SELECT d1.*, d2.name AS parent_name FROM departments d1 LEFT JOIN departments d2 ON d1.parent_id = d2.id");

  $page = isset($_GET['page']) ? $_GET['page'] : 1;

  $rowPerPage = 5;
  $offset = ($page - 1) * $rowPerPage;


  $records = $conn->query("SELECT * FROM departments");
  $num_rows = $records->num_rows;
  $pages = ceil($num_rows / $rowPerPage);

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

        <div class="container  mt-2">
          <h2 style="text-align: center;"> Departments</h2>

          <a href="department_add.php" style="
    display: inline-block; background-color: black; color: white; padding: 8px 14px;
    border-radius: 6px; text-decoration: none; font-weight: bold; margin-right: 10px;
"> Add Department</a>
          <a href="index.php" style="
    display: inline-block; background-color: black; color: white; padding: 8px 14px;
    border-radius: 6px; text-decoration: none; font-weight: bold; margin-right: 10px;
"> Back</a>

          <table style="width: 100%; margin: 0px auto; margin-top: 20px; border-collapse: collapse; font-family: Arial;">
            <thead style="background-color: #000; color: #fff; ">
              <tr>
                <th style="padding: 8px; border: 1px solid #ccc;">ID</th>
                <th style="padding: 8px; border: 1px solid #ccc;">Department Name</th>
                <th style="padding: 8px; border: 1px solid #ccc;">Parent</th>
                <th style="padding: 8px; border: 1px solid #ccc;">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($row = $result->fetch_assoc()) {  ?>
                <tr>
                  <td style="padding: 8px; border: 1px solid #ccc;"><?= $row['id'] ?></td>
                  <td style="padding: 8px; border: 1px solid #ccc;"><?= $row['name'] ?></td>
                  <td style="padding: 8px; border: 1px solid #ccc;"><?= $row['parent_name'] ?? '—' ?></td>
                  <td style="padding: 8px; border: 1px solid #ccc;">
                    <a href="department_edit.php?id=<?= $row['id'] ?>" style="color: #2196F3;">Edit</a> |
                    <a href="department_delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')" style="color: #f44336;">Delete</a>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
          <div class="mt-2 mb-3 d-flex justify-content-between">
            <?php if ($page > 1) {  ?>
              <a class="btn btn-dark" href="departments.php?page=<?= $page - 1; ?>">Previous</a>
            <?php } else {  ?>
              <span></span>
            <?php }  ?>

            <?php if ($page < $pages) {  ?>
              <a class="btn btn-dark" href="departments.php?page=<?= $page + 1; ?>">next</a>
            <?php } ?>
          </div>
        </div>


        <?php require_once("Includes/Footer.php"); ?>