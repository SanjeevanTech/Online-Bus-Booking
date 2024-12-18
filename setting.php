

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


<html>
<head>
  <meta charset="utf-8">
  <title>Update Profile</title>
  
  <style>
    /* Styling for the page */
    body {
      background-color: #08ACC6;
    }
    #form_wrapper {
      background: white;
      border-radius: 20px;
      box-shadow: 0 0 20px 0px rgba(0, 0, 0, 0.5);
      width: 35%;
      margin-left: 500px;
      margin-right: 500px;
      padding: 20px;
    }
    .input_field {
      width: 350px;
      height: 40px;
      border-radius: 15px;
      border: 0px;
      background-color: #E0E0E0;
      font-size: 16px;
      margin-bottom: 15px;
    }
    .updatebtn {
      width: 350px;
      height: 40px;
      border-radius: 15px;
      background-color: #1AEB1D;
      color: #FFFFFF;
      font-weight: bold;
      border: 0;
      font-size: 18px;
    }
    .updatebtn:hover {
      background-color: #00AB0F;
    }
  </style>
</head>

<body style="font-family:Arvo; margin:0;">
  <br><br>
  <table align="center" style="font-size:45px"><tr><th><img src="assets/trendbus.jpeg" class="imgservice" width="100px" height="100px"/></th><th width="30px"></th><th>trendbus</th></tr></table>
  <br>
  <div id="form_wrapper" align="center">
    <form method="post">
      <h1 align="center">Update Profile</h1><br>
      <div class="input_container" align="center">
        <input
          placeholder="Enter your name"
          type="text"
          name="name"
          class="input_field"
          value="<?php echo htmlspecialchars($user['name']); ?>"
          required
        />
        <br><br>

        <input placeholder=" &nbsp; Phone No" type="text" name="phoneno" id="phoneno" class="input_field" 
        value= "<?php echo htmlspecialchars($user['phoneno']); ?>" required/>
        <br><br>
        <input
          placeholder="Enter new password (leave empty to keep current)"
          type="password"
          name="new_password"
          class="input_field"
        />
        <br><br>
        <button class="updatebtn" type="submit" name="updatebtn">Update</button>
      </div>
    </form>
  </div>
</body>
</html>
