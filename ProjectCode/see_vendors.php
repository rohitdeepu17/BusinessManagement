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
    <th>Vendor Name</th>
    <th>Address</th>
    <th>Person Name</th>
    <th>Phone</th>
    <th>Bank Account No</th>
    <th>IFSC Code</th>
    <th>Balance</th>
    <th>Other Details</th>
    <th>Delete</th>
  </tr>
  <?php 
		include 'connect_my_sql_db.php';
		$qry = "SELECT * FROM vendor ORDER BY address;";
		$total_balance = 0.00;
		$res = mysqli_query($conn, $qry);
		while($data = mysqli_fetch_assoc($res)){
			$total_balance += $data['balance'];
			echo ("<tr><td><a href='vendor_details.php?vendorid=".$data['vendor_id']."'>".$data['vendor_name']."</a></td><td>".$data['address']."</td><td>".$data['person_name']."</td><td>".$data['phone']."</td><td>".$data['bank_account']."</td><td>".$data['ifsc_code']."</td><td>".$data['balance']."</td><td>".$data['other_details']."</td><td><a href='delete_vendor.php?vendorid=".$data['vendor_id']."'><img src='delete1.png' alt='' style='width:40px; height:40px;'></a></td></tr>");
		}
		
	?>
</table>
  
<div style="float:right;padding-right:50px">
<p>Total Balance = Rs.<?php echo $total_balance;?></p>
<div>

<a href='download_vendors.php' target='_blank'>Download as pdf</a>
<br><br>
<a href='download_vendors_balance.php' target='_blank'>Download Balance as pdf</a>

</body>
</html>
