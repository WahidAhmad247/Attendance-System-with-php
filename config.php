<?php

    $host = "localhost";
    $username = "root";
    $password = "";
    $db_name = "php_project";

    $conn = mysqli_connect($host,$username,$password,$db_name);
    
    if($conn->connect_error){
        die("connection faild".$conn->connect_error); 
    }
 
?>