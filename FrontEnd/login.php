<?php

session_start();

// check if the user is already logged in
if(isset($_SESSION['username']))
{
    header("location: page.php");
    exit;
}
require_once "dbconfig.php";

$username = $password = "";
$err = "";

// if request method is post
if ($_SERVER['REQUEST_METHOD'] == "POST"){
    if(empty(trim($_POST['username'])) || empty(trim($_POST['password'])))
    {
        $err = "Please enter username + password";
    }
    else{
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
    }


if(empty($err))
{
    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $param_username);
    $param_username = $username;
    
    
    // Try to execute this statement
    if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_store_result($stmt);
        if(mysqli_stmt_num_rows($stmt) == 1)
                {
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt))
                    {
                        if(password_verify($password, $hashed_password))
                        {
                            // if password is corrct. Allow user to login
                            session_start();
                            $_SESSION["username"] = $username;
                            $_SESSION["id"] = $id;
                            $_SESSION["loggedin"] = true;

                            //Redirect user to web page
                            header("location: page.php");
                            
                        }
                    }

                }

    }
}    


}


?>
<!DOCTYPE html>
<html>
<head>
	<title>Login Form</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="login.css">
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/a81368914c.js"></script> 
</head>
<body>
	 <img class="wave" src="images/elegant-blue-flowing-wave-background.jpg">
	 <div class="container">
		 <div class="img">
			 <img src="images/Untitled design (9).png">
		 </div>
		 <div class="login-content">
			 <form action="index.html">
				 <img src="images/images.webp">
				 <h2 class="title">Welcome</h2>
				 <div class="input-div one">
					 <div class="i">
						 <i class="fas fa-user"></i>
					 </div>
					 <div class="div">
						 <h5>Username</h5>
						 <input type="text" class="form-control" name="username">
					 </div>
				 </div>
				 <div class="input-div pass">
					<div class="i">
						<i class="fas fa-lock"></i>
					</div>
					<div class="div">
						<h5>Password</h5>
						<input type="password" class="form-control" name="password">
					</div>
				</div>
				<a href="#">Forget Password?</a>
				<input type="submit" class="btn" value="Login">
			 </form>
		 </div>
	 </div>
    <script type="text/javascript" src="js/main.js"></script>
</body>
</html>

