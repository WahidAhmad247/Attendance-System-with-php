<?php

require_once "bootstrap/init.php";
require_once "config.php";

function validateInputs($input)
{
  return trim((htmlentities($input)));
}

$id = $_GET['id'] ?? null;

if (!$id) {

  die("Employee ID is required.");
}

$emp = $conn->query("SELECT * FROM employees WHERE id = $id")->fetch_assoc();
$positions = $conn->query("SELECT * FROM positions");
$shifts = $conn->query("SELECT * FROM shifts");
$departments = $conn->query("SELECT * FROM departments");

if (isset($_POST['update_employee'])) { 
  $id = validateInputs($_POST['id']);
  $name = validateInputs($_POST['name']);
  $email = validateInputs($_POST['email']);
  $phone = validateInputs($_POST['phone']);
  $address = validateInputs($_POST['address']);
  $position_id = validateInputs($_POST['position_id']);
  $shift_id = validateInputs($_POST['shift_id']);
  $department_id = validateInputs($_POST['department_id']) ?? null;

  $photo_path = $emp['photo']; 

  if (isset($_FILES['photo'])){
    $file = $_FILES['photo'];

    if($file['error'] == 0 ){

      $tmp = $file['tmp_name'];
      $file_name = $file['name'];

      
      $uploadDir = 'uploads/';
      if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
      }


      $new_path = $uploadDir.$file_name;
      move_uploaded_file($tmp, $new_path);

      if(!empty($photo_path) && file_exists($photo_path)){
        unlink($photo_path);

      }
      $photo_path = $new_path;
    }
  }
  $stmt = $conn->prepare("UPDATE employees 
    SET name=?, email=?, phone=?, address=?, position_id=?, shift_id=?, department_id=?, photo=?, updated_at=NOW() 
    WHERE id=?");
  $stmt->bind_param("ssssiiisi", $name, $email, $phone, $address, $position_id, $shift_id, $department_id, $photo_path, $id);
  $stmt->execute();

  header("Location: employees.php");
  exit;
}
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



  <div class="container mt-5">
  <h3>Edit Employee</h3>
  <form action="#" method="POST" class="row g-3" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $emp['id'] ?>">

    <div class="col-md-6">
      <label class="form-label">Name</label>
      <input type="text" name="name" value="<?= $emp['name'] ?>" class="form-control" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">Email</label>
      <input type="email" name="email" value="<?= $emp['email'] ?>" class="form-control" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">Phone</label>
      <input type="text" name="phone" value="<?= $emp['phone'] ?>" class="form-control">
    </div>

    <div class="col-md-6">
      <label class="form-label">Address</label>
      <input type="text" name="address" value="<?= $emp['address'] ?>" class="form-control">
    </div>

    <div class="col-md-4">
      <label class="form-label">Position</label>
      <select name="position_id" class="form-select">
        <?php while($p = $positions->fetch_assoc()){  ?>
          <option value="<?= $p['position_id'] ?>" <?= $emp['position_id'] == $p['position_id'] ? 'selected' : '' ?>>
            <?= $p['title'] ?>
          </option>
        <?php } ?>
      </select>
    </div>

    <div class="col-md-4">
      <label class="form-label">Shift</label>
      <select name="shift_id" class="form-select">
        <?php while($s = $shifts->fetch_assoc()){  ?>
          <option value="<?= $s['id'] ?>" <?= $emp['shift_id'] == $s['id'] ? 'selected' : '' ?>>
            <?= $s['name'] ?>
          </option>
        <?php } ?>
      </select>
    </div>

    <div class="col-md-4">
      <label class="form-label">Department</label>
      <select name="department_id" class="form-select">
        <option value="">—</option>
        <?php while($d = $departments->fetch_assoc()){  ?>
          <option value="<?= $d['id'] ?>" <?= $emp['department_id'] == $d['id'] ? 'selected' : '' ?>>
            <?= $d['name'] ?>
          </option>
        <?php } ?>
      </select>
    </div>
 <div class="col-12">
      <?php if ($emp['photo']){  ?>
    <label>Current Image :</label><br>
    <img src="<?= $emp['photo'] ?>" width="100"><br>
 </div>
  <?php } ?>
<div class="col-12">
  <label>Change Image :</label>
  <input type="file" name="photo"  accept=" .jpg, .jpeg, .png">
</div>

    <div class="col-12">
      <button type="submit" name="update_employee"  class="btn btn-primary">Save Changes</button>
      <a href="employees.php" class="btn btn-secondary">Cancel</a>
    </div>
  </form>
</div>
  
  <?php require_once("Includes/Footer.php"); ?>
