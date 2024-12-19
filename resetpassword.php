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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Reset Password</title>
    
    <style>
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url("assets/bg1.jpg");
            background-size: cover;
            background-position: center;
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Roboto', sans-serif;
            padding: 20px;
            box-sizing: border-box;
        }

        #form_wrapper {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px; /* Set a max width for better centering */
            padding: 40px;
            text-align: center;
            backdrop-filter: blur(15px);
            animation: fadeIn 1s ease-out;
        }

        h1 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #333;
            font-weight: 600;
        }

        .input_field {
            width: 100%; /* Full width */
            height: 45px; /* Increased height for better usability */
            border-radius: 25px;
            border: 1px solid #ccc;
            background-color: #f7f7f7;
            font-size: 16px;
            margin-bottom: 20px; /* Space between inputs */
            padding: 0 20px; /* Padding for input text */
            transition: 0.3s ease;
            box-sizing: border-box; /* Ensures padding is included in width */
        }

        .input_field:focus {
            border-color: #0088ff;
            background-color: #ffffff;
            box-shadow: 0 0 5px rgba(0, 136, 255, 0.6);
            outline: none;
        }

        .loginbtn {
            width: 100%;
            height: 45px;
            border-radius: 25px;
            background-color: #0088ff;
            color: white;
            font-size: 18px;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: 0.3s ease;
        }

        .loginbtn:hover {
            background-color: #005fbb;
        }

        a {
            display: inline-block; /* Ensures width and height take effect */
            width: 100%;
            height: 40px;
            border-radius: 15px;
            background-color: #0088ff;
            color: #FFFFFF;
            font-weight: bold;
            text-align: center; /* Center text horizontally */
            line-height: 40px; /* Center text vertically */
            text-decoration: none; /* Remove underline */
            font-size: 18px;
            margin-top: 20px; /* Space above the link */
        }

        a:hover {
            background-color: #00AB0F;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(-50px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <div id="form_wrapper">
        <form method="post">
            <h1>Reset Password</h1>
            <input
                placeholder="Email"
                type="email"
                name="email"
                id="email"
                class="input_field"
                value="<?php echo $decryption; ?>" 
                disabled
            />
           
			<input
                placeholder="New Password"
                type="password"
                id="password"
                name="password"
                class="input_field"
                minlength="8"
				required
            />
            <button class="loginbtn" type="submit" name="resetpassword">Confirm</button>
            <a href="register.php">Login</a>
        </form>
    </div>
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