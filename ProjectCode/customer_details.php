<?php
include 'session_check_common.php';
include 'connect_my_sql_db.php';
$custid = $_GET['custid'];
$custname = null;
$custdetails = null;
$custphone = null;
$custaddress = null;
$custfather = null;
$qry = "SELECT * FROM customer WHERE cust_id=".$custid;

$res = mysqli_query($conn, $qry);
while($data = mysqli_fetch_assoc($res)){
	$custname = $data['cust_name'];
	$custdetails = $data['other_details'];
	$custphone = $data['phone'];
	$custaddress = $data['address'];
	$custfather = $data['father_name'];
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
	<legend style="font-size:22px">Adding a Customer:</legend>
  	<div>
  		<label class="smalllabel"><b>Customer Id</b></label>
    	<input class="smallinputreadonly" type="text" placeholder="max 20 chars" name="cid" maxlength="20" value="<?php echo $custid;?>" readonly="readonly" required>
    	
  		<label class="smalllabel"><b>Customer Name</b></label>
    	<input class="smallinput" type="text" placeholder="max 20 chars" name="cname" maxlength="20" value="<?php echo $custname;?>" required>
    	
    	<label class="smalllabel"><b>Fathers Name</b></label>
    	<input class="smallinput" type="text" placeholder="max 20 chars" name="fname" maxlength="20" value="<?php echo $custfather;?>" required>
    	
    	<label class="smalllabel"><b>Address</b></label>
    	<input class="smallinput" type="text" placeholder="village name only" name="caddress" maxlength="20" value="<?php echo $custaddress;?>" required>
    	
    	<label class="smalllabel"><b>Contact</b></label>
    	<input class="smallinput" type="number" placeholder="phone" name="cphone" maxlength="20" value="<?php echo $custphone;?>" required>
    	
    	<label class="smalllabel"><b>Other Details</b></label>
    	<!-- <input class="largeinput" type="text" placeholder="" name="pdetails" max-length="50"> -->
    	<textarea class="largeinput" name="cdetails" placeholder="ex : Complete address, C/O, alternate contact number, etc. max 50 chars" cols="40" rows="5" maxlength="50"><?php echo $custdetails;?></textarea>
    	
    	<button onclick="goBack()">BACK</button>
        <button type="submit">SUBMIT</button>
  	</div>
  	</fieldset>
</form>
</div>

<div style="float:right">
<table>
	<tr>
    	<th>Bill No.</th>
    	<th>Bill Date</th>
    	<th>Bill Amount</th>
    	<th>Discount</th>
    	<th>Paid Amount</th>
    	<th>Balance</th>
    	<th>Delete</th>
    	<th>Download</th>
  	</tr>
  	
	<?php 
		include 'connect_my_sql_db.php';
		$qry = "SELECT * FROM bill WHERE cust_id = $custid AND (amount-paid_amount-discount) > 0.10;";

		$res = mysqli_query($conn, $qry);
		while($data = mysqli_fetch_assoc($res)){
			echo ("<tr><td>".$data['bill_no']."</td>");
				$balanceamount = $data['amount']-$data['discount']-$data['paid_amount'];
				echo("<td>".$data['bill_date']."</td><td>".round($data['amount'],2)."</td><td>".$data['discount']."</td><td>".$data['paid_amount']."</td><td>".round($balanceamount,2));
			echo("</td><td><a href='delete_bill.php?billno=".$data['bill_no']."'><img src='delete1.png' alt='' style='width:40px; height:40px;'></a></td><td><a href='download_bill.php?billno=".$data['bill_no']."' target='_blank'><img src='download_image.png' alt='' style='width:40px; height:40px;'></a></td></tr>");
		}

	?>
</table>

<button type="button" onclick="toggleShowHide()">Settled Bills</button>

<table id="settled_bills" style="display:none">
	<tr>
    	<th>Bill No.</th>
    	<th>Bill Date</th>
    	<th>Bill Amount</th>
    	<th>Discount</th>
    	<th>Paid Amount</th>
    	<th>Balance</th>
    	<th>Delete</th>
    	<th>Download</th>
  	</tr>
  	
	<?php 
		include 'connect_my_sql_db.php';
		$qry = "SELECT * FROM bill WHERE cust_id = $custid AND (amount-paid_amount-discount) < 0.10;";

		$res = mysqli_query($conn, $qry);
		while($data = mysqli_fetch_assoc($res)){
			echo ("<tr><td>".$data['bill_no']."</td>");
				$balanceamount = $data['amount']-$data['discount']-$data['paid_amount'];
				echo("<td>".$data['bill_date']."</td><td>".round($data['amount'],2)."</td><td>".$data['discount']."</td><td>".$data['paid_amount']."</td><td>".round($balanceamount,2));
			echo("</td><td><a href='delete_bill.php?billno=".$data['bill_no']."'><img src='delete1.png' alt='' style='width:40px; height:40px;'></a></td><td><a href='download_bill.php?billno=".$data['bill_no']."' target='_blank'><img src='download_image.png' alt='' style='width:40px; height:40px;'></a></td></tr>");
		}

	?>
</table>


<!-- <a onclick="document.getElementById('settled_bills').style.display='block'">See Settled Bills</a> -->


</div>
</div>

</body>
</html>
