<?php
require_once "bootstrap/init.php";
require_once "config.php";

if (isset($_POST['submit_shift'])) {
    $name = $_POST['name'];
    $start = $_POST['shift_start_time'];
    $end = $_POST['shift_end_time'];

    if (!$name || !$start || !$end) {
        die("All fields are required.");
    }

    $insert = $conn->prepare("INSERT INTO shifts( name, shift_start_time, shift_end_time) VALUES (?,?,?)");
    $insert->bind_param("sss", $name, $start, $end);
    $insert->execute();

    if ($insert->affected_rows > 0) {
        echo "<script>alert(' Shift Added successfully!'); window.location.href = 'shifts.php';</script>";
        // header("Location:shifts.php");die;
    } else {
        echo "<script>alert(' No Add made.'); window.location.href = 'shifts.php';</script>";
        // header("Location:shifts.php");die;
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>



    <form action="add_shift.php" method="POST" style="
    max-width: 500px;
    margin: 40px auto;
    padding: 25px;
    padding-right: 40px !important;
    border: 1px solid #ddd;
    border-radius: 10px;
    background-color: #fefefe;
    font-family: Arial, sans-serif;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
">

        <h2 style="text-align: center; margin-bottom: 20px;"> Add New Shift</h2>

        <label style="display: block; font-weight: bold; margin-bottom: 6px;">Name</label>
        <input type="text" name="name" required style="
        width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ccc; margin-bottom: 16px;
    ">

        <label style="display: block; font-weight: bold; margin-bottom: 6px;">Start Time</label>
        <input type="time" name="shift_start_time" required style="
        width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ccc; margin-bottom: 16px;
    ">

        <label style="display: block; font-weight: bold; margin-bottom: 6px;">End Time</label>
        <input type="time" name="shift_end_time" required style="
        width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ccc; margin-bottom: 20px;
    ">

        <button type="submit" name="submit_shift" style="
        width: 100%;
        padding: 12px;
        background-color: #4CAF50;
        color: white;
        border: none;
        font-weight: bold;
        border-radius: 6px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s;
    " onmouseover="this.style.backgroundColor='#43a047'" onmouseout="this.style.backgroundColor='#4CAF50'">
            Add Shift
        </button>
    </form>

</body>

</html>