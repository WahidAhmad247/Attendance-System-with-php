<?php



require_once 'bootstrap/init.php';
require_once "config.php";
$parents = $conn->query("SELECT id, name FROM departments");


if (isset($_POST['submit_department'])) {
    $name = $_POST['name'];
    $parent = $_POST['parent_id'] ?: null;


    $stmt = $conn->prepare("INSERT INTO departments (name, parent_id, created_at) VALUES (?, ?, NOW())");
    $stmt->bind_param("si", $name, $parent);
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
            <div class="preloader flex-column justify-content-center align-items-center">
                <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
            </div>

            <!-- Navbar -->
            <?php include("Includes/Navbar.php"); ?>
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            <?php include("Includes/Sidebar.php"); ?>

            <form action="#" method="POST" style="max-width: 400px; margin: 30px auto;">
                <h3>Add Department</h3>

                <input type="text" name="name" placeholder="Department name" required style="
        width: 100%; padding: 10px; margin-bottom: 15px; border-radius: 6px; border: 1px solid #ccc;
    ">

                <label>Parent Department:</label>
                <select name="parent_id" style="width: 100%; padding: 10px; margin-bottom: 15px; border-radius: 6px;">
                    <option value="">-- None --</option>
                    <?php while ($p = $parents->fetch_assoc()): ?>
                        <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['name']) ?></option>
                    <?php endwhile; ?>
                </select>

                <button type="submit" name="submit_department" style="background-color: #4CAF50; color: white; padding: 10px 16px; border: none;
        border-radius: 6px; font-weight: bold;">Save</button>
            </form>

            <?php require_once("Includes/Footer.php"); ?>