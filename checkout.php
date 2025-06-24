<?php
require_once 'bootstrap/init.php';
require_once 'config.php';

$user_id = $_SESSION['id'];
$today = date('Y-m-d');
$now = date('Y-m-d H:i:s');

$stmt = $conn->prepare("SELECT id, checkout_time FROM attendances WHERE user_id = ? AND date = ?");
$stmt->bind_param("is", $user_id, $today);
$stmt->execute();
$res = $stmt->get_result();

if ($row = $res->fetch_assoc()) {
    if (is_null($row['checkout_time'])) {
        $stmt = $conn->prepare("UPDATE attendances SET checkout_time = ? WHERE user_id = ? AND date = ?");
        $stmt->bind_param("sis", $now, $user_id, $today);
        $stmt->execute();
        echo "checked_out";
    } else {
        echo "already_checked_out";
    }
} else {
    echo "no_checkin_found";
}
