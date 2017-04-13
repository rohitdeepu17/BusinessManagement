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
    <th>Product Name</th>
    <th>Product Category</th>
    <th>Unit Cost Price</th>
    <th>Unit Sale Price</th>
    <th>Stock</th>
    <th>Product Details</th>
    <th>Delete</th>
  </tr>
  
  <?php 
		include 'connect_my_sql_db.php';
		$qry = "SELECT * FROM product;";

		$res = mysqli_query($conn, $qry);
		while($data = mysqli_fetch_assoc($res)){
			//echo ("<tr><td>$data[1]</td><td>$data[6]</td><td>$data[4]</td><td>$data[3]</td><td>$data[2]</td><td>$data[5]</td><td><a href='delete_cat.php'><img src='delete.png' alt='' style='width:40px; height:40px;'></a></td></tr>");
			echo ("<tr><td><a href='product_details.php?prodid=".$data['prod_id']."'>".$data['prod_name']."</a></td><td>".$data['cat_name']."</td><td>".$data['unit_cost_price']."</td><td>".$data['unit_sale_price']."</td><td>".$data['stock']."</td><td>".$data['prod_details']."</td><td><a href='delete_prod.php?prodid=".$data['prod_id']."'><img src='delete1.png' alt='' style='width:40px; height:40px;'></a></td></tr>");
		}

	?>
</table>


</body>
</html>
