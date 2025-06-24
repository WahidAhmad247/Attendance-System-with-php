<?php

  require_once "bootstrap/init.php";
  require_once "config.php";

  $id = $_SESSION['id'];

  if(!isset($id)){
    header("Location:users.php");die;
  }

  $data = $conn->query("SELECT * FROM employees WHERE user_role = 'user'");
  $shift = $conn->query("SELECT * FROM shifts ");
  $departments = $conn->query("SELECT * FROM departments");
  $attendance = $conn->query("SELECT * FROM attendance");
  
  $number_of_employees = $data->num_rows;
  $number_of_departments = $departments->num_rows;
  $number_of_shift = $shift->num_rows;
  $number_of_attendance = $attendance->num_rows;
 
 

  ?>


<div style="display: flex; " class="col-12">

    <!-- ./col -->
    <div class="col-lg-3 col-4">

        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3><?= $number_of_employees; ?><sup style="font-size: 20px"></sup></h3>

                <p>Number Of Employees</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="employees.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-4">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3><?=  $number_of_shift;?></h3>

                <p>Number Of Shift</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="shifts.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-4">
        <!-- small box -->
        <div class="small-box bg-danger">
            <div class="inner">
                <h3><?= $number_of_departments; ?></h3>

                <p>Number Of Departments</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="departments.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      

    </div>
    
    <div class="col-lg-3 col-4">
      <div class="small-box bg-info">
            <div class="inner">
                <h3><?= $number_of_attendance ;?></h3>

                <p>Number Of Report</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="attendances.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>