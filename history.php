<?php
  session_start();
  error_reporting(0);
  include("dbconnect.php");
  include ("adminusername.php");
   if(!isset($_SESSION['Admin'])){
         echo '<script type="text/javascript">alert("Please login first!!");window.location.assign("login.php");</script>';
     }
	$ciphering = "AES-128-CTR";
	$iv_length = openssl_cipher_iv_length($ciphering);
	$options = 0;
	$encryption_iv = '1234567891011121';
	$encryption_key = "travel123";
    $emailuser= $_SESSION['Admin'];
   if (isset($_POST['update'])) {
		$Name = $_POST['Name'];
	    $Phone = $_POST['Phone'];
		$ID = $_POST['ID'];
		 $query ="UPDATE `ticket` SET `Phone`='$Phone', `Name`='$Name' where id='$ID'";
		if(mysqli_query($conn, $query))
		{
			echo "<script type='text/javascript'>alert('Success');window.location.assign('history.php');</script>";
		}else{
			echo "<script type='text/javascript'>alert('Fail!');window.location.assign('history.php');</script>";
		}
	}

	
		
?>
<!doctype html>
<html lang="en">
  <head>
  	<title>My Booking</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="style/historystyle.css">
	<style>
		body {
				
				background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url("assets/home1.png") center fixed no-repeat;
				background-size:cover;
				
				}
		</style>
	
	
	</head>
	<body style="font-family:Arvo; margin:0;);">
	<?php include 'navigation.php'; ?>

	<?php
if($_SESSION['Admin']==$adminuser){
    $isAdmin = true;
}
 else{
    $isAdmin = false;
 }
$message1 = $isAdmin ? "Admin Booking" : "Customer Booking";
$message = $isAdmin ? "Admin Booking's Ticket" : "Customer Booking's Ticket";
?>
		
	
			<br><br>
		<div class="tab">
			  <button class="tablinks" onclick="openCity(event, 'MyBooking')"><?php echo $message1 ?></button>
			  <button class="tablinks" onclick="openCity(event, 'Deleted')">Cancelled</button>
		</div>
		<br><br><br>
		<div id="MyBooking" class="tabcontent" align="center">				
			<section class="timetable">			 
<br><br>

						<h1 class="heading-section"><?php echo $message ?></h1>
						<br>
									<table border="0" width="95%" align="center" style="background-color: #fefefe;">
									  <thead>
									      <tr><td colspan='11'><hr></td></tr>
										<tr class="tr" height="80px">
											<th>#</th>
											<th>Name</th>
											<th>Email</th>
											<th>Phone Num</th>
											<th>Company Name</th>
											<th>Departure<br>Date & Time</th>
											<th>From</th>
											<th>Destination</th>
											<th>Seat Num</th>
											<th>Price (Rs)</th>
											<th>Booking Date</th>
											<th>Action</th>
										</tr>
									  </thead>
									  <tbody>
										<tr class="alert" role="alert" align="center">
											<?php
											 $num=0; 
											 if($isAdmin){
												$query="SELECT * FROM `ticket` INNER JOIN  `schedule` on ticket.scheduleID = schedule.scheduleID
											          INNER JOIN `company` on schedule.companyID = company.companyID
													  ORDER BY ticket.date DESC ";
											 }
											 else{
												$query="SELECT * FROM `ticket` INNER JOIN  `schedule` on ticket.scheduleID = schedule.scheduleID
											          INNER JOIN `company` on schedule.companyID = company.companyID where ticket.emailuser='$emailuser'
													  ORDER BY ticket.date DESC";
											 }
											 
											$result = $conn->query($query);
											if($result->num_rows > 0){
											     
												
												
											  while ($row = $result ->fetch_assoc()){
											      $NameH[$num] = $row['Name'];
												  $PhoneH[$num] = $row['Phone'];
												  $EmailH[$num] = $row['emailuser'];
												  $companyH[$num]= $row['companyName'];
											      $TimeH[$num] = $row['scheduleTime'];
												  $fromH[$num] = $row['scheduleFrom'];
												  $DestinationH[$num] = $row['scheduleDestination'];
												  $SeatH[$num] = $row['Seat'];
												  $priceH[$num] = $row['price'];
												  $dateH[$num] = $row['date'];
												  $idH[$num] = $row['id'];
												  $sdateH[$num] = $row['scheduleDate'];
												  
												  $num =$num+1;
											  }
											  for($x=0;$x<$num;$x++)
											  {
												   $encryption = openssl_encrypt($idH[$x], $ciphering,$encryption_key, $options, $encryption_iv);
													$encrptID = base64_encode($encryption);

													$encryptionemail = openssl_encrypt($EmailH[$x], $ciphering,$encryption_key, $options, $encryption_iv);
													$encrptemail = base64_encode($encryptionemail);
													$temptablenumber=$x+1;
													echo"
													<tr><td colspan='11'><hr></td></tr>
													<tr>
													<td align='center'>$temptablenumber</td>
                                                    <td align='center'>$NameH[$x]</td>
                                                    <td align='center'>$EmailH[$x]</td>
                                                    <td align='center'>$PhoneH[$x]</td>
                                                    <td align='center'>$companyH[$x]</td>
													<td align='center'>$sdateH[$x] $TimeH[$x]</td>
													<td align='center'>$fromH[$x]</td>
													<td align='center'>$DestinationH[$x]</td>
													<td align='center'>$SeatH[$x]</td>
													<td align='center'>$priceH[$x]</td>
													<td align='center'>$dateH[$x]</td>
													<td align='center'>
													<br>
													<a class='viewbtn' href='view.php?id=$encrptemail'>View</a>
													<br><br>
													<!--<button class='upbtn'onclick='modal($x)'>Update</button>-->
													<br><br>
													<a class='delbtn' href='deleteTicket.php?id=$encrptID'>Delete</a>
													<br><br>
													</td>
													
													</tr>
													";
											  }
												
											}
											?>
										</tbody>
									</table>
				</section>
				<br><br>
		</div>
		<div id="Deleted" class="tabcontent">
			  <section class="timetable">
						 <br><br>
						<h2 class="heading-section" align="center">Cancelled Ticket</h2>
						<br>
									<table border="0" width="95%" align="center" style="background-color: #fefefe;">
									  <thead>
									    <tr><td colspan='10'><hr></td></tr>
										<tr class="tr" height="80px">
											<th>#</th>
											<th>Name</th>
											<th>Email</th>
											<th>Phone Num</th>
											<th>Company Name</th>
											<th>Departure<br>Date & Time</th>
											<th>From</th>
											<th>Destination</th>
											<th width="50px">Seat Num</th>
											<th width="90px">Booking Date</th>		
										</tr>
									  </thead>
									  <tbody>
										<tr class="alert" role="alert">
											<?php
											 $num2=0; 
											 if($isAdmin){
												$query="SELECT * FROM `ticket_delete` INNER JOIN  `schedule` on ticket_delete.scheduleID = schedule.scheduleID 
											 INNER JOIN `company` on schedule.companyID = company.companyID						
											 ORDER BY ticket_delete.date DESC";
											 }
											 
											 else{
												$query="SELECT * FROM `ticket_delete` INNER JOIN  `schedule` on ticket_delete.scheduleID = schedule.scheduleID 
											 INNER JOIN `company` on schedule.companyID = company.companyID
											 where ticket_delete.emailuser='$emailuser'
											 ORDER BY ticket_delete.date DESC";
											 }
											$result = $conn->query($query);
											if ($result->num_rows > 0) {
												while ($row = $result->fetch_assoc()) {
													$num2++;
													extract($row); // Extracts keys of $row as variables
													echo "
													<tr><td colspan='10'><hr></td></tr>
													<tr height='80px'>
														<td align='center'>$num2</td>
														<td align='center'>$Name</td>
														<td align='center'>" . $row['emailuser'] . "</td> 
														<td align='center'>" . $row['Phone'] . "</td> 
														<td align='center'>$companyName</td>
														<td align='center'>$scheduleDate <br> $scheduleTime</td>
														<td align='center'>$scheduleFrom</td>
														<td align='center'>$scheduleDestination</td>
														<td align='center'>$Seat</td>
														<td align='center'>$date</td>
													</tr>";
												}
											}
											
											?>
									  </tbody>
									</table>
				  					<br><br>											
				</section>
				<br><br>
		</div>
		<?php 
				/*$checkadmin=false;
				if($_SESSION['Admin']=="admin@gmail.com"$isAdmin){
					$checkadmin=true;
				}*/
				?>
		<div id="myModal" class="modal"><div class="modal-content"><span class="close" id="close">&times;</span>
	      <form  method="post">
			  <div class="imgcontainer" align="center">
				<h2>Update Form</h2>
			  </div>
			  <div class="container">
			      <table align="center" border="0"><tr>
			     <td>
				<label for="ComapanyName" style="font-size:24px;"><b>Company Name </b></label>
				<input type="text" id="CompanyName" name="CompanyName"  style="font-size:16px;" <?php echo $isAdmin ? '' : 'disabled'; ?>></td>
				<td>
				 <label for="Time"  style="font-size:24px;"><b>Departure Time </b></label>
				<input type="text"name="Time" id="Time"  style="font-size:16px;" <?php echo $isAdmin ? '' : 'disabled'; ?>></td>	</tr>				
				  <tr>
				  <td>
				<label for="from" style="font-size:24px;"><b>From</b></label>
				<input type="text" id="from" name="from"  style="font-size:16px;" <?php echo $isAdmin ? '' : 'disabled'; ?>></td>
                <td>
				<label for="Destination" style="font-size:24px;"><b>Destination</b></label>
				<input type="text" id="Destination" name="Destination"  style="font-size:16px;" <?php echo $isAdmin ? '' : 'disabled'; ?>></td></tr>
				  <tr>
				<td>  
				<label for="Seat" style="font-size:24px;"><b>Seat Num </b></label>
				<input type="text" id="Seat" name="Seat"  style="font-size:16px;" <?php echo $isAdmin ? '' : 'disabled'; ?>></td>
                <td>
				<label for="Price"  style="font-size:24px;"><b>Price (Rs)</b></label>
				<input type="text" id="Price" name="Price"  style="font-size:16px;" <?php echo $isAdmin ? '' : 'disabled'; ?>></td></tr>
				<tr>
				<td>  
				<label for="Email"  style="font-size:24px;"><b>Email</b></label>
				<input type="email" id="Email" name="Email"  style="font-size:16px;" <?php echo $isAdmin ? '' : 'disabled'; ?>></td></tr>
				<tr><td>
				<label for="Name"  style="font-size:24px;;"><b>Name </b></label>
				<input type="text" id="Name" name="Name"  style="font-size:16px;" required></td>
				<td>
    			<label for="Phone" style="font-size:24px;"><b>Phone</b></label>
    			<input type="text" id="Phone" name="Phone" style="font-size:16px;" 
           		required pattern="^(070|071|072|074|075|076|077|078)\d{7}$" 
           		title="Please enter a valid phone number ">
				</td>
				</tr>
				<tr ><td colspan="3">
                <input type="hidden" id="ID" name="ID"  style="font-size:24px;" required>
				<button name="update" type="submit" class="update"  style="font-size:16px;">Update</button></td></tr>
                </table>
			  </div>
			</form> </div>
           </div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>   
	</body>
</html>




<script>
	function logout(){
		window.location.assign('logout.php');
	}
$(document).ready(function() {
    
    var table = $('#example').DataTable( {
        select: true
    } );
    table
        .on( 'select', function ( e, dt, type, indexes ) {
            var rowData = table.rows( indexes ).data().toArray();         
        } )
        .on( 'deselect', function ( e, dt, type, indexes ) {
            var rowData = table.rows( indexes ).data().toArray();         
        } );
	var table2 = $('#example2').DataTable( {
        select: true
    } );
    table2
        .on( 'select', function ( e, dt, type, indexes ) {
            var rowData = table.rows( indexes ).data().toArray();        
        } )
        .on( 'deselect', function ( e, dt, type, indexes ) {
            var rowData = table.rows( indexes ).data().toArray();
         
        } );
} );
	function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}
function modal(id){
		var modal = document.getElementById("myModal");
        var number = '<?php echo $num ?>'; 
	    var time =[],seat=[],price=[],name=[],phone=[],email=[],Destination=[],from=[],IDphp=[],CompanyName=[];
	    <?php
	        for($i=0;$i<$num;$i++){
	    ?>	    
			time[<?php echo $i ?>]='<?php echo $TimeH[$i] ?>';
	        seat[<?php echo $i ?>]='<?php echo $SeatH[$i] ?>';
	        price[<?php echo $i ?>]='<?php echo $priceH[$i] ?>';
	        name[<?php echo $i ?>]='<?php echo $NameH[$i] ?>';
	        phone[<?php echo $i ?>]='<?php echo $PhoneH[$i] ?>';
	        email[<?php echo $i ?>]='<?php echo $EmailH[$i] ?>';
	        CompanyName[<?php echo $i ?>]='<?php echo $companyH[$i] ?>';
			from[<?php echo $i ?>]='<?php echo $fromH[$i] ?>';
	        Destination[<?php echo $i ?>]='<?php echo $DestinationH[$i] ?>';
	        IDphp[<?php echo $i ?>]='<?php echo $idH[$i] ?>';
	    <?php
		}
	    ?>
	    var TimeHTML = document.getElementById("Time").value=time[id];
		var fromHTML = document.getElementById("from").value=from[id];
	    var DestinationHTML = document.getElementById("Destination").value=Destination[id];
		var SeatHTML = document.getElementById("Seat").value=seat[id];
		var PriceHTML = document.getElementById("Price").value=price[id];
		var NameHTML = document.getElementById("Name").value=name[id];
	    var PhoneHTML = document.getElementById("Phone").value=phone[id];
	    var EmailHTML = document.getElementById("Email").value=email[id];
	    var CompanyNameHTML = document.getElementById("CompanyName").value=CompanyName[id];
	    var IDHTML = document.getElementById("ID").value=IDphp[id];
		var span = document.getElementById("close");

		  modal.style.display = "block";

		span.onclick = function() {
		  modal.style.display = "none";
		}
		window.onclick = function(event) {
		  if (event.target == modal) {
			modal.style.display = "none";
		  }
}
}
</script>

