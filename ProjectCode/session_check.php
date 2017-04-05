<?php
include 'connect_my_sql_db.php';

//	echo "<script type='text/javascript'>alert('submitted successfully!')</script>";
      

//if both username and password fields are filled, then only we can start a session
if($_POST['uname']!="" && $_POST['psw']!=""){
	echo 'username and password are non-empty<br>';
		// Retrieve username and password from database according to user's input
		//Username and password is set default
		// Check username and password match
		if($_POST['uname']=="rohitdeepu17" && $_POST['psw']=="abc123")
		{
			//start a session
			session_start();
			// Set username session variable
			$_SESSION['usrname'] = $_POST['uname'];
			// Jump to secured page
			header('Location:add_bill.php');
		}
	
		else {
			// Jump to login page
			header('Location: LoginPage.html');
		}
}else{
	echo "Username/Password is empty<br>";
}
?>
