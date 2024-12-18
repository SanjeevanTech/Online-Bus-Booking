<?php 
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include("dbconnect.php");


if (!isset($_SESSION['Admin'])) {
    echo '<script>alert("Please login first!"); window.location.href="login.php";</script>';
    exit();
}

$ScheduleID=$_GET['ID']; 

$query = $conn->prepare("SELECT 
    ticket.emailuser AS Email, ticket.Seat, ticket.Name, ticket.Phone,
    schedule.scheduleFrom, schedule.scheduleDestination, schedule.scheduleDate, schedule.scheduleTime 
    FROM ticket 
    INNER JOIN schedule ON ticket.scheduleID = schedule.scheduleID 
    WHERE ticket.id = ?");
$query->bind_param("i", $ScheduleID);
$query->execute();
$result = $query->get_result();

$ticket = $result->fetch_assoc();

if (empty($ticket['Email'])) {
    echo '<script>window.location.href="newview.php";</script>';
    exit();
}
?>


<html>
<head>
    <title>View Ticket</title>
<style type="text/css">@import url('https://fonts.googleapis.com/css?family=Oswald');
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

.fl-left{float: left}

.fl-right{float: right}

.container
{
  width: 90%;
  margin: 100px auto
}

h1
{
  text-transform: uppercase;
  font-weight: 900;
  border-left: 10px solid #fec500;
  padding-left: 10px;
  margin-bottom: 30px
}

.row{overflow: hidden}

.card
{
  display: table-row;
  width: 60%;
  background-color: #fff;
  color: #989898;
  margin-bottom: 10px;
  font-family: 'Oswald', sans-serif;
  text-transform: uppercase;
  border-radius: 4px;
  position: relative;
 margin-left: 15%;
}

.card + .card{margin-left: 2%}

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
  -webkit-transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%)
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
  font-size: 130%
}

.row:last-child .card:last-of-type .card-cont h3
{
  text-decoration: line-through
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
  background-color: #D8DDE0;
  color: #fff;
  text-align: center;
  line-height: 30px;
  border-radius: 2px;
  position: absolute;
  right: 10px;
  bottom: 10px
}
.
.row:last-child .card:first-child .card-cont a
{
  background-color: #037FDD
}

.row:last-child .card:last-child .card-cont a
{
  background-color: #F8504C
}

@media screen and (max-width: 860px)
{
  .card
  {
    display: block;
    float: none;
    width: 100%;
    margin-bottom: 10px
  }
  
  .card + .card{margin-left: 0}
  
  .card-cont .even-date,
  .card-cont .even-info
  {
    font-size: 75%
  }
}
.nav a{
		padding: 10px;
		font-size: 18px;
		color:white;
	}
	.nav a:hover{
		background:#E88687;
		box-shadow: 0px 1px 10px;
		color:white;
		transition:0.3s;
		border-radius: 10px;
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
    -webkit-transition: background-color 100ms linear;
    -ms-transition: background-color 100ms linear;
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



.nav a:hover{
	background:#FFD100;
	box-shadow: 0px 1px 10px #fff;
	color: black;
	transition:0.3s;
	border-radius: 10px;
}
	</style>
</head>
<body style="font-family:Arvo; margin:0;">
	<div class="no-print">
	<?php include 'navigation.php'; ?>
		
	</div>
<section class="container">
<h1></h1>
  <div class="row">
    <article class="card fl-left">
      <section class="date">
        <time datetime="23th feb">
		 <?php
		  $str =  (explode("-",$ticket['scheduleDate']));
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
            Please bring this ticket when depature

            <?php echo "<h1> $ScheduleID </h1>";
            ?>
          </p>
        </div>
		 
        <a>TrendBus.com</a>
      </section>
    
  </div>
  <div class="row">
    <div class="no-print" style="text-align: right; margin-right: 25%; display: flex; justify-content: flex-end;">
        <button onclick="window.location.assign('history.php')" class="btn btn-warning btn-round-2" style="margin-right: 15px;">Back</button>
        <button onclick="window.print()" class="btn btn-success btn-round-2">Print</button>
    </div>
</div>

</div>
 <script type="text/javascript"></script> 
</div>
 </body>
 </html>
