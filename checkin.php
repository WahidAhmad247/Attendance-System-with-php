<?php
require_once 'bootstrap/init.php';
require_once 'config.php';

$user_id = $_SESSION['id'];
$today = date('Y-m-d');
$now = date('Y-m-d H:i:s');

$stmt = $conn->prepare("SELECT checkin_time, checkout_time FROM attendances WHERE user_id = ? AND date = ?");
$stmt->bind_param("is", $user_id, $today);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$action = $_POST['action'] ?? '';

if ($action === 'checkin') {
    if (!$row) {
        $stmt = $conn->prepare("INSERT INTO attendances (user_id, checkin_time, date) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $now, $today);
        $stmt->execute();
    }
} else if ($action === 'checkout') {
    if ($row && is_null($row['checkout_time'])) {
        $stmt = $conn->prepare("UPDATE attendances SET checkout_time = ? WHERE user_id = ? AND date = ?");
        $stmt->bind_param("sis", $now, $user_id, $today);
        $stmt->execute();
    }
}

header("Location: user_data.php");
exit;
