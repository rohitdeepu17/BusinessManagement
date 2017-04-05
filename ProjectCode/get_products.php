<?php
include 'connect_my_sql_db.php';
//$message = "inside get products";
//	echo "<script type='text/javascript'>alert('$message');</script>";
if(!empty($_POST["cat_name"])) {
	//$message = "inside get products with non empty cat_name";
	//echo "<script type='text/javascript'>alert('$message');</script>";
	$qry ="SELECT * FROM product WHERE cat_name = '" . $_POST["cat_name"] . "'";
	$results = mysqli_query($conn, $qry);
	echo('<option value="">Select Product</option>');
	foreach($results as $prod) {
	echo('<option value='.$prod["prod_id"].'>'.$prod["prod_name"].'</option>');
	}
}else{
	$message = "cat_name was received empty";
	echo "<script type='text/javascript'>alert('$message');</script>";
}

?>