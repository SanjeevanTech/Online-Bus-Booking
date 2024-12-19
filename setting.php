

<?php
  session_start();
  include("dbconnect.php");

  // Redirect if not logged in
  if (!isset($_SESSION['Admin'])) {
    echo '<script type="text/javascript">window.location.assign("login.php");</script>';
    exit;
  }

  $email = $_SESSION['Admin'];

  // Fetch user data to pre-fill the form
  $query = "SELECT * FROM users WHERE emailuser = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();
  $user = $result->fetch_assoc();

  // Update user details if form is submitted
  if (isset($_POST['updatebtn'])) {
    $name = $_POST['name'];
    $phoneno = $_POST['phoneno'];
    $new_password = $_POST['new_password'];

    // If a new password is provided, hash it
    if (!empty($new_password)) {
      // Hash the new password
      $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    } else {
      // Keep the old password if not updating
      $hashed_password = $user['password'];
    }

    // Update query
    $update_query = "UPDATE users SET name = ?, phoneno = ?, password = ? WHERE emailuser = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ssss", $name, $phoneno, $hashed_password, $email); // Bind all parameters correctly

    if ($stmt->execute()) {
      echo "<script type='text/javascript'>alert('Profile updated successfully!'); window.location.assign('home.php');</script>";
    } else {
      echo "<script type='text/javascript'>alert('Failed to update profile.'); window.location.assign('setting.php');</script>";
    }
  }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Update Profile</title>
    
    <style>
        /* Styling for the page */
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url("assets/bg1.jpg");
            background-size: cover;
            background-position: center;
            height: 100vh;
            margin: 0;
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
            margin-bottom: 20px;
            padding: 0 20px;
            transition: 0.3s ease;
            box-sizing: border-box; /* Ensures padding is included in width */
        }

        .input_field:focus {
            border-color: #0088ff;
            background-color: #ffffff;
            box-shadow: 0 0 5px rgba(0, 136, 255, 0.6);
            outline: none;
        }

        .updatebtn {
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

        .updatebtn:hover {
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
            <h1>Update Profile</h1>
            <input
                placeholder="Enter your name"
                type="text"
                name="name"
                class="input_field"
                value="<?php echo htmlspecialchars($user['name']); ?>"
                required
            />
            <input 
                type="text" 
                id="phoneno" 
                name="phoneno" 
                class="input_field" 
                placeholder="Phone No" 
                required 
                pattern="^(070|071|072|074|075|076|077|078)\d{7}$" 
                title="Please enter a valid phone number" 
                value="<?php echo htmlspecialchars($user['phoneno']); ?>"
            />
            <input
                placeholder="Enter new password (leave empty to keep current)"
                type="password"
                name="new_password"
                class="input_field"
                minlength="8"
            />
            <button class="updatebtn" type="submit" name="updatebtn">Update</button>
        </form>
    </div>
</body>
</html>

