<?php

$id = $_GET['id'];
if (!$id) {
    die("Invalid ID");
}

require_once "bootstrap/init.php";
require 'config.php';
$stmt = $conn->prepare("SELECT * FROM shifts WHERE id = ?");

$stmt->bind_param("i" , $id);
$stmt->execute();
$result = $stmt->get_result();
$shift = $result->fetch_assoc();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>


<form action="update_shift.php" method="POST" style="
    max-width: 400px;
    margin: 0px auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #f9f9f9;
    font-family: Arial, sans-serif;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
">

    <input type="hidden" name="id" value="<?= $shift['id']; ?>">

    <label style="display: block; margin-bottom: 6px; font-weight: bold;">Name:</label>
    <input type="text" name="name" value="<?= $shift['name']; ?>" required style="
        width: 100%;
        padding: 8px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 14px;
    ">

    <label style="display: block; margin-bottom: 6px; font-weight: bold;">Start Time:</label>
    <input type="time" name="shift_start_time" value="<?= $shift['shift_start_time']; ?>" required style="
        width: 100%;
        padding: 8px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 14px;
    ">

    <label style="display: block; margin-bottom: 6px; font-weight: bold;">End Time:</label>
    <input type="time" name="shift_end_time" value="<?= $shift['shift_end_time']; ?>" required style="
        width: 100%;
        padding: 8px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 14px;
    ">

    <button type="submit" name="update_shift" style="
        width: 100%;
        padding: 10px;
        background-color: #4CAF50;
        color: white;
        font-size: 15px;
        font-weight: bold;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    ">
        Save Changes
    </button>
</form>



    
</body>
</html>