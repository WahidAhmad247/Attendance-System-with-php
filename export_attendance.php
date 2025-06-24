<?php

require_once 'bootstrap/init.php';
require_once 'config.php';



  $data_attendance = $conn->query("SELECT attendance.*, employees.name AS user_name
FROM attendance
JOIN employees ON attendance.user_id = employees.id;
");

if($data_attendance->num_rows == 0){
  header("Location:attendances.php?msg=NoRecordFound");die;
}
  
header("Content-type: text/csv; charset=utf-8");
header("Content-Disposition: attachment; filename = attendance.csv");

$file = fopen("php://output" , "w");

fputcsv($file , [ "user_name" , "Shift_start_time" , "Shift_end_time"]);

while($row = $data_attendance->fetch_assoc()){
    fputcsv($file , [
              
        $row ["user_name"] ,
        $row ["checkin_time"] ,
        $row ["checkout_time"] ,
        
    ]);
}

fclose($file);
exit;