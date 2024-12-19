<?php 
  session_start();
  error_reporting(0);
  include("dbconnect.php");
  if(!isset($_SESSION['Admin'])){
     echo '<script type="text/javascript">alert("Please login first!!");window.location.assign("login.php");</script>';
  }

  $temp = $_GET['id'];
  $id = base64_decode($temp);

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

  $query = "SELECT * FROM `ticket` 
          INNER JOIN `schedule` 
          ON ticket.scheduleID = schedule.scheduleID 
          WHERE ticket.emailuser = '$decryption' ";





  $result = $conn->query($query);

  // Initialize an empty array for storing tickets
  $tickets = array();
  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          // Store each ticket's information
          $tickets[] = array(
              'Email' => $row["emailuser"],
              'Seat' => $row["Seat"],
              'Name' => $row["Name"],
              'Phone' => $row["Phone"],
              'scheduleFrom' => $row["scheduleFrom"],
              'scheduleDestination' => $row["scheduleDestination"],
              'scheduleDate' => $row["scheduleDate"],
              'scheduleTime' => $row["scheduleTime"]
          );
      }
  }

  if (empty($tickets)) {
    echo '<script type="text/javascript">window.location.assign("view.php");</script>';
  }
?>

<html>
<head>
    <title>View Tickets</title>
    <style type="text/css">
       @import url('https://fonts.googleapis.com/css?family=Oswald');

*
{
  margin: 0;
  padding: 0;
  border: 0;
  box-sizing: border-box
}

body
{
  background-color: #dadde6;
  font-family: arial;
}

.container
{
  width: 90%;
  margin-right: auto;
  margin-left: auto;
  margin-top: 10px;
  margin-bottom: 0;
}

h1
{
  text-transform: uppercase;
  font-weight: 900;
  border-left: 10px solid #fec500;
  padding-left: 10px;
  margin-bottom: 30px
}

.row{
  display: flex;
  flex-wrap: wrap;
  gap: 20px; /* Adds spacing between the cards */
  justify-content: center;
}

.card
{
  width: 48%;  /* Adjust width for responsiveness */
  background-color: #fff;
  color: #989898;
  margin-bottom: 10px;
  font-family: 'Oswald', sans-serif;
  text-transform: uppercase;
  border-radius: 4px;
  position: relative;
}

.date
{
  display: table-cell;
  width: 25%;
  position: relative;
  text-align: center;
  border-right: 2px dashed #dadde6
}

.date:before,
.date:after
{
  content: "";
  display: block;
  width: 30px;
  height: 30px;
  background-color: #DADDE6;
  position: absolute;
  top: -15px ;
  right: -15px;
  z-index: 1;
  border-radius: 50%
}

.date:after
{
  top: auto;
  bottom: -15px
}

.date time
{
  display: block;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}

.date time span{display: block}

.date time span:first-child
{
  color: #2b2b2b;
  font-weight: 600;
  font-size: 250%
}

.date time span:last-child
{
  text-transform: uppercase;
  font-weight: 600;
  margin-top: -10px
}

.card-cont
{
  display: table-cell;
  width: 75%;
  font-size: 85%;
  padding: 10px 10px 30px 50px
}

.card-cont h3
{
  color: #3C3C3C;
  font-size: 130%;
  text-decoration: none;
}

.card-cont > div
{
  display: table-row
}

.card-cont .even-date i,
.card-cont .even-info i,
.card-cont .even-date time,
.card-cont .even-info p
{
  display: table-cell
}

.card-cont .even-date i,
.card-cont .even-info i
{
  padding: 5% 5% 0 0
}

.card-cont .even-info p
{
  padding: 30px 50px 0 0
}

.card-cont .even-date time span
{
  display: block
}

.card-cont a
{
  display: block;
  text-decoration: none;
  width: 80px;
  height: 30px;
  background-color: #037FDD;
  color: #fff;
  text-align: center;
  line-height: 30px;
  border-radius: 2px;
  position: absolute;
  right: 10px;
  bottom: 10px
}

@media screen and (max-width: 860px)
{
  .card
  {
    display: block;
    width: 100%;
    margin-bottom: 10px;
  }

  .card-cont .even-date,
  .card-cont .even-info
  {
    font-size: 75%;
  }
}

@media print {
  .no-print {
    visibility: hidden;
  }
}

.btn {
  appearance: none;
  -webkit-appearance: none;
  font-family: sans-serif;
  cursor: pointer;
  padding: 12px;
  min-width: 100px;
  border: 0px;
  transition: background-color 100ms linear;
}

.btn:focus, .btn.focus {
  outline: 0;
}

.btn-round-1 {
  border-radius: 8px;
}

.btn-round-2 {
  border-radius: 20px;
}

.btn-dark {
  background: #000;
  color: #ffffff;
}

.btn-dark:hover {
  background: #212121;
  color: #ffffff;
}

.btn-light {
  background: #ededed;
  color: #000;
}

.btn-light:hover {
  background: #dbdbdb;
  color: #000;
}

.btn-primary {
  background: #3498db;
  color: #ffffff;
}

.btn-primary:hover {
  background: #2980b9;
  color: #ffffff;
}

.btn-success {
  background: #2ecc71;
  color: #ffffff;
}

.btn-success:hover {
  background: #27ae60;
  color: #ffffff;
}

.btn-warning {
  background: #2ecc71;
  color: #ffffff;
}

.btn-warning:hover {
  background: #27ae60;
  color: #ffffff;
}

    </style>
</head>
<body style="font-family:Arvo; margin:0;">
    <div class="no-print">
        <?php include 'navigation.php'; ?>
    </div>

    <section class="container">
    <div class="row">
        <?php foreach ($tickets as $ticket): ?>
        <article class="card">
            <section class="date">
                <time datetime="23th feb">
                    <?php
                        $str = explode("-", $ticket['scheduleDate']);
                        echo "<span>$str[2]</span><span>-$str[1]-$str[0]</span>";
                    ?>
                </time>
            </section>
            <section class="card-cont">
                <small><?php echo $ticket['Name'] ?></small>
                <h3><?php echo $ticket['scheduleFrom']." - " .$ticket['scheduleDestination']." - ".$ticket['scheduleTime'] ?></h3>
                <div class="even-date">
                    <i class="fa fa-calendar"></i>
                    <time>
                        <span>Seat NO : <?php echo $ticket['Seat']?></span>
                        <span>Email : <?php echo $ticket['Email']?></span>
                        <span>Phone : <?php echo $ticket['Phone']?></span>
                    </time>
                </div>
                <div class="even-info">
                    <i class="fa fa-map-marker"></i>
                    <p>
                        Please bring this ticket when departure
                    </p>
                </div>
                <a>TrendBus.com</a>
            </section>
        </article>
        <?php endforeach; ?>
    </div>

    <div class="no-print" style="text-align: right; margin-right: 25%; display: flex; justify-content: flex-end;">
        <button onclick="window.location.assign('history.php')" class="btn btn-warning btn-round-2" style="margin-right: 15px;">Back</button>
        <button onclick="window.print()" class="btn btn-success btn-round-2">Print</button>
    </div>
</section>

</body>
</html>
