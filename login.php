<?php
  session_start();
  error_reporting(0);
  include("dbconnect.php");

  if(isset($_SESSION['Admin'])){
    echo '<script type="text/javascript">window.location.assign("schedule.php");</script>';
  }

  if (isset($_POST['loginbtn'])) {
    $email = trim($_POST['email']);
	$password = trim($_POST['password']);


    // Query to fetch the user by email
    $query = "SELECT * FROM users WHERE emailuser = '$email'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();  // Fetch the user record
        
        // Verify the password using password_verify
        if (password_verify($password, $user['password'])) {
            // Password is correct, start session
            $_SESSION['Admin'] = $email;
            echo "<script type='text/javascript'>window.location.assign('home.php');</script>";
        } else {
            // Password is incorrect
			$password1 = $user['password']; // Assuming $user['password'] is a valid PHP variable
			echo "<script type='text/javascript'>alert('Email or Password was wrong!');window.location.assign('login.php');</script>";
        }
    } else {
        // User not found
        echo "<script type='text/javascript'>alert('Email or Password was wrong!');window.location.assign('login.php');</script>";
    }
}

?>
<html>
<head>
<meta charset="utf-8">
<title>Login</title>
	
<style>
	body{
			background-image: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url("assets/bg1.jpg");
            background-size: cover;
            background-position: center;
            margin: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between; /* Separate top and middle sections */
            font-family: Arvo, sans-serif;
            padding: 20px 0;
            box-sizing: border-box;

		
	}
	#form_wrapper{
		background: white;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
            width: 90%;
            max-width: 400px;
            padding: 30px;
            text-align: center;
            box-sizing: border-box;

	}
	.input_field{
		width: 350px;
		height: 40px;
		border-radius: 15px;
		border: 0px;
		background-color: #E0E0E0;
		font-size: 16px;
	}
	.loginbtn{
		width: 200px;
		height: 40px;
		border-radius: 15px;
		background-color: #0088ff;
		color: #FFFFFF;
		font-weight: bold;
		border:0;
		font-size: 18px;
	}
	.loginbtn:hover {
		background-color: #00AB0F;
	}
	

	.trendbus{
		color: #FFFFFF;
		font-family: Arvo;
	}
	</style>
</head>

<body style="font-family:Arvo; margin:0;">
	
	
<br><br>
	<table align="center" style="font-size:45px"><tr>
		<th>
			<img src="assets/trendbus.jpeg" class="imgservice" width="100px" height="100px"/>
		</th>
	<th width="30px"></th><th style="color: #C54B8C;">Trendbus Booking</th>
</tr></table>
	<br>
	<div id="form_wrapper" align="center">
		<form method="post">
 		<br><br>
      <h1 align="center">Login</h1><br>
      <div class="input_container" align="center">
        <input
          placeholder=" &nbsp; trendbuswebsite@gamil.com"
          type="email"
          name="email"
          id="email"
          class="input_field" required
        />
		<br><br>
        <input
          placeholder=" &nbsp; trendbus123"
          type="password"
          name="password"
          id="password"
          class="input_field" required
        />
      
		<br><br>
      <button class="loginbtn" type="submit" name="loginbtn">Login</button>
      <br><br>
		<p style="font-size:14px">Forgot <a href=forgotpassword.php style="text-decoration:none; font-size:14px"> Password ?</a></p>
      <br>
        <a href="register.php" style="text-decoration:none; font-size:14px">Dont Have Account? </a>
	</div>
		</form>
    </div>
 <br><br><br>
	
</body>
</html>
