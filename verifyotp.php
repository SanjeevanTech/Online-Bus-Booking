<?php
session_start();

// Check if OTP form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_otp = $_POST['otp'];

    // Verify the OTP
    if (isset($_SESSION['otp']) && $entered_otp == $_SESSION['otp']) {
        echo "OTP verified successfully!";
        // Clear the OTP from session
        unset($_SESSION['otp']);
    } else {
        echo "Invalid OTP. Please try again.";
    }

}
?>

<!-- HTML Form to enter OTP -->
<form method="post" action="">
    <input type="text" name="otp" required placeholder="Enter your OTP">
    <button type="submit">Verify OTP</button>
</form>