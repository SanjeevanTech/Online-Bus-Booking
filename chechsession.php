<?php
$hashedPassword = password_hash("asd", PASSWORD_DEFAULT);


if($_SERVER['REQUEST_METHOD']=='POST'){
    $password1=$_POST['password'];

    if (password_verify($password1,$hashedPassword)) {
        echo $hashedPassword;
        echo "\n correct";
     } 
     else {
         echo "not correct";
     }
}




?>

<form method="post">
 		<br><br>
      <h1 align="center">Login</h1><br>
      <div class="input_container" align="center">
        <input
          placeholder=" &nbsp; trendbus123"
          type="password"
          name="password"
          id="password"
          class="input_field" required
        />
      
		<br><br>
      <button class="loginbtn" type="submit" name="loginbtn">Login</button>
   
    
	</div>
		</form>
