<?php
require_once 'bootstrap/init.php'; 
require 'config.php';

function validateInputs($input)
{
  return trim((htmlentities($input)));
}

$positions = $conn->query("SELECT position_id , title FROM positions ");
$shifts = $conn->query("SELECT * FROM shifts");
$departments = $conn->query("SELECT * FROM departments");

$error = [];




if (isset($_POST['register'])) {

  $username = validateInputs($_POST['username']);
  $email = validateInputs($_POST['email']);
  $address = validateInputs($_POST['address']);
  $phone = validateInputs($_POST['phone']);
  $position_id = validateInputs($_POST['position_id']);
  $shift_id = validateInputs($_POST['shift_id']);
  $department_id = validateInputs($_POST['department_id']);
  $password = validateInputs($_POST['password']);
  $confirm_password = validateInputs($_POST['confirm_password']);

  $password_hashed = password_hash($password, PASSWORD_DEFAULT);

  // image 
  if (isset($_FILES['photo'])){
    $file = $_FILES['photo'];

    if($file['error'] == 0 ){

      $tmp = $file['tmp_name'];
      $file_name = $file['name'];

      
      $uploadDir = 'uploads/';
      if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
      }
      $photo_path = $uploadDir.$file_name;
      move_uploaded_file($tmp, $photo_path);
    }
    
  

  }
 
  if (empty($username) || empty($email) || empty($position_id) || empty($shift_id) || empty($department_id) || empty($password) || empty($confirm_password)) {
    $error["input_error"] = "All field are required.";
  } elseif ($password !== $confirm_password) {
    $error["password_err"] = "the password is not confirm.";
  } else {

    $stmt = $conn->prepare("INSERT INTO employees (name, password, email, phone, address, photo, position_id, shift_id, department_id) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
      "sssssssii",
      $username,
      $password_hashed,
      $email,
      $phone,
      $address,
      $photo_path,
      $position_id,
      $shift_id,
      $department_id
    );
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
      header("Location: index.php");
      exit;
    } else {
      $error["db"] = "Employee not save in database.";
    }
  }
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
          <div class="card shadow">
            <div class="card-body">
              <h3 class="text-center mb-4">Create Account</h3>
              <div>
                <?php if (isset($error['input_error'])) {  ?>
                  <p><?= $error['input_error'];  ?></p>
                <?php } ?>
              </div>
              <div>
                <?php if (isset($error['password_err'])) {  ?>
                  <p class="text-danger"><?= $error['password_err'];  ?></p>
                <?php } ?>
              </div>
              <form action="" method="post" enctype="multipart/form-data">
                <div class="row g-3">

                  <!-- Full Name -->
                  <div class="col-md-6">
                    <label for="fullname" class="form-label">Full Name</label>
                    <input type="text" class="form-control" name="username" id="fullname" placeholder="Enter Your User Name" required>
                  </div>

                  <!-- Address -->
                  <div class="col-md-6">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-control" id="address" name="address" placeholder="Address" required>
                  </div>

                  <!-- Phone -->
                  <div class="col-md-6">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number" required>
                  </div>

                  <!-- Email -->
                  <div class="col-md-6">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="you@example.com" required>
                  </div>

                  <!-- Position -->
                  <div class="col-md-6 mt-4">
                    <label for="position_id" class="form-label">Choose Position</label>
                    <select name="position_id" class="form-select" required>
                      <option value="">Choose Position</option>
                      <?php foreach ($positions as $position) { ?>
                        <option value="<?= $position['position_id'] ?>"><?= $position['title']; ?></option>
                      <?php } ?>
                    </select>
                  </div>

                  <!-- Shift -->
                  <div class="col-md-6 mt-4 mb-2">
                    <label for="shift_id" class="form-label">Choose Shift</label>
                    <select name="shift_id" class="form-select" required>
                      <option value="">Choose Shift</option>
                      <?php foreach ($shifts as $shift) { ?>
                        <option value="<?= $shift['id'] ?>"><?= $shift['name']; ?></option>
                      <?php } ?>
                    </select>
                  </div>

                  <!-- Department -->
                  <div class="col-md-6 mt-2">
                    <label for="department_id" class="form-label">Choose Department</label>
                    <select name="department_id" class="form-select" required>
                      <option value="">Choose Department</option>
                      <?php foreach ($departments as $dep) { ?>
                        <option value="<?= $dep['id'] ?>"><?= $dep['name']; ?></option>
                      <?php } ?>
                    </select>
                  </div>

                  <!-- Password -->
                  <div class="col-md-6">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Create a password" required>
                  </div>

                  <!-- Confirm Password -->
                  <div class="col-md-6">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm your password" required>
                  </div>
                  <div class="col-md-6">
                    <label>Image</label>
                    <input type="file" name="photo" accept=".jpg , .jpeg , .png">
                  </div>

                </div>

                <!-- Submit Button -->
                <div class="mt-4">
                  <button type="submit" name="register" class="btn btn-dark w-100">Sign Up</button>
                </div>
              </form>
            </div>
          </div>
        </div>


        <?php require_once("Includes/Footer.php"); ?>
