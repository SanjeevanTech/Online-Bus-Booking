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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Forgot Password</title>
    
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
            width: 75%;
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
            width: 75%;
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
            background-color: #005fbb;
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
                required
            />
            <button class="loginbtn" name="registerbtn" type="submit">Reset Password</button>
            <a href="login.php">Login</a>
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