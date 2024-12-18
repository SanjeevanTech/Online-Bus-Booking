<?php
  session_start();
  error_reporting(0);
  include("dbconnect.php");
    include ("adminusername.php");
?>
<html>
<head>
<meta charset="utf-8">
<title>TrendBus Booking</title>

<style>
body{
    background-image: linear-gradient(rgba(0, 0, 0, 0.3),rgba(0, 0, 0, 0.3)), url("assets/bg1.jpg");
    position: relative;
}
.nav{
    color: #FFFFFF;
}
.nav a{
    padding: 10px;
    font-size: 16px;
    color: white;
}
.nav a:hover{
    background: #FFD100;
    box-shadow: 0px 1px 10px #fff;
    color: black;
    transition: 0.3s;
    border-radius: 10px;
}
.bg{
    padding-top: 50px;
    padding-bottom: 50px;
    color: white;
}
.transbox {
    background-color: #000000;
    padding: 5px;
}
input[type=text], select, input[type=date] {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    border-radius: 4px;
    box-sizing: border-box;
}
.searchbtn{
    color: Black;
    font-size: 16px;
    transition: 0.3s;
    border-radius: 5px;
    border: 5px;
    border-color: aliceblue;
    padding: 20px 30px;
}
.searchbtn:hover{
    background: #FFD100;
}
.searchbtn span {
    cursor: pointer;
    display: inline-block;
    position: relative;
    transition: 0.5s;
}
.searchbtn span:after {
    content: '\00bb';
    position: absolute;
    opacity: 0;
    top: 0;
    right: -20px;
    transition: 0.3s;
}
.searchbtn:hover span {
    padding-right: 25px;
}
.searchbtn:hover span:after {
    opacity: 1;
    right: 0;
}
.middle {
    transition: 0.5s ease;
    opacity: 0;
    position: absolute;
    top: 50%;
    left: 100%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    text-align: center;
}
.container {
    position: relative;
    width: 50%;
}
.image{
    border-radius: 20px;
    box-shadow: 0 0 20px 0px rgba(0, 0, 0, 0.5);
}
.container:hover .image {
    opacity: 0.3;
}
.container:hover .middle {
    opacity: 1;
}
.text {
    font-size: 16px;
}
.imgservice{
    border-radius: 50%;
    width: 100px;
    height: 100px;
    box-shadow: 0 0 20px 0px rgba(0, 0, 0, 0.5);
}
.service{
    color: rgb(150, 250, 250);
    font-size: 18px;
}
.login{
    font-family: Arvo;
    border-radius: 15px;
    height: 30px;
    width: 70px;
    border: 0px;
    background-color: #FFFFFF;
}
.login:hover{
    background: #FFD100;
    box-shadow: 0px 1px 10px #fff;
    color: black;
    transition: 0.3s;
    border-radius: 15px;
}
.sinbus{
    color: #FFFFFF;
    font-family: Arvo;
}
</style>
</head>

<body style="font-family:Arvo; margin:0;">
<?php include 'navigation.php'; ?>
<?php
$username = $_SESSION['Admin'];

$sql="SELECT name FROM users WHERE emailuser='$username'";
$result=$conn->query($sql);
if($result){
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $name=$row['name'];
        }
}
}
?>
<?php 

if(!(isset($_SESSION['Admin']))){
    $message="Welcome to TrendBus ";
}
else{
    $message = "Welcome to TrendBus Booking  👋 $name 👋 ";
}
?>

<div class="bg">
    <br><br><br><br>
    <p style="padding-left: 50px; font-size: 35px;text-align: center; "><b><?php echo $message?></b></p>
    <p style="text-align: center; font-size:20px;">Want to Book a Bus Ticket?</p>
    <br>
    <div align="center">
        <button class="searchbtn" onclick="window.location.href='schedule.php'"><span>Book Now</span></button>
    </div>
</div>

<div><br><br><br>
    <p align="center" style="font-size: 24px; font-weight: bold;color:white;">Why Book with Us?</p><br>
    <table align="center" width="60%">
        <tr align="center">
            <td width="100px"><img src="assets/GoodBusServices.jpeg" class="imgservice"></td>
            <td width="100px"><img src="assets/EasyBooking.png" class="imgservice"></td>
            <td width="100px"><img src="assets/GoodCustomerServices.png" class="imgservice"></td>
            <td width="100px"><img src="assets/TrustworthyBusCompany.jpeg" class="imgservice"></td>
            <td width="100px"><img src="assets/FreeCancellation.png" class="imgservice"></td>
        </tr>
        <tr>
            <td width="100px"><p class="service" align="center">Good Bus Services</p></td>
            <td width="100px"><p class="service" align="center">Easy Booking</p></td>
            <td width="100px"><p class="service" align="center">Good Customer Services</p></td>
            <td width="100px"><p class="service" align="center">Trustworthy Bus Company</p></td>
            <td width="100px"><p class="service" align="center">Free Cancellation</p></td>
        </tr>
    </table>
    <br><br><br>
</div>

</body>
</html>

<script>
function login(){
    window.location.assign('login.php');
}
function logout(){
    window.location.assign('logout.php');
}
</script>
