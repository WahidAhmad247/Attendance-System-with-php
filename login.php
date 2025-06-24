<?php
require_once 'config.php';
$error = [];
if (isset($_POST['login'])) {

  $email = validateInputs(filter_var($_POST['email']), FILTER_VALIDATE_EMAIL);
  $password = validateInputs($_POST['password']);

  
  
  if (!$email || empty($password)) {
    $error = "please fill all Feilds ";
  }else{
    $result = $conn->query("SELECT * FROM employees WHERE email ='$email'");
    
    if ($result->num_rows > 0) {
      $user = $result->fetch_assoc();
      if(password_verify($password , $user['password'])){

        session_set_cookie_params(0, "/Attendance_system", null, true, true);
        if (isset($_POST['rememberme']) && $_POST['rememberme'] === "1") {
          session_set_cookie_params((86400 * 2), "/Attendance_system", null, true, true);
        }
        session_start();
      
      
        $_SESSION['name'] = $user['name'];
        $_SESSION['isLogin'] = true;
        $_SESSION['email'] = $user['email'];
        $_SESSION['userType'] = $user['user_role'];


        if ($user['user_role'] === 'admin') {
          $id = $user['id'];
          $_SESSION['id'] = $id;
          header("Location:index.php");
          exit;
        } else {
          $id = $user['id'];
          $_SESSION['id'] = $id;
          header("Location:users.php");
          exit;
        }
      }else{
        $error[] = "incorrect email or password !";
        
      }  
    } else{
      $error[] = "incorrect email or password !";

    }

  }  
 
}

  
function validateInputs($input)
{
  htmlspecialchars($input);
  trim($input);
  return $input;
}
?>





<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(to right, #6a11cb, #2575fc);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .login-container {
      background-color: #ffffff;
      padding: 40px 30px;
      border-radius: 20px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 400px;
      animation: fadeIn 1s ease-in-out;
    }

    .login-container h2 {
      margin-bottom: 25px;
      text-align: center;
      color: #333;
      font-size: 28px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      margin-bottom: 8px;
      color: #333;
      font-weight: 600;
    }

    .form-group input {
      width: 100%;
      padding: 12px;
      border-radius: 10px;
      border: 1px solid #ccc;
      outline: none;
      transition: border 0.3s ease;
    }

    .form-group input:focus {
      border-color: #6a11cb;
    }

    .login-button {
      width: 100%;
      padding: 12px;
      background-color: #6a11cb;
      border: none;
      color: #fff;
      border-radius: 10px;
      font-size: 16px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .login-button:hover {
      background-color: #571ca9;
    }

    .extra-links {
      text-align: center;
      margin-top: 15px;
    }

    .extra-links a {
      text-decoration: none;
      color: #6a11cb;
      font-size: 14px;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
</head>

<body>

  <div class="login-container">
    <h2>Welcome Back</h2><?php
    if (isset($error) ): 
       foreach($error as $er):
        ?>
        <p class="error-message" style="color: red;"><?= $er; ?></p>
        
        <?php


    ?>

    <?php endforeach; ?>
    <?php endif; ?>



    <form action="" method="post">
      <div class="form-group">
        <label for="email">Email Address</label>
        <input type="text" name="email" id="email" placeholder="you@example.com" required>
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Enter your password" required>
      </div>

      <div style="margin-right: 10px; margin-bottom: 10px;">
        <input type="checkbox" value="1" name="rememberme" class=" custom-control-input ">
        <label class="custom-checkbox" for="">Remember me</label>
      </div>
      <button type="submit" name="login" class="login-button">Login</button>

      <div class="extra-links " style="display: flex; justify-content: space-between;">


      </div>
    </form>
  </div>

</body>

</html>