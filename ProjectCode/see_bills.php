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
		$qry = "SELECT * FROM bill;";

		$res = mysqli_query($conn, $qry);
		while($data = mysqli_fetch_assoc($res)){
			echo ("<tr><td>".$data['bill_no']."</td><td>");
			$qry1 = "SELECT cust_name FROM customer WHERE cust_id = ".$data['cust_id'].";";
			//echo $qry1;
			$res1 = mysqli_query($conn, $qry1);
			while($data1 = mysqli_fetch_assoc($res1)){
				echo $data1['cust_name'];
				echo("</td><td>".$data['bill_date']."</td><td>".$data['amount']."</td><td>".$data['discount']."</td><td>".$data['paid_amount']."</td><td>".($data['amount']-$data['discount']-$data['paid_amount']));
			}
			echo("</td><td><a href='delete_cat.php'><img src='delete.png' alt='' style='width:40px; height:40px;'></a></td><td><a href='download_bill.php?billno=".$data[bill_no]."' target='_blank'><img src='download_image.png' alt='' style='width:40px; height:40px;'></a></td></tr>");
		}

	?>
</table>


</body>
</html>
