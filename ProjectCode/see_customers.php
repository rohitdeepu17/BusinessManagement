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
    <th>Customer Name</th>
    <th>Father's Name</th>
    <th>Address</th>
    <th>Phone</th>
    <th>Other Details</th>
    <th>Delete</th>
  </tr>
  <?php 
		include 'connect_my_sql_db.php';
		$qry = "SELECT * FROM customer;";

		$res = mysqli_query($conn, $qry);
		while($data = mysqli_fetch_assoc($res)){
			//echo ("<tr><td>$data['cust_name']</td><td>$data['father_name']</td><td>$data['address']</td><td>$data['phone']</td><td>$data['other_details']</td><td><a href='delete_cat.php'><img src='delete.png' alt='' style='width:40px; height:40px;'></a></td></tr>");
			echo ("<tr><td>".$data['cust_name']."</td><td>".$data['father_name']."</td><td>".$data['address']."</td><td>".$data['phone']."</td><td>".$data['other_details']."</td><td><a href='delete_cat.php'><img src='delete.png' alt='' style='width:40px; height:40px;'></a></td></tr>");
			//echo ('<tr><td>$data["cust_name"]</td><td>$data["father_name"]</td><td>$data["address"]</td><td>$data["phone"]</td><td>$data["other_details"]</td><td><a href="delete_cat.php"><img src="delete.png" alt="" style="width:40px; height:40px;"></a></td></tr>');
			//echo ("<tr><td>$data[1]</td><td>$data[2]</td><td>$data[3]</td><td>$data[4]</td><td>$data[5]</td><td><a href='delete_cat.php'><img src='delete.png' alt='' style='width:40px; height:40px;'></a></td></tr>");
		}

	?>
</table>


</body>
</html>
