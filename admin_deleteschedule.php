<?php
  session_start();
  error_reporting(E_ALL); // Enable error reporting for debugging
  ini_set('display_errors', 1); // Show errors on the page

  include("dbconnect.php");

  if(!isset($_SESSION['Admin'])){
    echo '<script type="text/javascript">window.location.assign("home.php");</script>';
    exit(); // Stop execution after redirection
  }

  $temp = $_GET['id'];
  $id = base64_decode($temp);
  $Email = $_SESSION['Admin'];
    
  // Non-NULL Initialization Vector for decryption
  $decryption_iv = '1234567891011121';

  // Store the decryption key
  $decryption_key = "travel123";
  $ciphering = "AES-128-CTR";

  // Use OpenSSL Encryption method
  $iv_length = openssl_cipher_iv_length($ciphering);
  $options = 0;

  // Use openssl_decrypt() function to decrypt the data
  $decryption = openssl_decrypt($id, $ciphering, $decryption_key, $options, $decryption_iv);

  // Debugging: Print the decrypted value
  // echo "Decryption result: " . $decryption;

  $query = "SELECT * FROM schedule WHERE scheduleID = '$decryption'";
  $result = $conn->query($query);

  if ($result->num_rows > 0) {
    // Data exists, proceed with deletion
    if ($Email == '' || $id == '') {
      echo '<script type="text/javascript">alert("Variable no value");window.location.assign("home.php");</script>';
    } else {
      $query = "DELETE FROM `schedule` WHERE scheduleID='$decryption'";
      if (mysqli_query($conn, $query)) {
        echo "<script type='text/javascript'>alert('Success: " . htmlspecialchars($decryption, ENT_QUOTES, 'UTF-8') . "');window.location.assign('admin_schedule.php');</script>";
      } else {
        echo "<script type='text/javascript'>alert('Fail: " . mysqli_error($conn) . "');window.location.assign('admin_schedule.php');</script>";
      }
    }
  } else {
    echo "<script type='text/javascript'>alert('No data inside database');window.location.assign('admin_schedule.php');</script>";
  }
?>
