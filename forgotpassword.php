<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("dbconnect.php");

if (isset($_POST['registerbtn'])) {
    $email = $_POST['email'];

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format');</script>";
        exit;
    }

    $query = "SELECT * FROM users WHERE emailuser = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result === false) {
        die("Query failed: " . $conn->error);
    }

    if ($result->num_rows > 0) {
        // Encryption
        $ciphering = "AES-128-CTR";
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;
        $encryption_iv = '1234567891011121';
        $encryption_key = "travel123";

        $encryption = openssl_encrypt($email, $ciphering, $encryption_key, $options, $encryption_iv);
        if ($encryption === false) {
            die("Encryption failed.");
        }
        
        $emailencryption = base64_encode($encryption);
        $from = "sanjeevan2006@yahoo.com";
        $to = $email;
        $url = "http://localhost/online-bus-ticket-booking-Website1/resetpassword.php?email=".$emailencryption;
        $subject = "From trendbus. Reset your password";

        // Create HTML content
        $htmlContent = "<p> Reset password </p><a href='$url'>Reset your password</a>";

        // Set headers
        $headers = "From: $from\r\n";
        $headers .= "Reply-To: $from\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8\r\n";

        // Send email
        if (mail($to, $subject, $htmlContent, $headers)) {
            echo "<script>alert('$to Success and please check your email!!');window.location.assign('login.php');</script>";
        } else {
            echo "<script>alert('Fail in sending the email!!');window.location.assign('login.php');</script>";
        }
    } else {
        echo "<script>alert('Fail, the email was wrong');</script>";
    }
}
?>

<html>
<head>
<meta charset="utf-8">
<title>Forgot Password</title>
	
<style>
	body{
		background-image: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url("assets/bg1.jpg");
		
	}
	#form_wrapper{
		background: white;
		border-radius: 20px;
		box-shadow: 0 0 20px 0px rgba(0, 0, 0, 0.5);
		width:35%;
		height: 350px;
		margin-top:50px;
		margin-left: 500px;
		margin-right: 500px;
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

	a {
    display: inline-block; /* Ensures width and height take effect */
    width: 200px;
    height: 40px;
    border-radius: 15px;
    background-color: #0088ff;
    color: #FFFFFF;
    font-weight: bold;
    text-align: center; /* Center text horizontally */
    line-height: 40px; /* Center text vertically */
    text-decoration: none; /* Remove underline */
    font-size: 18px;
}
a:hover {
    background-color: #00AB0F;
}

	</style>
</head>

<body style="font-family:Arvo; margin:0;">
		
<br><br>
	<table align="center" style="font-size:45px"><tr><th><img src="assets\trendbus.jpeg" class="imgservice" width="100px" height="100px"/></th>
  <th width="30px"></th><th style="color: #C54B8C;">Trendbus Booking</th></tr></table>
	<br>
	<div id="form_wrapper" align="center">
		<form method="post">
 		<br>
      <h1 align="center">Reset Password</h1><br>
      <div class="input_container" align="center">
		  
		
        <input
          placeholder=" &nbsp; Email"
          type="email"
          name="email"
          id="email"
          class="input_field" required
        />
		
        
      
		<br><br>
      <button class="loginbtn"  name="registerbtn" type="submit">Reset Password</button>	
      <br><br>
        <a href="login.php" style="text-decoration:none; font-size:14px"><span style="font-size: 18px;">Login</span></a>
	</div>
	</form>
    </div>
 <br><br><br>
	
</body>
</html>
<script>
	function login(){
		window.location.assign('login.php');
	}
	function logout(){
		window.location.assign('logout.php');
	}
</script>