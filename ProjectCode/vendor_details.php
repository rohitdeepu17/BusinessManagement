<?php
include 'session_check_common.php';
include 'connect_my_sql_db.php';
$vendorid = $_GET['vendorid'];
$vendorname = null;
$vendordetails = null;
$vendorphone = null;
$vendoraddress = null;
$personname = null;
$bankacc = null;
$ifsccode = null;
$qry = "SELECT * FROM vendor WHERE vendor_id=".$vendorid;

$res = mysqli_query($conn, $qry);
while($data = mysqli_fetch_assoc($res)){
	$vendorname = $data['vendor_name'];
	$vendordetails = $data['other_details'];
	$vendorphone = $data['phone'];
	$vendoraddress = $data['address'];
	$personname = $data['person_name'];
	$bankacc = $data['bank_account'];
	$ifsccode = $data['ifsc_code'];
}
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

function toggleShowHide(){
	var x = document.getElementById('settled_bills');
    if (x.style.display === 'none') {
        x.style.display = 'block';
    } else {
        x.style.display = 'none';
    }
}
</script>

<div>

<div>
<form action="db_update_customer.php" class="subform" method="post" style="float:left">
	<fieldset>
	<legend style="font-size:22px">Updating a Vendor:</legend>
  	<div>
  		<label class="smalllabel"><b>Vendor Id</b></label>
    	<input class="smallinputreadonly" type="text" placeholder="max 20 chars" name="cid" maxlength="20" value="<?php echo $vendorid;?>" readonly="readonly" required>
    	
  		<label class="smalllabel"><b>Vendor Name</b></label>
    	<input class="smallinput" type="text" placeholder="max 20 chars" name="cname" maxlength="20" value="<?php echo $vendorname;?>" required>
    	
    	<label class="smalllabel"><b>Address</b></label>
    	<input class="smallinput" type="text" placeholder="village name only" name="caddress" maxlength="20" value="<?php echo $vendoraddress;?>" required>
    	
    	<label class="smalllabel"><b>Person Name</b></label>
    	<input class="smallinput" type="text" placeholder="max 20 chars" name="fname" maxlength="20" value="<?php echo $personname;?>" required>
    	
    	<label class="smalllabel"><b>Contact</b></label>
    	<input class="smallinput" type="number" placeholder="phone" name="cphone" maxlength="20" value="<?php echo $vendorphone;?>" required>
    	
    	<label class="smalllabel"><b>Bank Account</b></label>
    	<input class="smallinput" type="text" placeholder="village name only" name="vbankacc" maxlength="20" value="<?php echo $bankacc;?>" required>
    	
    	<label class="smalllabel"><b>IFSC Code</b></label>
    	<input class="smallinput" type="text" placeholder="village name only" name="ifsccode" maxlength="20" value="<?php echo $ifsccode;?>" required>
    	
    	<label class="smalllabel"><b>Other Details</b></label>
    	<!-- <input class="largeinput" type="text" placeholder="" name="pdetails" max-length="50"> -->
    	<textarea class="largeinput" name="cdetails" placeholder="ex : Complete address, C/O, alternate contact number, etc. max 50 chars" cols="40" rows="5" maxlength="50"><?php echo $vendordetails;?></textarea>
    	
    	<button onclick="goBack()">BACK</button>
        <button type="submit">SUBMIT</button>
  	</div>
  	</fieldset>
</form>
</div>

<div >
<table>
	<tr>
    	<th>Transaction No.</th>
    	<th>Transaction Date</th>
    	<th>Transaction Amount</th>
    	<th>Transaction Mode</th>
    	<th>Transaction Type</th>
    	<th>Balance</th>
    	<th>Transaction Details</th>
    	<th>Delete</th>
  	</tr>
  	
	<?php 
		include 'connect_my_sql_db.php';
		$qry = "SELECT * FROM vendor_transaction WHERE vendor_id = $vendorid ORDER BY transaction_date;";
		//echo $qry;
		$balance = 0.00;
		$res = mysqli_query($conn, $qry);
		while($data = mysqli_fetch_assoc($res)){
			if($data['transaction_type']==1)		//credit
				$balance-=$data['transaction_amount'];
			else
				$balance+=$data['transaction_amount'];
			echo ("<tr><td>".$data['vt_id']."</td>");
			echo("<td>".$data['transaction_date']."</td><td>".round($data['transaction_amount'],2)."</td><td>".printTransactionMode($data['transaction_mode'])."</td><td>".printTransactionType($data['transaction_type'])."</td><td>".round($balance,2)."</td><td>".$data['transaction_details']);
			echo("</td><td><a href='delete_vendor_transaction.php?transactionno=".$data['vt_id']."'><img src='delete1.png' alt='' style='width:40px; height:40px;'></a></td></tr>");
		}
		
		function printTransactionMode($transmode = 1) {
    		switch($transmode){
    			case 1:
    				return "Cash";
    				break;			//although break has no meaning after return
    			case 2:
    				return "Cheque";
    				break;
    			case 3:
    				return "NEFT";
    				break;
    			case 4:
    				return "Return Products";
    				break;
    			case 5:
    				return "Discout/Adjustment";
    				break;
    			case 6:
    				return "Purchase Products";
    				break;
    			default:
    				return "Cash";
    		}
		}
		
		function printTransactionType($transtype = 1) {
    		switch($transtype){
    			case 1:
    				return "Credit";
    				break;			//although break has no meaning after return
    			case 2:
    				return "Debit";
    				break;
    			default:
    				return "Credit";
    		}
		}
	?>
</table>


</div>
</div>

<div style="float:right;padding-right:5px;margin-top:10px">
<a href='download_vendor_transactions.php?vendorid=<?php echo $vendorid;?>' target='_blank'>Download as pdf</a>
<div>




</body>
</html>
