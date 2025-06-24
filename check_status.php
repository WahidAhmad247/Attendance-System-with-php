<?php
require_once 'bootstrap/init.php';
require_once 'config.php';

$user_id = $_SESSION['id'];
$today = date('Y-m-d');

$stmt = $conn->prepare("SELECT checkin_time, checkout_time FROM attendances WHERE user_id = ? AND date = ?");
$stmt->bind_param("is", $user_id, $today);
$stmt->execute();
$res = $stmt->get_result();

$status = ['checked_in' => false, 'checked_out' => false];

if ($row = $res->fetch_assoc()) {
    $status['checked_in'] = !is_null($row['checkin_time']);
    $status['checked_out'] = !is_null($row['checkout_time']);
}

header('Content-Type: application/json');
echo json_encode($status);
