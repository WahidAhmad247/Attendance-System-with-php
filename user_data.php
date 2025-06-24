<?php
require_once 'bootstrap/init.php';
require_once 'config.php';

$user_id = $_SESSION['id'];
$now = time();
$eight_hours_in_seconds = 8 * 3600;




$stmt = $conn->prepare("SELECT checkin_time, checkout_time FROM attendance WHERE user_id = ? AND DATE(checkin_time) = CURDATE()");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$checked_in = false;
$checked_out = false;
$reset_status = false;

if ($row = $result->fetch_assoc()) {
    if (!is_null($row['checkin_time'])) {
        $checked_in = true;
        $checkin_timestamp = strtotime($row['checkin_time']);
        
        if (($now - $checkin_timestamp) > $eight_hours_in_seconds) {
          
            $reset_status = true;
            $checked_in = false;
            $checked_out = false;
        } else {
            if (!is_null($row['checkout_time'])) {
                $checked_out = true;
            }
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'checkin' && !$checked_in) {
            $now_mysql = date('Y-m-d H:i:s');
            $stmt = $conn->prepare("INSERT INTO attendance (user_id, checkin_time) VALUES (?, ?)");
            $stmt->bind_param("is", $user_id, $now_mysql);
            $stmt->execute();
            $checked_in = true;
            $checked_out = false;
        } elseif ($_POST['action'] === 'checkout' && $checked_in && !$checked_out) {
            $now_mysql = date('Y-m-d H:i:s');
            $stmt = $conn->prepare("UPDATE attendance SET checkout_time = ? WHERE user_id = ? AND DATE(checkin_time) = CURDATE()");
            $stmt->bind_param("si", $now_mysql, $user_id);
            $stmt->execute();
            $checked_out = true;
          }
        }
        
        header("Location: user_data.php");
        exit;
      }
      ?>

<!DOCTYPE html>
<html lang="fa">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Attendance System</title>
    
      <?php require "Includes/Head.php"; ?>
<style>
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f0f4f8;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
  
    margin: 0;
  }
  .container {
    background: #fff;
    padding: 30px 40px;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    text-align: center;
    width: 320px;
  }
  h2 {
    margin-bottom: 25px;
    color: #333;
  }
  button {
    width: 140px;
    padding: 14px 0;
    margin: 8px 10px;
    font-size: 16px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    font-weight: 600;
    transition: background-color 0.3s ease, color 0.3s ease;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
  }
  button:disabled {
    cursor: not-allowed;
    opacity: 0.5;
    box-shadow: none;
  }
  button#checkin {
    background-color: #4caf50;
    color: white;
  }
  button#checkin:hover:not(:disabled) {
    background-color: #45a049;
  }
  button#checkout {
    background-color: #f44336;
    color: white;
  }
  button#checkout:hover:not(:disabled) {
    background-color: #da190b;
  }
  p.message {
    margin-top: 20px;
    color: #ff5722;
    font-weight: 600;
  }
</style>
</head>


  <body class="layout-fixed">
    
      
    <?php require "Includes/user_sidebar.php" ?>
    
    <a href="users.php" class="btn btn-dark" style="margin-left: 260px; margin-bottom: 300px;">Back</a> 
    <div class="" style="margin-top:200px; display: flex; margin-right: 160px; width: 100%; justify-content:center; align-items: center; flex-direction: column;">
      <h2>Attendance Report</h2>
      <form method="POST"  style=" display: flex; justify-content: center; align-items: center; flex-direction: column;">
        <button type="submit" id="checkin" name="action" value="checkin" <?php if ($checked_in && !$reset_status) echo 'disabled'; ?>>Check In</button>
        <button type="submit" id="checkout" name="action" value="checkout" <?php if (!$checked_in || $checked_out || $reset_status) echo 'disabled'; ?>>Check Out</button>
      </form>
      
      <?php if ($reset_status): ?>
        <p class="message">Now you can use Buttons</p>
        <?php endif; ?>
      </div>

  
<?php require_once "Includes/Footer.php";