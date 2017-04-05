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
    	<th>Category Name</th>
    	<th>Category Details</th>
    	<th>Delete</th>
  	</tr>
  	
	<?php 
		include 'connect_my_sql_db.php';
		$qry = "SELECT * FROM category;";

		$res = mysqli_query($conn, $qry);
		while($data = mysqli_fetch_assoc($res)){
			echo ("<tr><td>".$data['cat_name']."</td><td>".$data['cat_details']."</td><td><a href='delete_cat.php'><img src='delete.png' alt='' style='width:40px; height:40px;'></a></td></tr>");
		}

	?>
</table>


</body>
</html>
