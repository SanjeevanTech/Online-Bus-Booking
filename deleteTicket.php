<?php 
session_start();
include("dbconnect.php");
$todaydate = date("Y-m-d");

if (!isset($_SESSION['Admin'])) {
    echo '<script type="text/javascript">window.location.assign("login.php");</script>';
    exit;
}

$temp = $_GET['id'];
$id = base64_decode($temp);

// Non-NULL Initialization Vector for decryption
$decryption_iv = '1234567891011121';
$decryption_key = "travel123";
$ciphering = "AES-128-CTR";

$decryption = openssl_decrypt($id, $ciphering, $decryption_key, 0, $decryption_iv);

// Prepare statement to fetch ticket details
$stmt = $conn->prepare("SELECT ticket.*, 
                               schedule.scheduleID,  
                               schedule.schedulePrice,
                               schedule.scheduleTime,
                               schedule.scheduleDate
                        FROM `ticket`
                        INNER JOIN `schedule` ON ticket.scheduleID = schedule.scheduleID 
                        WHERE ticket.id =?");
$stmt->bind_param("s", $decryption);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $scheduleID = $row["scheduleID"];
        $Seat = $row["Seat"];
        $Name = $row["Name"];
        $Phone = $row["Phone"];
        $date = $row["scheduleDate"];
        $price = $row["schedulePrice"];
        $emailuser = $row["emailuser"];
        $Time = $row["scheduleTime"];  // Fetch scheduleTime from the schedule table
    }
}

if (empty($emailuser) || empty($id)) {
    echo '<script type="text/javascript">window.location.assign("history.php");</script>';
    exit;
} else {
    // Prepare DELETE statement with condition on scheduleDate and scheduleTime
    $deleteStmt = $conn->prepare("
        DELETE ticket
    FROM `ticket`
    INNER JOIN `schedule` ON ticket.scheduleID = schedule.scheduleID
    WHERE ticket.id = ?
    AND (
        -- For today, allow deletion only if the scheduled time is more than 2 hours ahead
        (
            DATE(schedule.scheduleDate) = CURDATE()
            AND TIME(schedule.scheduleTime) > NOW() + INTERVAL 2 HOUR
        )
        -- For any future date, allow deletion
        OR (
            DATE(schedule.scheduleDate) > CURDATE()
        )
    )
    ");

    // Check if the prepare() function returned false
    if (!$deleteStmt) {
        // Output the error message for debugging
        die("Error preparing the DELETE statement: " . $conn->error);
    }

    // Bind the necessary parameter (ticket ID)
    $deleteStmt->bind_param("s", $decryption);

    // Execute the delete statement and check for success
    if ($deleteStmt->execute()) {
        echo "<script type='text/javascript'>alert('Success');window.location.assign('history.php');</script>";
    } else {
        echo "<script type='text/javascript'>alert('Fail');window.location.assign('history.php');</script>";
    }
}
?>
