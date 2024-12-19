<?php
session_start([
    'cookie_secure' => true,
    'cookie_httponly' => true,
]);

// Function to generate a random OTP
function generateOTP($length = 6) {
    $otp = '';
    for ($i = 0; $i < $length; $i++) {
        $otp .= random_int(0, 9);
    }
    return $otp;
}

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $response = ['success' => false, 'message' => 'Invalid action'];

    if ($action === 'send_otp') {
        $email = $_POST['email'] ?? '';

        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response['message'] = 'Invalid email format';
        } else {
            // Generate and store OTP
            $otp = generateOTP();
            $_SESSION['otp'] = $otp;

            // Email content
            $from = "sanjeevan2006@yahoo.com";
            $subject = "Verification Code from Bus Booking";
            $htmlContent = "<p>Your verification One Time Password (OTP) is: <strong>$otp</strong></p>";
            $headers = "From: $from\r\n";
            $headers .= "Reply-To: $from\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8\r\n";

            // Send the email
            if (mail($email, $subject, $htmlContent, $headers)) {
                $response = ['success' => true, 'message' => 'OTP sent to your email'];
            } else {
                $response['message'] = 'Failed to send OTP. Please try again.';
            }
        }
    } elseif ($action === 'verify_otp') {
        $entered_otp = $_POST['otp'] ?? '';

        // Verify OTP
        if (isset($_SESSION['otp']) && $entered_otp == $_SESSION['otp']) {
            $response = ['success' => true, 'message' => 'OTP verified successfully'];
            unset($_SESSION['otp']); // Clear OTP after verification
        } else {
            $response['message'] = 'Invalid OTP. Please try again.';
        }
    }

    // Send JSON response
    echo json_encode($response);
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>OTP Verification</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* Compact spinner near buttons */
        .spinner {
            display: none;
            margin-left: 10px;
            width: 20px;
            height: 20px;
            vertical-align: middle;
        }

        .response-message {
            margin-top: 10px;
            color: #333;
        }
    </style>
</head>
<body>
    <h1>OTP Verification</h1>
    <form id="otpForm">
        <!-- Email Input -->
        <div id="emailSection">
            <label for="email">Enter your Email:</label>
            <input type="email" id="email" name="email" required placeholder="Enter your email">
            <button type="button" id="sendOtpBtn">Send OTP</button>
            <img src="https://i.gifer.com/ZZ5H.gif" class="spinner" id="emailSpinner" alt="Loading">
        </div>

        <!-- OTP Verification Input (Hidden Initially) -->
        <div id="otpSection" style="display: none;">
            <label for="otp">Enter Verification Code:</label>
            <input type="text" id="otp" name="otp" placeholder="Enter your OTP">
            <button type="button" id="verifyOtpBtn">Verify OTP</button>
            <img src="https://i.gifer.com/ZZ5H.gif" class="spinner" id="otpSpinner" alt="Loading">
        </div>

        <div id="responseMessage" class="response-message"></div>
    </form>

    <script>
        $(document).ready(function () {
            // Show spinner
            function showSpinner(spinnerId) {
                $(spinnerId).show();
            }

            // Hide spinner
            function hideSpinner(spinnerId) {
                $(spinnerId).hide();
            }

            // Handle Send OTP
            $('#sendOtpBtn').click(function () {
                const email = $('#email').val();

                if (!email) {
                    $('#responseMessage').text('Please enter your email.');
                    return;
                }

                showSpinner('#emailSpinner'); // Show spinner near Send OTP button

                $.ajax({
                    url: '', // Same page
                    method: 'POST',
                    data: {
                        action: 'send_otp',
                        email: email
                    },
                    success: function (response) {
                        hideSpinner('#emailSpinner'); // Hide spinner
                        const res = JSON.parse(response);
                        $('#responseMessage').text(res.message);

                        if (res.success) {
                            $('#otpSection').show(); // Show OTP input field
                            $('#emailSection input').prop('readonly', true); // Make email readonly
                        }
                    },
                    error: function () {
                        hideSpinner('#emailSpinner'); // Hide spinner
                        $('#responseMessage').text('An error occurred. Please try again.');
                    }
                });
            });

            // Handle Verify OTP
            $('#verifyOtpBtn').click(function () {
                const otp = $('#otp').val();

                if (!otp) {
                    $('#responseMessage').text('Please enter the OTP.');
                    return;
                }

                showSpinner('#otpSpinner'); // Show spinner near Verify OTP button

                $.ajax({
                    url: '', // Same page
                    method: 'POST',
                    data: {
                        action: 'verify_otp',
                        otp: otp
                    },
                    success: function (response) {
                        hideSpinner('#otpSpinner'); // Hide spinner
                        const res = JSON.parse(response);
                        $('#responseMessage').text(res.message);

                        if (res.success) {
                            $('#otpSection').hide(); // Hide OTP section on success
                        }
                    },
                    error: function () {
                        hideSpinner('#otpSpinner'); // Hide spinner
                        $('#responseMessage').text('An error occurred. Please try again.');
                    }
                });
            });
        });
    </script>
</body>
</html>
