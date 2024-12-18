<?php
session_start();
include("dbconnect.php");


    $email=$_SESSION['Admin'];
  

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Invalid email format']);
        exit;
    }
    $url = "http://localhost/online-bus-ticket-booking-Website1/newview.php?email=";
    $from = "sanjeevan2006@yahoo.com";
    $subject = "Your Bus Ticket Details from TrendBus";
    $htmlContent = "<p>Your ticket has been successfully booked. Please bring this email for verification.<br>
    ticket is available in TrendBus wesite.</p>";
    $headers = "From: $from\r\n";
    $headers .= "Reply-To: $from\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8\r\n";
   
    if (mail($email, $subject, $htmlContent, $headers)) {
        // If email is sent successfully
        echo "<script type='text/javascript'>
                alert('Booking Sussusfully Conformation is come gmail');
                window.location.assign('history.php');  // Redirect to success page
              </script>";
      } else {
        // If email failed to send
        echo "<script type='text/javascript'>
                alert('Failed to send email');
                window.location.assign('schedule.php.php');  // Redirect to failure page
              </script>";
      }

?>
