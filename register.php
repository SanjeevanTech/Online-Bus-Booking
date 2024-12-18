<?php 
  session_start();
  error_reporting(0);
  include("dbconnect.php");
     if(isset($_SESSION['User'])){
    echo '<script type="text/javascript">window.location.assign("schedule.php");</script>';
  }
	if (isset($_POST['registerbtn'])) {

		$email = $_POST['email'];
	    $password = $_POST['password'];
		$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
		$name = $_POST['name'];
		$phone = $_POST['phoneno'];
		


		$query ="INSERT INTO `users`(`emailuser`, `name`,`phoneno`,`password`) VALUES ('$email','$name','$phone','$hashedPassword')";

		if(mysqli_query($conn, $query))
		{
			echo "<script type='text/javascript'>alert('Success');window.location.assign('login.php');</script>";
		}else{
			echo "<script type='text/javascript'>alert('Email or phone no has been used! Phone:);window.location.assign('register.php');</script>";

		}
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Registrasion</title>
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
            width: 100%;
            max-width: 500px;
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
	
	</style>
</head>
<body style="font-family:Arvo; margin:0;">
		
	<br><br>
	<table align="center" style="font-size:45px; margin-bottom: 10px"><tr>
		<th><img src="assets/trendbus.jpeg" class="imgservice" width="100px" height="100px"/></th>
		<th width="30px"></th><th style="color: #C54B8C;">Trendbus Booking</th>
		</tr></table>
	
	<form method="post">
	<div id="form_wrapper" align="center">
		
 		<br>
      <h1 align="center">Registration</h1><br>
      <div class="input_container" align="center"> 
      
		<input placeholder=" &nbsp; Email" type="email" name="email" id="email" class="input_field" required />
		  <br><br>

		   <input
          placeholder=" &nbsp; Username"
          type="text"
          name="name"
          id="name"
          class="input_field" required
        />
		<br><br>

		<input placeholder=" &nbsp; Phone No" type="text" name="phoneno" id="phoneno" class="input_field" required />
		  <br><br>

		
        <input
          placeholder=" &nbsp; Password"
          type="password"
          name="password"
          id="password"
          class="input_field" required
        />
      
		<br><br>
      <button class="loginbtn" type="submit" name="registerbtn">Register</button>
      <br><br>
	  <a href="login.php" style="text-decoration:none; font-size:14px; margin-top:30px; display:inline-block;"> Have Account Already?</a>

		  <br>
	</div>
		<br>
    </div></form>
 <br><br>
</body>
</html>