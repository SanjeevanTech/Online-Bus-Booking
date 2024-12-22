<?php
session_start();
error_reporting(E_ALL);  // Enable error reporting to help debug (turn off in production)

include("dbconnect.php");

if (isset($_SESSION['Admin'])) {
    echo '<script type="text/javascript">window.location.assign("schedule.php");</script>';
    exit();
}

if (isset($_POST['loginbtn'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $query = $conn->prepare("SELECT * FROM users WHERE emailuser = ?");
    $query->bind_param("s", $email);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();  
        
        
        if (password_verify($password, $user['password'])) {
       
            $_SESSION['Admin'] = $email;
            echo "<script type='text/javascript'>window.location.assign('home.php');</script>";
            exit();
        } else {
          
            echo "<script type='text/javascript'>alert('Email or Password was wrong!');window.location.assign('login.php');</script>";
            exit();
        }
    } else {
        // User not found
        echo "<script type='text/javascript'>alert('Email or Password was wrong!');window.location.assign('login.php');</script>";
        exit();
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Login</title>
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
        }

        #form_wrapper {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            padding: 40px;
            text-align: center;
            backdrop-filter: blur(15px);
            animation: fadeIn 1s ease-out;
        }

        h1 {
            color: #333;
            font-size: 28px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .input_field {
            width: 100%; /* Full width */
            max-width: 350px; /* Set a max width for better centering */
            height: 45px;
            border-radius: 25px;
            border: 1px solid #ccc;
            background-color: #f7f7f7;
            font-size: 16px;
            padding: 0 20px;
            margin: 0 auto 20px auto; /* Center the input fields */
            transition: 0.3s ease;
        }

        .input_field:focus {
            border-color: #0088ff;
            background-color: #ffffff;
            box-shadow: 0 0 5px rgba(0, 136, 255, 0.6);
            outline: none;
        }

        .loginbtn {
            width: 100%;
            max-width: 350px; /* Set a max width for better centering */
            height: 45px;
            border-radius: 25px;
            background-color: #0088ff;
            color: white;
            font-size: 18px;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: 0.3s ease;
            margin: 0 auto; /* Center the button */
        }

        .loginbtn:hover {
            background-color: #005fbb;
        }

        p, a {
            color: #555;
            font-size: 14px;
            margin-top: 15px;
        }

        a {
            text-decoration: none;
            font-weight: bold;
            color: #0088ff;
        }

        a:hover {
            text-decoration: underline;
        }

        .forgot-password {
            text-align: center; /* Center the forgot password text */
            font-size: 13px;
            margin-top: 10px;
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
            <h1>Login</h1>

            <input placeholder="Email" type="email" name="email" id="email" class="input_field" required />

            <input placeholder="Password" type="password" name="password" id="password" class="input_field" required />

            <button class="loginbtn" type="submit" name="loginbtn">Login</button>

            <div class="forgot-password">
                <p>Forgot <a href="forgotpassword.php">Password?</a></p>
            </div>
            
            <p>Don't have an account? <a href="register.php">Sign up</a></p>
        </form>
    </div>

</body>
</html>
