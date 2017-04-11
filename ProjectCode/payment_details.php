<?php
include 'session_check_common.php';
include 'connect_my_sql_db.php';
$billno = $_GET['billno'];
$totalamount = $_GET['billamount'];
$discount = $_GET['discount'];
$paidamount = $_GET['paidamount'];
//echo $billno;
/*$prodname = null;
$proddetails = null;
$prodstock = null;
$produnitsaleprice = null;
$produnitcostprice = null;
$prodcat = null;
$qry = "SELECT * FROM product WHERE prod_id=".$prodid;

$res = mysqli_query($conn, $qry);
while($data = mysqli_fetch_assoc($res)){
	$prodname = $data['prod_name'];
	$proddetails = $data['prod_details'];
	$prodstock = $data['stock'];
	$produnitsaleprice = $data['unit_sale_price'];
	$produnitcostprice = $data['unit_cost_price'];
	$prodcat = $data['cat_name'];
}*/

?>


<!DOCTYPE html>
<html>
<style>
</style>
<body>
<link href="css/my_file.css" rel="stylesheet" type="text/css" />

<nav id="navMenu" class="sidenav"></nav>
<script src="nav_script.js"></script>
<script>
function goBack(){
	window.history.back();
}
</script>
	
	<?php 
		include 'connect_my_sql_db.php';
		$qry = "SELECT * FROM salepayment WHERE bill_no=".$billno.";";
		//$qry = "SELECT * FROM category;";
		//echo $qry;
		$res = mysqli_query($conn, $qry);
		
		echo "<table class='subform' border='1'>
		<tr>
		<th>Payment Date</th>
		<th>Payment Amount</th>
		<th>Payment Mode</th>
		</tr>";
		
		while($data =  mysqli_fetch_assoc($res))
		{
		echo "<tr>";
			echo "<td style='height:20px'>".$data['transaction_date']."</td>";
			echo "<td style='height:20px'>" . $data['transaction_amount'] . "</td>";
			echo "<td style='height:20px'>" . printTransactionMode($data['transaction_mode']) . "</td>";
		echo "</tr>";
		}
		echo "</table>";
		
		echo "<br>";
		
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
    			default:
    				return "Others";
    		}
		}
		
		echo "<table class='subform' border='1'>
		<tr>
		<th>Total Amount</th>
		<th>Discount</th>
		<th>Paid Amount</th>
		<th>Balance</th>
		</tr>";
		
		echo "<tr>";
			echo "<td style='height:20px'>".$totalamount."</td>";
			echo "<td style='height:20px'>" . $discount . "</td>";
			echo "<td style='height:20px'>" . $paidamount . "</td>";
			echo "<td style='height:20px'>" . ($totalamount-$paidamount-$discount) . "</td>";
		echo "</tr>";
		echo "</table>";
		echo "<br>";
		
	?>

<form action="db_add_payment.php" class="subform" method="post">
	<fieldset>
	<legend style="font-size:22px">Adding a New Payment:</legend>
  	<div>
  		<label class="smalllabel"><b>Bill No.</b></label>
    	<input class="smallinput" type="text" placeholder="max 20 chars" name="billno" maxlength="20" value="<?php echo $billno;?>" readonly="readonly" required>
  	
    	<label class="smalllabel"><b>Payment Mode</b></label>
    	<select name="paymentmode">
    	<option value='1' selected>Cash</option>
    	<option value='2'>Cheque</option>
    	<option value='3'>NEFT</option>
    	<option value='4'>Other</option>
  		</select>
  		<br><br>
  		
  		<label class="smalllabel"><b>Payment Amount</b></label>
    	<input class="smallinput" type="number" step="0.01" placeholder="enter a number" name="paymentamt" value="0.00" required>
    	
    	<label class="smalllabel"><b>Payment Date</b></label>
    	<input class="smallinput" type="date" name="paymentdate" style="width:150px;" required>
    	
    	<button onclick="goBack()">BACK</button>
        <button type="submit">SUBMIT</button>
  	</div>
  	</fieldset>
</form>


</body>
</html>
