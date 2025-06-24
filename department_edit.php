<?php


require_once 'bootstrap/init.php';
require_once 'config.php';

$id = $_GET['id'];
if(!isset($id)){
    header("Location:departments.php");
}

$dept = $conn->query("SELECT * FROM departments WHERE id=$id")->fetch_assoc();
$parents = $conn->query("SELECT id, name FROM departments WHERE id != $id");


if(isset($_POST['update_department'])){
    
$id = $_POST['id'];
$name = $_POST['name'];
$parent = $_POST['parent_id'] ? : null;


$stmt = $conn->prepare("UPDATE departments SET name = ?, parent_id = ?, updated_at = NOW() WHERE id = ?");
$stmt->bind_param("sii", $name, $parent, $id);
$stmt->execute();

header("Location: departments.php");

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
            <!-- <div class="preloader flex-column justify-content-center align-items-center">
                <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
            </div> -->

            <!-- Navbar -->
            <?php include("Includes/Navbar.php"); ?>
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            <?php include("Includes/Sidebar.php"); ?>

        <form action="#" method="POST" style="max-width: 400px; margin: 30px auto;">
    <h3>Edit Department</h3>

    <input type="hidden" name="id" value="<?= $dept['id'] ?>">

    <input type="text" name="name" value="<?= htmlspecialchars($dept['name']) ?>" required style="
        width: 100%; padding: 10px; margin-bottom: 15px; border-radius: 6px; border: 1px solid #ccc;
    ">

    <label>Parent Department:</label>
    <select name="parent_id" style="width: 100%; padding: 10px; margin-bottom: 15px;">
        <option value="">-- None --</option>
        <?php while($p = $parents->fetch_assoc()): ?>
            <option value="<?= $p['id'] ?>" <?= $dept['parent_id'] == $p['id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($p['name']) ?>
            </option>
        <?php endwhile; ?>
    </select>

    <button type="submit" name="update_department" style="background-color: #2196F3; color: white; padding: 10px 16px;
        border: none; border-radius: 6px; font-weight: bold;">Update</button>
</form>


            <?php require_once("Includes/Footer.php"); ?>