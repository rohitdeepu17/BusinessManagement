<?php
include 'session_check_common.php';
include 'connect_my_sql_db.php';
?>


<!DOCTYPE html>
<html>
<style>
</style>
<body>
<link href="css/my_file1.css" rel="stylesheet" type="text/css" />

<nav id="navMenu" class="sidenav"></nav>
<script src="nav_script.js"></script>

<form action="db_add_vendor.php" class="subform" method="post">
	<fieldset>
	<legend style="font-size:22px">Adding a Vendor:</legend>
  	<div>
  		<label class="smalllabel"><b>Vendor Name</b></label>
    	<input class="smallinput" type="text" placeholder="max 30 chars" name="vname" maxlength="30" required>
    	
    	<label class="smalllabel"><b>Address</b></label>
    	<input class="smallinput" type="text" placeholder="village/city name only" name="vaddress" maxlength="20" required>
    	
    	<label class="smalllabel"><b>Person Name</b></label>
    	<input class="smallinput" type="text" placeholder="max 20 chars" name="pname" maxlength="20" required>
    	
    	<label class="smalllabel"><b>Contact</b></label>
    	<input class="smallinput" type="number" placeholder="phone" name="vphone" maxlength="20" required>
    	
    	<label class="smalllabel"><b>Bank Account No</b></label>
    	<input class="smallinput" type="number" placeholder="bank account number" name="vbankacc" maxlength="20">
    	
    	<label class="smalllabel"><b>IFSC Code</b></label>
    	<input class="smallinput" type="text" placeholder="IFSC code for NEFT transactions" name="vbankifsc" maxlength="11">
    	
    	<label class="smalllabel"><b>Other Details</b></label>
    	<!-- <input class="largeinput" type="text" placeholder="" name="pdetails" max-length="50"> -->
    	<textarea class="largeinput" name="vdetails" placeholder="ex : type of products dealing in, alt contact,etc. max 50 chars" cols="40" rows="5" maxlength="50"></textarea>
    	
        <button type="submit">SUBMIT</button>
  	</div>
  	</fieldset>
</form>


</body>
</html>
