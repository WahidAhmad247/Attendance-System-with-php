<?php


require_once 'bootstrap/init.php';
require 'config.php';


$shifts = $conn->query("SELECT * FROM shifts");           
$error = "";

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

        


           <div  style="margin-left: 58px;">
             <a class="btn btn-dark mt-4 ml-4"  href="add_shift.php">Add new Shift</a>
            <a class="btn btn-dark mt-4 ml-2" href="index.php">Back</a>
           </div>
            <?php if (empty($error)) {   ?>
                <div style="padding: 20px;">

                    <table style="border-collapse: collapse; width: 90%; margin: auto; font-family: Arial, sans-serif;">
                        <thead>
                            <tr style="background-color: #000; color:#fff;">
                                <th style="border: 1px solid #ddd; padding: 8px;">Name</th>
                                <th style="border: 1px solid #ddd; padding: 8px;">Shift Start Time</th>
                                <th style="border: 1px solid #ddd; padding: 8px;">Shift End Time</th>
                                <th style="border: 1px solid #ddd; padding: 8px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($shifts as $shift) { ?>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="border: 1px solid #ddd; padding: 8px;"><?= $shift['name']; ?></td>
                                    <td style="border: 1px solid #ddd; padding: 8px;"><?= $shift['shift_start_time']; ?></td>
                                    <td style="border: 1px solid #ddd; padding: 8px;"><?= $shift['shift_end_time']; ?></td>
                                    <td style="border: 1px solid #ddd; padding: 8px;">

                                       
                                        <a href="shift_edit.php?id=<?= $shift['id']; ?>" style="color: #2196F3;">
                                            Edit
                                        </a>
|
                                       
                                        <a href="delete_shift.php?id=<?= $shift['id']; ?>" style="color: #f44336;">
                                            Delete
                                        </a>

                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                </div>
            <?php } else { ?>
                <h3><?= $error ?></h3>
            <?php } ?>




            <!-- /.content-wrapper -->

            <?php require_once("Includes/Footer.php"); ?>