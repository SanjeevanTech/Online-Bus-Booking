<?php
  session_start();
  error_reporting(0);
  include("dbconnect.php");
    $temp = $_GET['email'];
    $email = base64_decode($temp);

	// Non-NULL Initialization Vector for decryption
	$decryption_iv = '1234567891011121';

	// Store the decryption key
	$decryption_key = "travel123";
    $ciphering = "AES-128-CTR";

	// Use OpenSSl Encryption method
	$iv_length = openssl_cipher_iv_length($ciphering);
	$options = 0;
	// Use openssl_decrypt() function to decrypt the data
    $decryption= openssl_decrypt ($email, $ciphering,$decryption_key, $options, $decryption_iv);
   
    $query = "SELECT * FROM `users`WHERE emailuser= '$decryption'";
	$result = $conn->query($query);
    if ($result->num_rows >0) {
		
	}else{
	     echo '<script type="text/javascript">alert("the url was wrong!");window.location.assign("login.php");</script>';
	}
	
	if (isset($_POST['resetpassword'])) {
         $password =  $_POST['password'];
		 $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query ="UPDATE `users` SET `password`='$hashedPassword' where `emailuser`='$decryption'";

		if(mysqli_query($conn, $query))
		{
			echo "<script type='text/javascript'>alert('Success');window.location.assign('login.php');</script>'";
		}else{
			echo "<script type='text/javascript'>alert('Fail');window.location.assign('register.php');</script>'";
		}
	}
?>
<html>
<head>
<meta charset="utf-8">
<title>Reset Password</title>
	
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
	<table align="center" style="font-size:45px"><tr><th><img src="assets/trendbus.jpeg" class="imgservice" width="100px" height="100px"/></th><th width="30px"></th><th>TrndBus</th></tr></table>
	<br>
	<div id="form_wrapper" align="center">
		<form method="post">
 		<br><br>
      <h1 align="center">Reset Password</h1><br>
      <div class="input_container" align="center">
        <input
          placeholder=" &nbsp; Email"
          type="email"
          name="email"
          id="email"
          class="input_field" value="<?php echo $decryption ?>" disabled
        />
		  <br><br>
		  <input
          placeholder=" &nbsp; New Password"
          type="password"
          name="password"
          id="password"
          class="input_field" required
        />
		
        
      
		<br><br>
      <button class="loginbtn" type="submit" name="resetpassword">Confirm</button>	
      <br><br>
        <a href="register.php" style="text-decoration:none; font-size:14px"><span style="font-size: 18px;">Login</span></a>
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