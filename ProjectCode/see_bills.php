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
    	<th><a href="see_bills.php?sort=billno">Bill No.</th>
    	<th><a href="see_bills.php?sort=name">Customer Name</th>
    	<th><a href="see_bills.php?sort=address">Address</th>
    	<th><a href="see_bills.php?sort=billdate">Bill Date</th>
    	<th>Bill Amount</th>
    	<th>Discount</th>
    	<th>Paid Amount</th>
    	<th><a href="see_bills.php?sort=balance">Balance</th>
    	<th>Delete</th>
    	<th>Download</th>
    	<th>Download Tax</th>
  	</tr>
  	
	<?php 
		include 'connect_my_sql_db.php';
		$qry = "SELECT B.*, C.cust_name, C.address FROM bill B, customer C WHERE B.cust_id = C.cust_id AND (B.amount-B.paid_amount-B.discount) > 0.10";
		//$qry .= " ORDER BY (amount-paid_amount-discount) DESC";
		
		if ($_GET['sort'] == 'balance'){
			$qry .= " ORDER BY (amount-paid_amount-discount) DESC";
		}
		else if($_GET['sort'] == 'billdate'){
			$qry .= " ORDER BY bill_date";
		}else if($_GET['sort'] == 'billno'){
			$qry .= " ORDER BY bill_no";
		}else if($_GET['sort'] == 'name'){
			$qry .= " ORDER BY cust_name";
		}else if($_GET['sort'] == 'address'){
			$qry .= " ORDER BY address";
		}

		$res = mysqli_query($conn, $qry);
		while($data = mysqli_fetch_assoc($res)){
			echo ("<tr><td>".$data['bill_no']."</td><td><a href='payment_details.php?billno=".$data['bill_no']."&billamount=".round($data['amount'],2)."&discount=".$data['discount']."&paidamount=".$data['paid_amount']."'>");
			//$qry1 = "SELECT cust_name FROM customer WHERE cust_id = ".$data['cust_id'].";";
			//echo $qry1;
			//$res1 = mysqli_query($conn, $qry1);
			
			//while($data1 = mysqli_fetch_assoc($res1)){
				//echo $data1['cust_name'];
				echo $data['cust_name'];
				$balanceamount = $data['amount']-$data['discount']-$data['paid_amount'];
				echo("</a></td><td>".$data['address']."</td><td>".$data['bill_date']."</td><td>".round($data['amount'],2)."</td><td>".$data['discount']."</td><td>".$data['paid_amount']."</td><td>".round($balanceamount,2));
			//}
			echo("</td><td><a href='delete_bill.php?billno=".$data['bill_no']."'><img src='delete1.png' alt='' style='width:40px; height:40px;'></a></td><td><a href='download_bill.php?billno=".$data['bill_no']."' target='_blank'><img src='download_image.png' alt='' style='width:40px; height:40px;'></a></td><td><a href='download_bill_tax.php?billno=".$data['bill_no']."' target='_blank'><img src='download_image.png' alt='' style='width:40px; height:40px;'></a></td></tr>");
		}

	?>
</table>

<br><a href="download_unsettled_bills.php" target="_blank" class="seelist">Download as pdf</a><br><br>
<a href="see_settled_bills.php" class="seelist">See Settled Bills</a>


</body>
</html>
