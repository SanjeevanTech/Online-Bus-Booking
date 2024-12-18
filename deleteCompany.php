<?php
session_start();
include("dbconnect.php");

if (!isset($_SESSION['Admin'])) {
    echo '<script type="text/javascript">window.location.assign("home.php");</script>';
    exit();
}

$temp = $_GET['id'];
$id = base64_decode($temp);
$Email = $_SESSION['Admin'];

// Non-NULL Initialization Vector for decryption
$decryption_iv = '1234567891011121';

// Store the decryption key
$decryption_key = "travel123";
$ciphering = "AES-128-CTR";

// Use OpenSSl Encryption method
$iv_length = openssl_cipher_iv_length($ciphering);
$options = 0;
// Use openssl_decrypt() function to decrypt the data
$decryption = openssl_decrypt($id, $ciphering, $decryption_key, $options, $decryption_iv);

if ($decryption === false) {
    echo '<script type="text/javascript">alert("Decryption failed");window.location.assign("home.php");</script>';
    exit();
}

$query = "SELECT * FROM `company` WHERE `companyID` = '$decryption'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $companyName = $row["companyName"];
        $companyDetail = $row["companyDetail"];
        $video = $row["video"];
        $audio = $row["audio"];
    }
} else {
    echo '<script type="text/javascript">alert("No record found");window.location.assign("home.php");</script>';
    exit();
}

if (empty($Email) || empty($id)) {
    echo '<script type="text/javascript">alert("Variable has no value");window.location.assign("home.php");</script>';
    exit();
} else {
    $query = "DELETE FROM `company` WHERE companyID = '$decryption'";

    if (mysqli_query($conn, $query)) {
        echo '<script type="text/javascript">alert("Success");window.location.assign("admin_companylist.php");</script>';
    } else {
        echo '<script type="text/javascript">alert("Fail: ' . mysqli_error($conn) . '");window.location.assign("admin_companylist.php");</script>';
    }
}
?>
