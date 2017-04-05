<?php
include 'session_check_common.php';
include 'connect_my_sql_db.php';
?>


<!DOCTYPE html>
<html>
<style>
</style>
<body>
<link href="css/my_file.css" rel="stylesheet" type="text/css" />

<nav id="navMenu" class="sidenav"></nav>
<script src="nav_script.js"></script>

<form action="db_add_customer.php" class="subform" method="post">
	<fieldset>
	<legend style="font-size:22px">Adding a Customer:</legend>
  	<div>
  		<label class="smalllabel"><b>Customer Name</b></label>
    	<input class="smallinput" type="text" placeholder="max 20 chars" name="cname" maxlength="20" required>
    	
    	<label class="smalllabel"><b>Fathers Name</b></label>
    	<input class="smallinput" type="text" placeholder="max 20 chars" name="fname" maxlength="20" required>
    	
    	<label class="smalllabel"><b>Address</b></label>
    	<input class="smallinput" type="text" placeholder="village name only" name="caddress" maxlength="20" required>
    	
    	<label class="smalllabel"><b>Contact</b></label>
    	<input class="smallinput" type="number" placeholder="phone" name="cphone" maxlength="20" required>
    	
    	<label class="smalllabel"><b>Other Details</b></label>
    	<!-- <input class="largeinput" type="text" placeholder="" name="pdetails" max-length="50"> -->
    	<textarea class="largeinput" name="cdetails" placeholder="ex : Complete address, C/O, alternate contact number, etc. max 50 chars" cols="40" rows="5" maxlength="50"></textarea>
    	
        <button type="submit">SUBMIT</button>
  	</div>
  	</fieldset>
</form>


</body>
</html>
