

<?php 
  session_start();
  error_reporting(E_ALL); // Enable error reporting
  ini_set('display_errors', 1); // Display errors on the page

  include("dbconnect.php");

  if (!isset($_SESSION['Admin'])) {
    echo '<script type="text/javascript">window.location.assign("schedule.php");</script>';
    exit(); // Stop execution after redirection
  }

  $number = count($_POST['SeatNumber']);
 
  $Seat = $_POST['SeatNumber'];
  $ScheduleID = $_POST['ScheduleID'];
  $seatPrice = $_POST['seatPrice'];
  $fail = array();  
  $emailuser = $_SESSION['Admin'];

  // Check if ScheduleID exists in the schedule table
  $checkScheduleID = $conn->prepare("SELECT 1 FROM schedule WHERE scheduleID = ?");
  $checkScheduleID->bind_param("s", $ScheduleID);
  $checkScheduleID->execute();
  $checkScheduleID->store_result();

  if ($checkScheduleID->num_rows == 0) {
    echo "<script type='text/javascript'>alert('Invalid ScheduleID: $ScheduleID');window.location.assign('schedule.php');</script>";
    exit(); // Stop execution if ScheduleID is invalid
  }

  $checkScheduleID->close();

  for ($x = 0; $x < $number; $x++) {
    if ( empty($Seat[$x]) || empty($Name[$x]) || empty($Phone[$x]) || empty($ScheduleID) || empty($seatPrice)) {
      $fail[] = 'fail';
    }
  }

  if (!(empty($fail))) {
    for ($x = 0; $x < $number; $x++) {
      $scID = $ScheduleID;

      $st = $Seat[$x];
      
      
      // Use prepared statements for security
      $sql="SELECT name,phoneno FROM users WHERE emailuser='$emailuser'";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        // Fetch the row into an associative array
        $user = $result->fetch_assoc();
    
        // Save the output variables
        $name = $user['name'];
        $phoneno = $user['phoneno'];

      $stmt = $conn->prepare("INSERT INTO ticket (scheduleID, Seat, Name, Phone, price, emailuser) VALUES ( ?, ?, ?, ?, ?, ?)");
      if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
      }
      $stmt->bind_param("ssssss", $scID, $st, $name, $phoneno, $seatPrice, $emailuser);

      if ($stmt->execute()) {
        echo "<script type='text/javascript'>window.location.assign('mail.php');</script>";
      } else {
        echo "<script type='text/javascript'>alert('Fail: " . $stmt->error . "');window.location.assign('schedule.php');</script>";
      }
      $stmt->close(); // Close the statement
    }
  } 
}
else {
    // Concatenate ScheduleID into the alert message
    $fail_message = "Please fill all required fields. ScheduleID: $ScheduleID";
    echo "<script type='text/javascript'>alert('$fail_message');window.location.assign('schedule.php');</script>";
  }

  $conn->close(); // Close the connection
?>
