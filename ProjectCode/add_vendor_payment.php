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
<script>
function goBack(){
	window.history.back();
}
</script>

<form action="db_add_vendor_payment.php" class="subform" method="post">
	<fieldset>
	<legend style="font-size:22px">Adding a New Vendor Transaction:</legend>
  	<div>
  		<label class="smalllabel"><b>Vendor</b></label>
  		<select style="width:150px;" class="gr" name="vendorid">
       				<option value="Select Vendor">Select Vendor</option>		
    				<?php 
						include 'connect_my_sql_db.php';
						$qry = "SELECT vendor_id, vendor_name FROM vendor;";

						$res = mysqli_query($conn, $qry);
						while($data = mysqli_fetch_row($res)){
						echo ("<option value='$data[0]'>$data[1]</option>");
					}
					?>
		</select>
		
		<br></br>
  	
  		<label class="smalllabel"><b>Transaction Type.</b></label>
    	<select name="transactiontype">
    	<option value='1' selected>Credit(payment)</option>
    	<option value='2'>Debit(purchase)</option>
  		</select>
  		<br><br>
  	
    	<label class="smalllabel"><b>Transaction Mode</b></label>
    	<select name="transactionmode">
    	<option value='1' selected>Cash</option>
    	<option value='2'>Cheque</option>
    	<option value='3'>NEFT</option>
    	<option value='4'>Return Products</option>
    	<option value='5'>Discount/Adjustment</option>
    	<option value='6'>Purchase Products</option>
  		</select>
  		<br><br>
  		
  		<label class="smalllabel"><b>Transaction Amount</b></label>
    	<input class="smallinput" type="number" step="0.01" placeholder="enter a number" name="transactionamt" value="0.00" required>
    	
    	<label class="smalllabel"><b>Transaction Date</b></label>
    	<input class="smallinput" type="date" name="transactiondate" required>
    	
    	<label class="smalllabel"><b>Transaction Details</b></label>
    	<textarea class="largeinput" name="transactiondetails" placeholder="ex : type of products dealing in, alt contact,etc. max 50 chars" cols="40" rows="5" maxlength="50"></textarea>
    	
    	<button onclick="goBack()">BACK</button>
        <button type="submit">SUBMIT</button>
  	</div>
  	</fieldset>
</form>


</body>
</html>
