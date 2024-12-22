<?php
  session_start();
  error_reporting(0);
  include("dbconnect.php");
  $todaydate=date("Y-m-d");
    
  if(!isset($_SESSION['Admin'])){
         echo '<script type="text/javascript">alert("Please login first!!");window.location.assign("login.php");</script>';
     }
     
    
     
  if(isset($_POST['filter'])){
	  $date = $_POST['bookingdate'];
	  $from = $_POST['from'];
	  $destination = $_POST['destination'];
	  $todaydate=date("Y-m-d");
	  if($date>=$todaydate){
	      
		$query = "SELECT * FROM `schedule`
INNER JOIN company ON schedule.companyID = company.companyID
WHERE `scheduleDestination` = '$destination'
AND `scheduleFrom` = '$from'
AND (
    -- For today, show schedules that are more than 2 hours ahead of the current time
    (
        `scheduleDate` = CURDATE()
        AND `scheduleTime` > NOW() + INTERVAL 2 HOUR
    )
    -- For any future date, show all schedules on the input date
    OR (
        `scheduleDate` = '$date'
        AND `scheduleDate` > CURDATE()
    )
)
ORDER BY scheduleDate, scheduleTime;




";



             $result = $conn->query($query);
             $tempSchedule=0;
            	if ($result->num_rows > 0)
            	{
            	    $schduleID= array();
            		while ($row = $result->fetch_assoc())
            		{
            		    $schduleID[$tempSchedule]= $row["scheduleID"];
            			$tempSchedule=$tempSchedule+1;
            			
                   }
             }
	      
	      
	        
             $queryticket = "SELECT schedule.scheduleID, ticket.Seat FROM `schedule` INNER JOIN `ticket` ON schedule.scheduleID = ticket.scheduleID WHERE
			 `scheduleDestination`='$destination' && `scheduleDate`='$date' && scheduleFrom='$from'";
             $result = $conn->query($queryticket);
             $tempTicket=0;
            	if ($result->num_rows > 0)
            	{
            	    $phpScheduleID = array();
            		$ticket = array();
            		$seatleft = array();
            		while ($row = $result->fetch_assoc())
            		{
            	        
            		    $phpScheduleID[$tempTicket]= $row["scheduleID"];
            			$ticket[$tempTicket] =$row["Seat"];
            			
            			for($i=0;$i<$tempSchedule;$i++){
            				if($phpScheduleID[$tempTicket] == $schduleID[$i]){
            					 $seatleft[$i]=$seatleft[$i]+1;
            				
            				}
            			}
            			$tempTicket=$tempTicket+1;
            			
                   }
             }	 
 	 
	  }else{
	       $date='';
	       $destination='';
		   $from='';
	       echo '<script type="text/javascript">alert("Date cannot smaller than today!!");</script>';
	  }
	  
	  
  }else{
      $query='';
  }

  $autodelete = "DELETE FROM schedule WHERE (scheduleDate < '$todaydate') OR (scheduleDate = '$todaydate' AND scheduleTime < NOW())";

  $autodeleteresult = $conn->query($autodelete);
  
  if ($autodeleteresult) {
	 // echo "Records deleted successfully.";
  } //else {
	//  echo "Error deleting records: " . $conn->error;
  //}
  
  
 



?>

<html lang="en">
  <head>
  	<title>schedule</title>
	<link rel="stylesheet" href="style/schedulestyle.css">
	<style>
	.fitimg {
				
				background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url("assets/home1.png") center fixed no-repeat;
				background-size:cover;
				}
</style>
	


	</head>
	<body style="font-family:Arvo; margin:0;" class="fitimg">
	<?php include 'navigation.php'; ?>
	
	<section class="timetable">
		<div>
			<br>
			<h2 class="heading-section" style="color:white;">Where do you want to go ?</h2>
			
				<div class="row" align="center">
					   <form method="post">
						<input class="bookingdate" type="date" name="bookingdate" id="bookingdate" value="<?php echo $date ?>" required>
						<select class="des" id="from" name="from" required>
						<option value="">From</option>
							<option value="Jaffna" <?php if($from=='Jaffna'){echo "selected='selected'";} ?>>Jaffna</option>
							<option value="Kilinochchi" <?php if($from=='Kilinochchi'){echo "selected='selected'";} ?>>Kilinochchi</option>
							<option value="Mannar" <?php if($from=='Mannar'){echo "selected='selected'";} ?>>Mannar</option>
							<option value="Mullaitivu" <?php if($from=='Mullaitivu'){echo "selected='selected'";} ?>>Mullaitivu</option>
							<option value="Vavuniya" <?php if($from=='Vavuniya'){echo "selected='selected'";} ?>>Vavuniya</option>
							<option value="Puttalam" <?php if($from=='Puttalam'){echo "selected='selected'";} ?>>Puttalam</option>
							<option value="Kurunegala" <?php if($from=='Kurunegala'){echo "selected='selected'";} ?>>Kurunegala</option>
							<option value="Gampaha" <?php if($from=='Gampaha'){echo "selected='selected'";} ?>>Gampaha</option>
							<option value="Colombo" <?php if($from=='Colombo'){echo "selected='selected'";} ?>>Colombo</option>
							<option value="Kalutara" <?php if($from=='Kalutara'){echo "selected='selected'";} ?>>Kalutara</option>
							<option value="Anuradhapura" <?php if($from=='Anuradhapura'){echo "selected='selected'";} ?>>Anuradhapura</option>
							<option value="Polonnaruwa" <?php if($from=='Polonnaruwa'){echo "selected='selected'";} ?>>Polonnaruwa</option>
							<option value="Matale" <?php if($from=='Matale'){echo "selected='selected'";} ?>>Matale</option>
							<option value="Kandy" <?php if($from=='Kandy'){echo "selected='selected'";} ?>>Kandy</option>
							<option value="Nuwara_Eliya" <?php if($from=='Nuwara_Eliya'){echo "selected='selected'";} ?>>Nuwara_Eliya</option>
							<option value="Kegalle" <?php if($from=='Kegalle'){echo "selected='selected'";} ?>>Kegalle</option>
							<option value="Ratnapura" <?php if($from=='Ratnapura'){echo "selected='selected'";} ?>>Ratnapura</option>
							<option value="Trincomalee" <?php if($from=='Trincomalee'){echo "selected='selected'";} ?>>Trincomalee</option>
							<option value="Batticaloa" <?php if($from=='Batticaloa'){echo "selected='selected'";} ?>>Batticaloa</option>
							<option value="Ampara" <?php if($from=='Ampara'){echo "selected='selected'";} ?>>Ampara</option>
							<option value="Badulla" <?php if($from=='Badulla'){echo "selected='selected'";} ?>>Badulla</option>
							<option value="Monaragala" <?php if($from=='Monaragala'){echo "selected='selected'";} ?>>Monaragala</option>
							<option value="Hambantota" <?php if($from=='Hambantota'){echo "selected='selected'";} ?>>Hambantota</option>
							<option value="Matara" <?php if($from=='Matara'){echo "selected='selected'";} ?>>Matara</option>
							<option value="Galle" <?php if($from=='Galle'){echo "selected='selected'";} ?>>Galle</option>
						</select>

						<select class="des" id="destination" name="destination" required>
							<option value="">Destination</option>
							<option value="Jaffna" <?php if($destination=='Jaffna'){echo "selected='selected'";} ?>>Jaffna</option>
							<option value="Kilinochchi" <?php if($destination=='Kilinochchi'){echo "selected='selected'";} ?>>Kilinochchi</option>
							<option value="Mannar" <?php if($destination=='Mannar'){echo "selected='selected'";} ?>>Mannar</option>
							<option value="Mullaitivu" <?php if($destination=='Mullaitivu'){echo "selected='selected'";} ?>>Mullaitivu</option>
							<option value="Vavuniya" <?php if($destination=='Vavuniya'){echo "selected='selected'";} ?>>Vavuniya</option>
							<option value="Puttalam" <?php if($destination=='Puttalam'){echo "selected='selected'";} ?>>Puttalam</option>
							<option value="Kurunegala" <?php if($destination=='Kurunegala'){echo "selected='selected'";} ?>>Kurunegala</option>
							<option value="Gampaha" <?php if($destination=='Gampaha'){echo "selected='selected'";} ?>>Gampaha</option>
							<option value="Colombo" <?php if($destination=='Colombo'){echo "selected='selected'";} ?>>Colombo</option>
							<option value="Kalutara" <?php if($destination=='Kalutara'){echo "selected='selected'";} ?>>Kalutara</option>
							<option value="Anuradhapura" <?php if($destination=='Anuradhapura'){echo "selected='selected'";} ?>>Anuradhapura</option>
							<option value="Polonnaruwa" <?php if($destination=='Polonnaruwa'){echo "selected='selected'";} ?>>Polonnaruwa</option>
							<option value="Matale" <?php if($destination=='Matale'){echo "selected='selected'";} ?>>Matale</option>
							<option value="Kandy" <?php if($destination=='Kandy'){echo "selected='selected'";} ?>>Kandy</option>
							<option value="Nuwara_Eliya" <?php if($destination=='Nuwara_Eliya'){echo "selected='selected'";} ?>>Nuwara_Eliya</option>
							<option value="Kegalle" <?php if($destination=='Kegalle'){echo "selected='selected'";} ?>>Kegalle</option>
							<option value="Ratnapura" <?php if($destination=='Ratnapura'){echo "selected='selected'";} ?>>Ratnapura</option>
							<option value="Trincomalee" <?php if($destination=='Trincomalee'){echo "selected='selected'";} ?>>Trincomalee</option>
							<option value="Batticaloa" <?php if($destination=='Batticaloa'){echo "selected='selected'";} ?>>Batticaloa</option>
							<option value="Ampara" <?php if($destination=='Ampara'){echo "selected='selected'";} ?>>Ampara</option>
							<option value="Badulla" <?php if($destination=='Badulla'){echo "selected='selected'";} ?>>Badulla</option>
							<option value="Monaragala" <?php if($destination=='Monaragala'){echo "selected='selected'";} ?>>Monaragala</option>
							<option value="Hambantota" <?php if($destination=='Hambantota'){echo "selected='selected'";} ?>>Hambantota</option>
							<option value="Matara" <?php if($destination=='Matara'){echo "selected='selected'";} ?>>Matara</option>
							<option value="Galle" <?php if($destination=='Galle'){echo "selected='selected'";} ?>>Galle</option>

						</select>
						  
						<button class="searchbtn" type="submit" name="filter">Search</button>
						 <button class="ResetBtn">Reset</button>
						
					  </form>
					</div>	
			<p style='color:red; text-align:center;' id='tableerrormessage'></p><br>
			<div class="row2">
			<div align="center">
			    
				<?php
				  if($query!=''){
				      echo"
				  
						<table class='table table-responsive-xl' id='example' align='center' border='1'>
						  <thead>
						    <tr>
						    	<th align='center' width='20px' style='padding-bottom: 10px;'>#</th>
								
						    	<th align='center' width='150px' style='padding-bottom: 10px;'>Company</th>
								<th align='center' width='60px' style='padding-bottom: 10px;'>Time</th>
						        <th align='center' width='350px' style='padding-bottom: 10px;'>Duration</th>
						        <th align='center' width='150px' style='padding-bottom: 10px;'>Date</th>
								 <th align='center' width='150px' style='padding-bottom: 10px;'>From</th>
						        <th align='center' width='150px' style='padding-bottom: 10px;'>Destination</th>
								<th align='center' width='100px' style='padding-bottom: 10px;'>Available Seats</th>
								<th align='center' width='100px' style='padding-bottom: 10px;'>Price (Rs)</th>
								<th align='center' width='100px' style='padding-bottom: 10px;'></th>
								<th style='display:none'>scheduleID</th>
						    </tr>
						  </thead>
						  
						  <tbody>
						    "; } ?>
								<?php
								
								if($query!='')
								{
								$num=0; 
								
							    $result = $conn->query($query);
                                if($result->num_rows > 0){
                                  while ($row = $result ->fetch_assoc()){
                                  extract($row);
								  $todaydate=date("Y-m-d");
								  if($scheduleDate>=$todaydate)
								  {
								       $num=$num+1;
								       $temptable = 24 -$seatleft[($num-1)];
								       
        								echo"
        								<tr class='alert' role='alert'>
        						    	<td width='30px'>$num</td>
        						        <td><img class='img' style='text-align: center;' src='data:image/jpeg;base64,".base64_encode($companyPicture)."'/><p>$companyName</p></td>
        						        <td width='80px'>$scheduleTime</td>
        								<td width='250px'>$scheduleDuration</td>
        								<td width='350px'>$scheduleDate</td>
										<td>$scheduleFrom</td>
        								<td>$scheduleDestination</td>
        						        <td>$temptable</td>
        								<td>$schedulePrice</td>
										<td>Book now</td>
        								<td style='display:none'>$scheduleID</td>
        								</tr>";
								      }
							    	}
                                }else if($scheduleDate==$todaydate){
								        $num=$num+1;
								        $temptable = 24 -$seatleft[($num-1)];
        								echo"
        								<tr class='alert' role='alert' style='color:#FF0000'>
        						    	<td>$num</td>
        						        <td><img class='img' style='text-align: center;' src='data:image/jpeg;base64,".base64_encode($companyPicture)."'/><p>$companyName</p></td>
        						        <td>$scheduleTime</td>
        								<td>$scheduleDuration</td>
        								<td>$scheduleDate</td>
										<td>$scheduleFrom</td>
        								<td>$scheduleDestination</td>
        						        <td>$temptable</td>
        								<td>$schedulePrice</td>
										<td>Book now</td>
        								<td style='display:none'>$scheduleID</td>
        								</tr>";
								  }
                                /*if($num==0 && $query!=''){
                                    echo '<script type="text/javascript"> document.getElementById("tableerrormessage").innerHTML="Please refer to company bus schedule!!";</script>';
                                   
                                }else{
                                       echo '<script type="text/javascript"> document.getElementById("tableerrormessage").innerHTML="";</script>';
                                   
                                }*/
                                								    
								}
								?>
						    
						   	<?php
				  if($query!=''){
				      echo'
						  </tbody>
						</table>';}  ?>
				<br><br>
				<div>	
			</div>
		</div>
		
	</section>
	<div class='modal' id='myModal'>
<form id="regForm" action="action_page.php" method="post"><span class="close">&times;</span>
  <h1 id="seatTitle">Register:</h1>
  <input type="hidden" name="ScheduleID" id="ScheduleID"/>
  <!-- One "tab" for each step in the form: -->
  <div class="tab">
  <div movie-containerclass="movie-container">
      
    </div>

			<ul class="showcase">
			  <li style="margin-left: 35%">
				<div class="seat"></div>
				<small>Available</small>&nbsp;&nbsp;&nbsp;
			  </li>
			  <li>
				<div class="seat selected"></div>
				<small>Selected</small>&nbsp;&nbsp;&nbsp;
			  </li>
			  <li style="margin-right: 35%">
				<div class="seat occupied"></div>
				<small>Occupied</small>
			  </li>
			</ul>

			<div class="container">
		

			  <div class="row2">
				 <div class="seat" id='seatid0'>
				    <input type="checkbox"  name="1a" value="1a" id='0' style="opacity:0;"/>
                  </div>
				<div class="seat"  id='seatid1'>
				    <input type="checkbox" name="1b" value="1b" id='1' style="opacity:0;"/>
                </div>
				<div class="seat"  id='seatid2'>
				    <input type="checkbox" name="1c" value="1c" id='2' style="opacity:0;"/>
                  </div>
				<div class="seat"  id='seatid3'>
				    <input type="checkbox" name="1d" value="1d" id='3' style="opacity:0;" />
                </div>
			  </div>

			  <div class="row2">
				<div class="seat"  id='seatid4'>
				    <input type="checkbox" name="2a" value="2a" id='4' style="opacity:0;" />
                </div>
				<div class="seat"  id='seatid5'>
				    <input type="checkbox" name="2b" value="2b" id='5' style="opacity:0;" />
                </div>
				<div class="seat"  id='seatid6'>
				    <input type="checkbox" name="2c" value="2c" id='6' style="opacity:0;" />
                  </div>
				<div class="seat"  id='seatid7'> 
				    <input type="checkbox" name="2d" value="2d" id='7' style="opacity:0;" />
                </div>
			  </div>

			  <div class="row2">
				<div class="seat"  id='seatid8'>
				    <input type="checkbox" name="3a" value="3a" id='8' style="opacity:0;"/>
                </div>
				<div class="seat"  id='seatid9'>
				    <input type="checkbox" name="3b" value='3b' id='9' style="opacity:0;" />
                </div>
			    <div class="seat"  id='seatid10'>
				    <input type="checkbox" name="3c" value="3c" id='10' style="opacity:0;"/>
                  </div>
				<div class="seat"  id='seatid11'>
				    <input type="checkbox" name="3d" value="3d" id='11' style="opacity:0;" />
                </div>
			  </div>

			  <div class="row2">
				<div class="seat"  id='seatid12'>
				    <input type="checkbox" name="4a" value="4a" id='12' style="opacity:0;" />
                </div>
				<div class="seat"  id='seatid13'>
				    <input type="checkbox" name="4b" value="4b" id='13' style="opacity:0;" />
                </div>
				<div class="seat"  id='seatid14'>
				    <input type="checkbox" name="4c" value="4c" id='14' style="opacity:0;" />
                  </div>
				<div class="seat"  id='seatid15'>
				    <input type="checkbox" name="4d" value="4d" id='15' style="opacity:0;" />
                </div>
			  </div>

			  <div class="row2">
				<div class="seat"  id='seatid16'>
				    <input type="checkbox" name="5a" value="5a" id='16' style="opacity:0;" />
                </div>
			    <div class="seat"  id='seatid17'>
				    <input type="checkbox" name="5b" value="5b" id='17' style="opacity:0;" />
                </div>
				<div class="seat"  id='seatid18'>
				    <input type="checkbox" name="5c" value="5c" id='18' style="opacity:0;" />
                  </div>
				<div class="seat"  id='seatid19'>
				    <input type="checkbox" name="5d" value="5d" id='19' style="opacity:0;" />
                </div>
			  </div>

			  <div class="row2">
				<div class="seat"  id='seatid20'>
				    <input type="checkbox" name="6a" value="6a" id='20' style="opacity:0;" />
                </div>
				<div class="seat"  id='seatid21'>
				    <input type="checkbox" name="6b" value="6b" id='21' style="opacity:0;" />
                </div>
				<div class="seat"  id='seatid22'>
				    <input type="checkbox" name="6c" value="6c" id='22' style="opacity:0;" />
                  </div>
				<div class="seat"  id='seatid23'>
				    <input type="checkbox" name="6d" value="6d" id='23' style="opacity:0;" />
                </div>
			  </div>
			</div>

			<p class="text" style="text-align: center">
			  You have selected <span id="count">0</span> seats for a price of Rs<span
				id="price" >0</span>
				<input type="hidden" id='seatPrice' name='seatPrice'/>
			</p>
	  <p style="color: red; text-align: center;" id="errormessage"></p>
  </div>
  <div class="tab">
       <div id="customerdetail"></div>
  </div>

  <div class="tab">
     <h3>Confirmation:</h3>
	  <div class="row2">
       <table class="table table-responsive-xl" id='confirmPayment' >
						 
						    <tr>
						    	
						    	<th>Description</th>
								<th>Unit Price</th>
						        <th>Qty</th>
						        <th>Amount (Rs)</th>
						     
						    </tr>
						  
						</table></div>
  </div>
  <div style="overflow:auto;">
    <div style="float:right;">
      <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
      <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
    </div>
  </div>
  <!-- Circles which indicates the steps of the form: -->
  <div style="text-align:center;margin-top:40px;">
    <span class="step"></span>
    <span class="step"></span>
    <span class="step"></span>
 
  </div>
</form>



</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>
    
	</body>
</html>
<script>

$(document).ready(function() {
   
    var table = $('#example').DataTable( {
        select: true
    } );
 
    table
        .on( 'select', function ( e, dt, type, indexes ) {
            var time = table.row( indexes  ).data()[2];
			var from2 = table.row( indexes  ).data()[5];
		    var destination2 = table.row( indexes  ).data()[6];
		    var date = table.row( indexes  ).data()[4];
		    var seat = table.row( indexes  ).data()[7];
		    var price = table.row( indexes  ).data()[8];
		    var scheduleID = table.row( indexes  ).data()[10];
		    var seatTitle = document.getElementById('seatTitle');
		    var seatPrice = document.getElementById('seatPrice');
		    var price2 = document.getElementById('price');
		    var count = document.getElementById('count');
		    var checkboxes = document.getElementsByTagName('input');
		    var ScheduleID = document.getElementById('ScheduleID');
            // Get the modal
			var modal = document.getElementById("myModal");

			// Get the <span> element that closes the modal
			var span = document.getElementsByClassName("close")[0];
		
             if(seat<1){
				 alert('Seat was full ！！');
			 }else{
			        var uncheck=document.getElementsByTagName('input');
        			 for(var i=0;i<uncheck.length;i++)
        			 {
        			  if(uncheck[i].type=='checkbox')
        			  {
        			   uncheck[i].checked=false;
        			  }
        			 }
        			 
        			
        			seatTitle.innerHTML= ''+date+' - '+from2+' - '+destination2;
					seatPrice.value = price; 
					ScheduleID.value=scheduleID;
					// When the user clicks the button, open the modal 
					 modal.style.display = "block";
					 ticket(scheduleID);
			 }
		    //pass value
		   
            
			// When the user clicks on <span> (x), close the modal
			 span.onclick = function() {
			  var ScheduleID = document.getElementById('ScheduleID').value='';
			  modal.style.display = "none";
			  price2.value='0';
			  count.value='0';
			  emptyseat();
			  document.getElementById("errormessage").innerHTML='';
			 if(currentTab==2){
						nextPrev(-2);myfunction();
					}else if(currentTab==3){
						nextPrev(-3);myfunction();
					}else if(currentTab==1){
						nextPrev(-1);myfunction();
					}else{myfunction();}
			 
			        var table = document.getElementById('confirmPayment');
        			var tbodyRowCount = table.tBodies[0].rows.length;
        			if(tbodyRowCount>1){
        				for (var i = 1; i < tbodyRowCount; i++) {
        				table.deleteRow(1);
        		
        				}
        			}
				
			}

			// When the user clicks anywhere outside of the modal, close it
			window.onclick = function(event) {
			  if (event.target == modal) {
				      var ScheduleID = document.getElementById('ScheduleID').value='';
					  modal.style.display = "none";
					  price2.value='0';
					  count.value='0';
				      emptyseat();
					  document.getElementById("errormessage").innerHTML='';
					  if(currentTab==2){
						nextPrev(-2);myfunction();
					}else if(currentTab==3){
						nextPrev(-3);myfunction();
					}else if(currentTab==1){
						nextPrev(-1);myfunction();
					}else{myfunction();}
					
					var table = document.getElementById('confirmPayment');
        			var tbodyRowCount = table.tBodies[0].rows.length;
        			if(tbodyRowCount>1){
        				for (var i = 1; i < tbodyRowCount; i++) {
        				table.deleteRow(1);
        		
        				}
        			}
					  
			  }
			}
					} )
       
		} );
		var currentTab = 0; // Current tab is set to be the first tab (0)
		showTab(currentTab); // Display the current tab
    function emptyseat(){
		
		for (var x=0;x<24;x++){
			var seatid = document.getElementById('seatid'+x);
			if(seatid.className='seat selected')
			{
				seatid.className='seat';
			    document.getElementById(''+x).disabled = false;
			}
			
		}
		
	}
	function myfunction(){
			   seatRequestNumber=0;
			   var temp2 =0;
		       document.getElementById('count').innerHTML=0;
		       document.getElementById('price').innerHTML=0;
              
			   var h3 = document.getElementsByTagName('h3');
			  // A loop that checks every input field in the current tab:
			  for (i = 0; i < h3.length; i++) {
				// If a field is empty...
				if (h3[i].id == "row0") {
				    var myobj = document.getElementById("row0");
					myobj.remove();
				}
				if (h3[i].id == "row1") {
				    var myobj = document.getElementById("row1");
					myobj.remove();
				}
				if (h3[i].id == "row2") {
				    var myobj = document.getElementById("row2");
					myobj.remove();
				}
				if (h3[i].id == "row3") {
				    var myobj = document.getElementById("row3");
					myobj.remove();
				}
				
			  }
			var uncheck=document.getElementsByTagName('input');
			 for(var i=0;i<uncheck.length;i++)
			 {
			  if(uncheck[i].type=='checkbox')
			  {
			   uncheck[i].checked=false;
			  }
			 }
		    
		    var x = document.getElementsByClassName("seat selected");
		    var i=1, seatid=[];

			 while(i<x.length)
			{
                  
			      seatid[i]=x[i].id;
				  
				  i++;
			 }
		    if(x.length==2){
				changeClassName(seatid[1]);
			}else if(x.length==3){
				changeClassName(seatid[1]);
				changeClassName(seatid[2]);
			}else if(x.length==4){
				changeClassName(seatid[1]);
				changeClassName(seatid[2]);
				changeClassName(seatid[3]);
			}else if(x.length>4){
				changeClassName(seatid[1]);
				changeClassName(seatid[2]);
				changeClassName(seatid[3]);
				changeClassName(seatid[4]);
			}
            
			
	}
	function ticket(destination) {
    var fromPHP, destinationPHP, ticketPHP;
    var numberTicet = '<?php echo $tempTicket ?>';

    <?php 
    for ($i = 0; $i < $tempTicket; $i++) { 
    ?>
        destinationPHP = '<?php echo $phpScheduleID[$i] ?>';
        fromPHP = '<?php echo $phpScheduleID[$i] ?>';
        ticketPHP = '<?php echo $ticket[$i] ?>';

        if (destination === destinationPHP) {
            let seatIndex = parseSeatIdToIndex(ticketPHP);
            if (seatIndex !== null) {
                document.getElementById(`seatid${seatIndex}`).className = 'seat occupied';
                document.getElementById(`${seatIndex}`).disabled = true;
            }
        }
    <?php 
    } 
    ?>
}

// Utility function to map seat IDs (like "1a") to seat indices
function parseSeatIdToIndex(seatId) {
    const row = parseInt(seatId[0], 10) - 1; // Row number (1-based) to 0-based index
    const column = seatId[1].charCodeAt(0) - 'a'.charCodeAt(0); // Column letter to 0-based index
    if (row >= 0 && column >= 0) {
        return row * 4 + column; // Calculate seat index (4 seats per row)
    }
    return null;
}

	    function changeClassName(id){
			document.getElementById(id).className='seat';
		}
		function showTab(n) {
		  // This function will display the specified tab of the form...
		  var x = document.getElementsByClassName("tab");
		  x[n].style.display = "block";
		  //... and fix the Previous/Next buttons:
		  if (n == 0) {
			document.getElementById("prevBtn").style.display = "none";
		  } else {
			document.getElementById("prevBtn").style.display = "inline";
		  }
		  if (n == (x.length - 1)) {
			document.getElementById("nextBtn").innerHTML = "Book Now";
		  } else {
			document.getElementById("nextBtn").innerHTML = "Next";
		  }
		  //... and run a function that will display the correct step indicator:
		  fixStepIndicator(n)
		}

		function nextPrev(n) {
	
		  if(currentTab==1 && n==-1){
			    myfunction();

				var table = document.getElementById('confirmPayment');
    			var count = $('#confirmPayment tr').length;
    
    			if(count>1){
    				for (var i = 1; i < count; i++) {
    				table.deleteRow(1);
    		
    				}
    			}
			}
		
		  // This function will figure out which tab to display
		  var x = document.getElementsByClassName("tab");
		  // Exit the function if any field in the current tab is invalid:
		  if (n == 1 && !validateForm()) return false;
		  // Hide the current tab:
		  x[currentTab].style.display = "none";
		  // Increase or decrease the current tab by 1:
		  currentTab = currentTab + n;
		  // if you have reached the end of the form...
		  if (currentTab >= x.length) {
			// ... the form gets submitted:
			document.getElementById("regForm").submit();
			return false;
		  }
		  // Otherwise, display the correct tab:
		  showTab(currentTab);
		}

		function validateForm() {
		  // This function deals with validation of the form fields
		  var x, y, i, valid = true,validRadio = false,number=0;
		  x = document.getElementsByClassName("tab");
		  y = x[currentTab].getElementsByTagName("input");
		  var customerdetail = document.getElementById('customerdetail');
		  // A loop that checks every input field in the current tab:
		  for (i = 0; i < y.length; i++) {
			// If a field is empty...
			if (y[i].value == "") {
			  // add an "invalid" class to the field:
			  y[i].className += " invalid";
			  // and set the current valid status to false
			  valid = false;
			}
			if (y[i].type == "checkbox") {
			  if(y[i].checked==true){
				  number=number+1;
			  }
			}
			 if (y[i].type == "radio") {
			  if(y[i].checked==true){
				  validRadio = true;
			  }
			}
		  }
			if(currentTab==0&& number==0){
				 valid = false;
				 document.getElementById("errormessage").innerHTML='Please check at least one seat!';
			}
			if(currentTab==0&& number!=0){
				  valid = true;
				  document.getElementById("errormessage").innerHTML='';
				  var name =[],temp=0;
				   var uncheck=document.getElementsByTagName('input');
				   for(var i=0;i<uncheck.length;i++)
				   {
				     if(uncheck[i].type=='checkbox' && uncheck[i].checked==true)
				       {
				           name[temp]=uncheck[i].name;
						   temp=temp+1;
						   
				       }
				    }
				   for(var x=0;x<temp;x++){
					      item = document.createElement("h3");
						  item.className = "row";
					      item.id='row'+x;
						  customerdetail.appendChild(item);
                          
					      part = document.createElement("h3");
					      part.id = 'h'+x;
						  part.innerHTML = "Seat No : "+name[x];
						  item.appendChild(part);
						  
					      part = document.createElement("input");
						  part.type = "hidden" ;
						  part.value = name[x];
					      part.name = "SeatNumber[]";
					      part.id = "Seat"+x;
						  item.appendChild(part);
					      
						  


					
			

				   }
				   var name2 =[],temp=0;
				   var sPrice = document.getElementById('seatPrice').value;
				   var uncheck2=document.getElementsByTagName('input');
				   var tmpForPayment=0;
				   var table = document.getElementById('confirmPayment');
				   for(var i=0;i<uncheck2.length;i++)
				   {
				     if(uncheck2[i].type=='checkbox' && uncheck2[i].checked==true)
				       {
						   
				           name2[tmpForPayment]=uncheck2[i].name;
						   tmpForPayment=tmpForPayment+1;
						   
				       }
				    }
				   var subtotal = tmpForPayment;
				   var row = table.insertRow(1);
					  var cell1 = row.insertCell(0);
					  var cell2 = row.insertCell(1);
					  var cell3 = row.insertCell(2);
					  var cell4 = row.insertCell(3);
				      cell1.innerHTML = "SUBTOTAL";
					  cell2.innerHTML ="-";
					  cell3.innerHTML ="-";
					  cell4.innerHTML =sPrice*subtotal;
				      var row = table.insertRow(1);
					  var cell1 = row.insertCell(0);
					  var cell2 = row.insertCell(1);
					  var cell3 = row.insertCell(2);
					  var cell4 = row.insertCell(3);
				      
				   for(var i=0;i<tmpForPayment;i++)
					{
					  var row = table.insertRow(1);
					  var cell1 = row.insertCell(0);
					  var cell2 = row.insertCell(1);
					  var cell3 = row.insertCell(2);
					  var cell4 = row.insertCell(3);
	
					  cell1.innerHTML = "1 ticket(s) from BusOnlineTicket.lk("+name2[i]+" - Rs"+sPrice+")";
					  cell2.innerHTML ="Rs "+sPrice;
					  cell3.innerHTML ="1";
					  cell4.innerHTML =sPrice;
				   }
				  

			}
			
			
		  // If the valid status is true, mark the step as finished and valid:
		  if (valid) {
			document.getElementsByClassName("step")[currentTab].className += " finish";
		  }
		  return valid; // return the valid status
		}

		function fixStepIndicator(n) {
		  // This function removes the "active" class of all steps...
		  var i, x = document.getElementsByClassName("step");
		  for (i = 0; i < x.length; i++) {
			x[i].className = x[i].className.replace(" active", "");
		  }
		  //... and adds the "active" class on the current step:
		  x[n].className += " active";
		}
	
	
	   var seatRequestNumber=0;
	   var count = document.getElementById('count');
	  
       $("input[type='checkbox']").change(function(){
		
				var price2 = document.getElementById('seatPrice').value;
				if($(this).is(":checked")){
								          
						$(this).parent().removeClass("seat"); 
						$(this).parent().addClass("seat selected"); 
						seatRequestNumber=seatRequestNumber+1;	
						count.innerHTML=seatRequestNumber;
						var total = seatRequestNumber*price2;
						document.getElementById('price').innerHTML=total;
						
				   
				}else{
					$(this).parent().removeClass("seat selected");  
						$(this).parent().addClass("seat"); 
						seatRequestNumber=seatRequestNumber-1;
						count.innerHTML=seatRequestNumber;
						var total = seatRequestNumber*price2;
						document.getElementById('price').innerHTML=total;
				}
			
		   
		});


</script>
<script>
	function login(){
		window.location.assign('login.php');
	}
	function logout(){
		window.location.assign('logout.php');
	}
</script>
