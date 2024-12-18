<?php
  session_start();
  error_reporting(0);
  include("dbconnect.php");
  
 if(!isset($_SESSION['Admin'])){
         echo '<script type="text/javascript">alert("Please login first!!");window.location.assign("login.php");</script>';
     }
  
  // Store the cipher method
	$ciphering = "AES-128-CTR";

	// Use OpenSSl Encryption method
	$iv_length = openssl_cipher_iv_length($ciphering);
	$options = 0;

	// Non-NULL Initialization Vector for encryption
	$encryption_iv = '1234567891011121';
    
    // Store the encryption key
	$encryption_key = "travel123";
    $emailuser= $_SESSION['Admin'];
    
    if(isset($_POST['filter'])){
			$fromFilter = $_POST['from'];
          $queryTable = "SELECT * FROM `schedule` INNER JOIN `company` ON schedule.companyID = company.companyID where 
		  schedule.scheduleFrom='$fromFilter' ORDER BY scheduleDate, scheduleTime;";
    }else{
          $queryTable = "SELECT * FROM `schedule` INNER JOIN `company` ON schedule.companyID = company.companyID ORDER BY scheduleDate, scheduleTime;";
    }

    if(isset($_POST['add'])){
         $company = $_POST['company'];
         $time = $_POST['time'];
         $duration = $_POST['duration'];
         $busdate = $_POST['busdate'];
		 $fromAdd = $_POST['from'];
         $destinationAdd = $_POST['destination'];
         $price = $_POST['price'];
		 $todaydate=date("Y-m-d");
			
        if($busdate>=$todaydate){
			$query="INSERT INTO schedule(companyID, scheduleTime, scheduleDuration, scheduleDate, scheduleDestination, schedulePrice,scheduleFrom)
			VALUES ('$company','$time','$duration','$busdate','$destinationAdd','$price','$fromAdd')";
          	if(mysqli_query($conn, $query) )
			{
				echo "<script type='text/javascript'>alert('Success');window.location.assign('admin_schedule.php');</script>";
			}	
			else{
			echo "<script type='text/javascript'>alert('Fail');window.location.assign('admin_schedule.php');</script>";
			}
		}
		else{
			echo '<script type="text/javascript">alert("Date cannot smaller than today!!");</script>';
		}
         
        
    }
    
     if(isset($_POST['update'])){
		$fromUpdate = $_POST['scheduleFromPHP'];
         $destinationUpdate = $_POST['scheduleDestinationPHP'];
         $scheduleTimeUpdate = $_POST['scheduleTimePHP'];
         $scheduleDateUpdate = $_POST['scheduleDatePHP'];
		 $scheduleFromUpdate = $_POST['scheduleFromPHP'];
         $scheduleDurationUpdate = $_POST['scheduleDurationPHP'];
         $companyUpdate = $_POST['company'];
         $schedulePriceUpdate = $_POST['schedulePricePHP'];
         $scheduleIDUpdate = $_POST['scheduleID'];
          
         $query="UPDATE schedule SET companyID='$companyUpdate',scheduleTime='$scheduleTimeUpdate',scheduleDuration='$scheduleDurationUpdate',
		 scheduleFrom='$scheduleFromUpdate',scheduleDate='$scheduleDateUpdate',scheduleDestination='$destinationUpdate',
		 schedulePrice='$schedulePriceUpdate' where scheduleID ='$scheduleIDUpdate'";
         
		if (!mysqli_query($conn, $query)) {
			error_log("MySQL Update Error: " . mysqli_error($conn), 3, "errors.log");
			echo "<script>alert('Update failed. Check logs for details.');</script>";
		}
		else{
			echo "<script type='text/javascript'>alert(' update Success');window.location.assign('admin_schedule.php');</script>'";
		}
		

	   
     }
?>
<html>
<head>
<meta charset="utf-8">
<title>Bus Schedule List</title>
<link rel="stylesheet" href="style/admin_schedulestyle.css">
</head>
	<body style="font-family:Arvo;margin:0;" class="fitimg">    
		<?php include 'navigation.php'; ?>
	
		<h2 style="text-align:center; color:white"><b>Bus Schedule List</b></h2>
		<br><br><br>
		<section class="timetable" >	
		<div align="center">			
		<section>
				<?php
	                if($_SESSION['Admin']=="admin@gmail.com"){
			            echo "<button class='add' onclick='addModal()' style='float:right'>+&nbsp;&nbsp;&nbsp;&nbsp;Add</button>"; 
			        }
		        ?>
		    <table style="test-align:center; background-color: white;" id="company" border="1" width="100%">
		        <thead>
			<tr>
			<th align="center" width="50px" height="50px" style="padding-bottom: 10px;">#</th>
			<th align="center" width="100px" height="50px" style="padding-bottom: 10px;">Company</th>
			<th align="center" width="60px" height="50px" style="padding-bottom: 10px;">Time</th>
			<th align="center" width="100px" height="50px" style="padding-bottom: 10px;">Duration</th>
			<th align="center" width="80px" height="50px" style="padding-bottom: 10px;">Date</th>
			<th align="center" width="150px" height="50px" style="padding-bottom: 10px;">From</th>
			<th align="center" width="150px" height="50px" style="padding-bottom: 10px;">Destination (hours)</th>
			<th align="center" width="100px" height="50px" style="padding-bottom: 10px;">Available Seats</th>
			<th align="center" width="100px" height="50px" style="padding-bottom: 10px;">Price (Rs)</th>
			<?php
	                if($_SESSION['Admin']=="admin@gmail.com"){
			            echo "<th align='center' width='100px' height='50px' style='padding-bottom: 10px;'>Action</th>"; 
			        }
		        ?>
			
			</tr>
			  </thead>
		<?php
		  
			$result = $conn->query($queryTable);
			$number=0;
			if ($result->num_rows >0) {
			    $scheduleTimePHP = array();
			    $scheduleDurationPHP = array();
				$scheduleFromPHP = array();
			    $scheduleDatePHP = array();
			    $scheduleDestinationPHP = array();
			    $schedulePricePHP = array();
			    $companyIDPHP = array();
			    $ScheduleIDPHP = array();
			    $day = array();
			    
				 while ($row = $result ->fetch_assoc()){ 
					  extract($row);
					    $number=$number+1;
					    $scheduleTimePHP[$number] = $scheduleTime;
						$scheduleFromPHP[$number] = $scheduleFrom;
					    $scheduleDurationPHP[$number] = $scheduleDuration;
					    $scheduleDatePHP[$number]= $scheduleDate;
					    $scheduleDestinationPHP[$number] = $scheduleDestination;
					    $schedulePricePHP[$number] = $schedulePrice;
					    $dayPHP[$number] = $day;
					    $companyIDPHP[$number] = $companyID;
					    $ScheduleIDPHP[$number] = $scheduleID;
					    
					    //calculate seat
					    $querySeat = "SELECT * FROM `ticket` where `scheduleID` = '$scheduleID'";
            			$resultSeat = $conn->query($querySeat);
            			$numberseat=0;
            			if ($resultSeat->num_rows >0) {
            				 while ($rowSeat = $resultSeat ->fetch_assoc()){ 
            					  extract($rowSeat);
            					  $numberseat=$numberseat+1;
            				 }
            			}
            			$totalseat= 24-$numberseat;
            			 $encryption = openssl_encrypt($scheduleID, $ciphering,	$encryption_key,$options, $encryption_iv);
						$encrptID = base64_encode($encryption);
            						echo"
						<tr height='100px'>
						     <td  style='text-align:center'>$number</td>
                			<td style='text-align:center'>$companyName</td>
        					<td style='text-align:center'>$scheduleTime</td>
        					<td style='text-align:center'>$scheduleDuration</td>
        					<td style='text-align:center'>$scheduleDate</td>
							<td style='text-align:center'>$scheduleFrom</td>
        					<td style='text-align:center'>$scheduleDestination</td>
        					<td style='text-align:center'>$totalseat</td>
        					<td style='text-align:center'>$schedulePrice</td>";

							
								if($_SESSION['Admin']=="admin@gmail.com"){
									echo "<td style='text-align:center'><button class='upbtn'onclick='modal($number)'><b>Update</b></button>
									<br><br>
									<a class='delbtn' href='admin_deleteschedule.php?id=$encrptID'><b>Delete</b></a><br><br></td>";
								}
							

							
							echo"</tr>";
							
					        
							
				   }
				   
			}
		
		?>
		</table>
	</section>
		</br></br></br></br></br>
	</div>
	</section>
	<!--Update-->
	<div id="myModal" class="modal">
	    <div class="modal-content"><span class="close" id="close">&times;</span>
	      <form  method="post">
			  <div class="imgcontainer" align="center">
				<h1>Update Form</h1>
			  </div>

			  <div class="container" style="margin-left:5%; margin-right:5%;">
			     
			      <table align="center" border="0" width="100%" >
				  <tr height="70px">
			          <td colspan="3" class="addingform"><b>From: </b></td>
			          <td colspan="3"> <select class="des" id="scheduleFromPHP" name="scheduleFromPHP" style="font-size:16px;width:100%" required>
					  <option value="">From</option>
					  <option value="Jaffna" <?php if($from=='Jaffna'){echo "selected='selected'";} ?>>Jaffna</option>
					  <option value="">From</option>
							<option value="Jaffna">Jaffna</option>
							<option value="Kilinochchi">Kilinochchi</option>
							<option value="Mannar" >Mannar</option>
							<option value="Mullaitivu" >Mullaitivu</option>
							<option value="Vavuniya" >Vavuniya</option>
							<option value="Puttalam" >Puttalam</option>
							<option value="Kurunegala" >Kurunegala</option>
							<option value="Gampaha" >Gampaha</option>
							<option value="Colombo" >Colombo</option>
							<option value="Kalutara" >Kalutara</option>
							<option value="Anuradhapura"  >Anuradhapura</option>
							<option value="Polonnaruwa" >Polonnaruwa</option>
							<option value="Matale" >Matale</option>
							<option value="Kandy">Kandy</option>
							<option value="Nuwara_Eliya"  >Nuwara_Eliya</option>
							<option value="Kegalle" >Kegalle</option>
							<option value="Ratnapura" >Ratnapura</option>
							<option value="Trincomalee">Trincomalee</option>
							<option value="Batticaloa">Batticaloa</option>
							<option value="Ampara">Ampara</option>
							<option value="Badulla">Badulla</option>
							<option value="Monaragala" >Monaragala</option>
							<option value="Hambantota">Hambantota</option>
							<option value="Matara">Matara</option>
							<option value="Galle">Galle</option>
						</select>
						</td>
			      </tr>
			      <tr height="70px">
			          <td colspan="3" class="addingform"><b>Destination: </b></td>
			          <td colspan="3"> <select class="des" id="scheduleDestinationPHP" name="scheduleDestinationPHP" style="font-size:16px;width:100%" required>
							<option value="">Destination</option>
							<option value="Jaffna">Jaffna</option>
							<option value="Kilinochchi">Kilinochchi</option>
							<option value="Mannar" >Mannar</option>
							<option value="Mullaitivu" >Mullaitivu</option>
							<option value="Vavuniya" >Vavuniya</option>
							<option value="Puttalam" >Puttalam</option>
							<option value="Kurunegala" >Kurunegala</option>
							<option value="Gampaha" >Gampaha</option>
							<option value="Colombo" >Colombo</option>
							<option value="Kalutara" >Kalutara</option>
							<option value="Anuradhapura"  >Anuradhapura</option>
							<option value="Polonnaruwa" >Polonnaruwa</option>
							<option value="Matale" >Matale</option>
							<option value="Kandy">Kandy</option>
							<option value="Nuwara_Eliya"  >Nuwara_Eliya</option>
							<option value="Kegalle" >Kegalle</option>
							<option value="Ratnapura" >Ratnapura</option>
							<option value="Trincomalee">Trincomalee</option>
							<option value="Batticaloa">Batticaloa</option>
							<option value="Ampara">Ampara</option>
							<option value="Badulla">Badulla</option>
							<option value="Monaragala" >Monaragala</option>
							<option value="Hambantota">Hambantota</option>
							<option value="Matara">Matara</option>
							<option value="Galle">Galle</option>
						</select>

						</td>
			      </tr>
			      <tr height="70px">
			          <td colspan="3" class="addingform"><b>Time: </b></td>
			          <td colspan="3"><input type="time" class="form-control "  placeholder="Select Time" id="scheduleTimePHP" name="scheduleTimePHP" step="1" /></td>
			      </tr>
			        <tr height="70px">
			          <td colspan="3" class="addingform"><b>Date: </b></td>
			          <td colspan="3"><input type="date" id="scheduleDatePHP" name="scheduleDatePHP" style="font-size:16px;width:100%" required/></td>
			      </tr>
			       <tr height="70px">
			          <td colspan="3" class="addingform"><b>Duration: </b></td>
			          <td colspan="3"><input type="text"  name="scheduleDurationPHP"  id="scheduleDurationPHP" style="font-size:16px;width:100%" required/></td>
			      </tr>
			      <tr height="70px">
			          <td colspan="3" class="addingform"><b>Price (Rs): </b></td>
			          <td colspan="3"><input type="number"  name="schedulePricePHP"  id="schedulePricePHP" style="font-size:16px;width:100%" required/></td>
			      </tr>
			      <tr height="70px">
			          <td colspan="3" class="addingform"><b>Company : </b></td>
			          <td colspan="3"><select id="company" name="company" style="font-size:16px;width:100%" required>
	
			             <?php
			               $query = "SELECT * FROM `company`";
                			$result = $conn->query($query);
                			if ($result->num_rows >0) {
                			     while ($row = $result ->fetch_assoc()){ 
					               extract($row);
			                     echo "<option value='$companyID'>$companyName</option>";
                			     }
                			}
                			
                			?>

                       </select>
                       <input type='hidden' id='scheduleID' name='scheduleID'  />
			          </td>
			      </tr>
			     
			      <tr height="70px"><td colspan="5">
				<button name="update" type="submit" class="update"  style="font-size:16px;">Update</button></td>
			</tr>
                </table>
			  </div>

			</form> </div>
    </div>
           
           <!--AddSchedule-->
           <div id="myModal2" class="modal">
	    <div class="modal-content"><span class="close" id="close2">&times;</span>
	      <form  method="post">
			  <div class="imgcontainer" align="center">
				<h1>Adding Schedule Form</h1>
			  </div>

			  <div class="container" style="margin-left:5%; margin-right:5%;">
			      <table align="center" border="0" width="100%" >
			      <tr height="70px">
			          <td colspan="3" class="addingform"><b>Company : </b></td>
			          <td colspan="3"><select id="company" name="company" style="font-size:16px;width:100%" required/>
	                   <option value=''>Select</option>
			             <?php
			               $query = "SELECT * FROM `company`";
                			$result = $conn->query($query);
                			if ($result->num_rows >0) {
                			     while ($row = $result ->fetch_assoc()){ 
					               extract($row);
			                     echo "<option value='$companyID'>$companyName</option>";
                			     }
                			}
                			
                			?>

                       </select>
			      </tr>
			      <tr height="70px">
			          <td colspan="3" class="addingform"><b>Time: </b></td>
			          <td colspan="3"><input type="time" class="form-control " name='time' placeholder="Select Time" id="Text1" /></td>
			      </tr>
			       <tr height="70px">
			          <td colspan="3" class="addingform"><b>Duration: </b></td>
			          <td colspan="3"><input type="text" id="duration" name="duration"  style="font-size:16px;width:100%" required/></td>
			      </tr>
			      <tr height="70px">
			          <td colspan="3" class="addingform"><b>Date: </b></td>
			          <td colspan="3"><input type="date" id="busdate" name="busdate" style="font-size:16px;width:100%" required/></td>
			      </tr>

				  <tr height="70px">
			          <td colspan="3" class="addingform"><b>From: </b></td>
			          <td colspan="3"> <select class="des" id="from" name="from" style="font-size:16px;width:100%" required>
					  		<option value="">From</option>
							<option value="Jaffna">Jaffna</option>
							<option value="Kilinochchi">Kilinochchi</option>
							<option value="Mannar" >Mannar</option>
							<option value="Mullaitivu" >Mullaitivu</option>
							<option value="Vavuniya" >Vavuniya</option>
							<option value="Puttalam" >Puttalam</option>
							<option value="Kurunegala" >Kurunegala</option>
							<option value="Gampaha" >Gampaha</option>
							<option value="Colombo" >Colombo</option>
							<option value="Kalutara" >Kalutara</option>
							<option value="Anuradhapura"  >Anuradhapura</option>
							<option value="Polonnaruwa" >Polonnaruwa</option>
							<option value="Matale" >Matale</option>
							<option value="Kandy">Kandy</option>
							<option value="Nuwara_Eliya"  >Nuwara_Eliya</option>
							<option value="Kegalle" >Kegalle</option>
							<option value="Ratnapura" >Ratnapura</option>
							<option value="Trincomalee">Trincomalee</option>
							<option value="Batticaloa">Batticaloa</option>
							<option value="Ampara">Ampara</option>
							<option value="Badulla">Badulla</option>
							<option value="Monaragala" >Monaragala</option>
							<option value="Hambantota">Hambantota</option>
							<option value="Matara">Matara</option>
							<option value="Galle">Galle</option>
						</select>
						</td>
			      </tr>
				  
			      <tr height="70px">
			          <td colspan="3" class="addingform"><b>Destination: </b></td>
			          <td colspan="3"> <select class="des" id="destination" name="destination" style="font-size:16px;width:100%" required>
					  		<option value="">Destination</option>
							<option value="Jaffna">Jaffna</option>
							<option value="Kilinochchi">Kilinochchi</option>
							<option value="Mannar" >Mannar</option>
							<option value="Mullaitivu" >Mullaitivu</option>
							<option value="Vavuniya" >Vavuniya</option>
							<option value="Puttalam" >Puttalam</option>
							<option value="Kurunegala" >Kurunegala</option>
							<option value="Gampaha" >Gampaha</option>
							<option value="Colombo" >Colombo</option>
							<option value="Kalutara" >Kalutara</option>
							<option value="Anuradhapura"  >Anuradhapura</option>
							<option value="Polonnaruwa" >Polonnaruwa</option>
							<option value="Matale" >Matale</option>
							<option value="Kandy">Kandy</option>
							<option value="Nuwara_Eliya"  >Nuwara_Eliya</option>
							<option value="Kegalle" >Kegalle</option>
							<option value="Ratnapura" >Ratnapura</option>
							<option value="Trincomalee">Trincomalee</option>
							<option value="Batticaloa">Batticaloa</option>
							<option value="Ampara">Ampara</option>
							<option value="Badulla">Badulla</option>
							<option value="Monaragala" >Monaragala</option>
							<option value="Hambantota">Hambantota</option>
							<option value="Matara">Matara</option>
							<option value="Galle">Galle</option>
						</select>
						</td>
			      </tr>

			      <tr height="70px">
			      
			          <!--td width="20px"></td-->
			          <td class="addingform" colspan="3"><b>Price (Rs): </b></td>
			          <td><input type="number" min="0" max="10000" step="1" name="price" id="price"
			          style="font-size:16px;width:100%"required></td>
			      </tr>
			      
			      <tr height="70px"><td colspan="5">
				<button name="add" type="submit" class="update"  style="font-size:16px;">Register</button></td></tr>
                </table>
			  </div>

			</form> </div>
           </div>
    
</body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>
<script>
$(document).ready(function() {
    var table = $('#company').DataTable({
        select: true
    });

    table
        .on('select', function(e, dt, type, indexes) {
            var rowData = table.rows( indexes ).data().toArray();
        })
        .on('deselect', function(e, dt, type, indexes) {
            var rowData = table.rows( indexes ).data().toArray();
        });
});

function login() {
    window.location.assign('login.php');
}

function logout() {
    window.location.assign('logout.php');
}

function addModal() {
    var modal = document.getElementById("myModal2");
    var span = document.getElementById("close2");

    // Open the modal
    modal.style.display = "block";

    // Close the modal when the close button is clicked
    span.onclick = function() {
        modal.style.display = "none";
    };

    // Close the modal when clicking outside of it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };
}

function modal(id) {
    var modal = document.getElementById("myModal");

    // Declare arrays outside the loop
    var scheduleTimePHP = [], scheduleDurationPHP = [], scheduleDatePHP = [], 
        scheduleFromPHP = [], scheduleDestinationPHP = [], 
        schedulePricePHP = [], companyIDPHP = [], ScheduleIDPHP = [];

    <?php for ($i = 1; $i <= $number; $i++) { ?>
        scheduleTimePHP[<?php echo $i; ?>] = '<?php echo $scheduleTimePHP[$i]; ?>';
        scheduleDurationPHP[<?php echo $i; ?>] = '<?php echo $scheduleDurationPHP[$i]; ?>';
        scheduleDatePHP[<?php echo $i; ?>] = '<?php echo $scheduleDatePHP[$i]; ?>';
        scheduleFromPHP[<?php echo $i; ?>] = '<?php echo $scheduleFromPHP[$i]; ?>';
        scheduleDestinationPHP[<?php echo $i; ?>] = '<?php echo $scheduleDestinationPHP[$i]; ?>';
        schedulePricePHP[<?php echo $i; ?>] = '<?php echo $schedulePricePHP[$i]; ?>';
        companyIDPHP[<?php echo $i; ?>] = '<?php echo $companyIDPHP[$i]; ?>';
        ScheduleIDPHP[<?php echo $i; ?>] = '<?php echo $ScheduleIDPHP[$i]; ?>';
    <?php } ?>

    // Fill modal fields based on the id passed to the function
    document.getElementById("scheduleFromPHP").value = scheduleFromPHP[id];
    document.getElementById("scheduleDestinationPHP").value = scheduleDestinationPHP[id];
    document.getElementById("scheduleTimePHP").value = scheduleTimePHP[id];
    document.getElementById("scheduleDatePHP").value = scheduleDatePHP[id];
    document.getElementById("scheduleDurationPHP").value = scheduleDurationPHP[id];
    document.getElementById("company").value = companyIDPHP[id];
    document.getElementById("scheduleID").value = ScheduleIDPHP[id];
    document.getElementById("schedulePricePHP").value = schedulePricePHP[id];

    // Open the modal
    modal.style.display = "block";

    var span = document.getElementById("close");

    // Close the modal when the close button is clicked
    span.onclick = function() {
        modal.style.display = "none";
    };

    // Close the modal when clicking outside of it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };
}

</script>