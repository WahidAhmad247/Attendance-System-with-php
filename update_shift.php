<?php


require_once "bootstrap/init.php";
require_once "config.php";

if (isset($_POST['update_shift'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $shift_start_time = $_POST['shift_start_time'];
    $shift_end_time = $_POST['shift_end_time'];


    $stmt = $conn->prepare("UPDATE shifts SET name=? ,  shift_start_time=? , shift_end_time=? WHERE id=? ");

    $stmt->bind_param("sssi",  $name, $shift_start_time, $shift_end_time, $id);
    $stmt->execute();

    
if ($stmt->affected_rows > 0) {
    echo "<script>alert(' Shift updated successfully!'); window.location.href = '../shifts.php';</script>";
    header("Location:shifts.php");die;
} else {
    echo "<script>alert(' No changes made.'); window.location.href = '../shifts.php';</script>";
    header("Location:shifts.php");die;
}
}

