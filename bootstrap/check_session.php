<?php

  session_set_cookie_params(0,"/Attendance_system" , null, true ,true);
      if(isset($_POST['rememberme']) && $_POST['rememberme'] === "1"){
        session_set_cookie_params((86400 * 2) , "/Attendance_system", null, true, true);
      }
      session_start();
if(!isset($_SESSION['isLogin']) && $_SESSION['isLogin'] !== true){
    header("Location:login.php?youMustLoginAtFirst");die;
}
$isAuthorize = false;
$userType = $_SESSION['userType'];
if(isset(ROLES[$userType])){
    foreach (  ROLES[$userType] as $role){
        $requestURL = parse_url($_SERVER['REQUEST_URI'])['path'];
            if($role === basename($requestURL)){
                $isAuthorize = true;
                break;
            }
    }
    if($isAuthorize !== true){
        header("Location:login.php?NotAuthorize");die;
    }
    
}else{
    header("Location:login.php?NotAuthorize");
}



?>