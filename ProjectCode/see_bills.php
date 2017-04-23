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

<table class="seelist">
	<tr>
    	<th>Bill No.</th>
    	<th>Customer Name</th>
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
		$qry = "SELECT * FROM bill WHERE (amount-paid_amount-discount) > 0.10;";

		$res = mysqli_query($conn, $qry);
		while($data = mysqli_fetch_assoc($res)){
			echo ("<tr><td>".$data['bill_no']."</td><td><a href='payment_details.php?billno=".$data['bill_no']."&billamount=".round($data['amount'],2)."&discount=".$data['discount']."&paidamount=".$data['paid_amount']."'>");
			$qry1 = "SELECT cust_name FROM customer WHERE cust_id = ".$data['cust_id'].";";
			//echo $qry1;
			$res1 = mysqli_query($conn, $qry1);
			
			while($data1 = mysqli_fetch_assoc($res1)){
				echo $data1['cust_name'];
				$balanceamount = $data['amount']-$data['discount']-$data['paid_amount'];
				echo("</a></td><td>".$data['bill_date']."</td><td>".round($data['amount'],2)."</td><td>".$data['discount']."</td><td>".$data['paid_amount']."</td><td>".round($balanceamount,2));
			}
			echo("</td><td><a href='delete_bill.php?billno=".$data['bill_no']."'><img src='delete1.png' alt='' style='width:40px; height:40px;'></a></td><td><a href='download_bill.php?billno=".$data['bill_no']."' target='_blank'><img src='download_image.png' alt='' style='width:40px; height:40px;'></a></td></tr>");
		}

	?>
</table>

<br><a href="download_unsettled_bills.php" target="_blank" class="seelist">Download as pdf</a><br><br>
<a href="see_settled_bills.php" class="seelist">See Settled Bills</a>


</body>
</html>
