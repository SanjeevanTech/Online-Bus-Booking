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
		$name = $_POST['name'];
		//$phone = $_POST['phone'];


		$query ="INSERT INTO `users`(`email`, `name`, `password`) VALUES ('$email','$name','$password')";

		if(mysqli_query($conn, $query))
		{
			echo "<script type='text/javascript'>alert('Success');window.location.assign('login.php');</script>'";
		}else{
			echo "<script type='text/javascript'>alert('Email has been used! pls try another email!');window.location.assign('register.php');</script>'";
		}
	}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Registration</title>
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
            text-decoration: none;
            font-size: 14px;
            margin-top: 20px;
            display: inline-block;
            color: #0088ff; /* Link color */
        }

        a:hover {
            text-decoration: underline; /* Underline on hover */
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
    <form method="post">
        <div id="form_wrapper">
            <h1>Registration</h1>
            
            <input placeholder="Email" type="email" name="email" id="email" class="input_field" required />
            
            <input placeholder="Username" type="text" name="name" id="name" class="input_field" required />
            
            <input placeholder="Phone No" type="text" name="phoneno" id="phoneno" class="input_field" 
                required pattern="^(070|071|072|074|075|076|077|078)\d{7}$" 
                title="Please enter a valid phone number" />
            
            <input placeholder="Password" type="password" name="password" id="password" class="input_field" required minlength="8" />
            
            <button class="loginbtn" type="submit" name="registerbtn">Register</button>
            
            <a href="login.php">Already have an account?</a>
        </div>
    </form>
</body>
</html>
