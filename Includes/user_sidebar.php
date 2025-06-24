<?php

  require_once "bootstrap/init.php";
  require_once "config.php";

  $id = $_SESSION['id'];

  if(!isset($id)){
    header("Location:users.php");die;
  }

  $data = $conn->prepare("SELECT * FROM employees WHERE id =?");
  $data->bind_param("i" , $id);
  $data->execute();
  $new_data = $data->get_result();
  $image = $new_data->fetch_assoc();
 




?>


<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    
    <!-- Sidebar -->
    
    <a href="users.php" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Attendance System</span>
    </a>
    <a href="users.php" class="brand-link" style="display: flex; margin-left: 14px; gap:15px; justify-content: flex-start;  align-items: center;">
    <?php
    if(!$image['photo']){?>
      <img src="<?= 'default/profile-user.png' ?>" style="margin-left: 12px; width: 35px; height: 35px; object-fit: cover;"  alt="image">
      <?php
    }else{ ?>
      <img src="<?= $image['photo']; ?>" style="margin-left: 12px; border-radius: 50%;  width: 35px; height: 35px; object-fit: cover;" alt="image">
    <?php
    }
    ?>
      <span class="brand-text font-weight-light" style=":;"><?= $image['name']; ?></span>
    </a>

      <!-- SidebarSearch Form -->
      

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                
              </li>
            
            <li class="nav-item"><a class="nav-link active" href="user_data.php">Attendance</a>
          </li>
            </ul>
          </li>
          

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>