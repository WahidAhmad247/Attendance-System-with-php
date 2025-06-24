<?php


require_once "bootstrap/init.php";
require_once "config.php";

$id = $_GET['id'];

if(!$id){
    echo "invalid id";
}

$delete = $conn->prepare("DELETE FROM shifts WHERE id=?"); 
$delete->bind_param("i" , $id);
$delete->execute();
if($delete->affected_rows > 0){
       echo "<script>alert('Shift Deleted successfully!'); window.location.href = 'shifts.php';</script>";
}else{
    echo "<script>alert(' No delete made.'); window.location.href = 'shifts.php';</script>";
}




