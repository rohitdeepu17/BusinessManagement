<?php
include 'connect_my_sql_db.php';
if(!empty($_POST["prod_id"])) {
	$qry ="SELECT unit_sale_price FROM product WHERE prod_id = '" . $_POST["prod_id"] . "'";
	$results = mysqli_query($conn, $qry);
	foreach($results as $prod) {
	echo($prod["unit_sale_price"]);
	}
}else{
	$message = "prod_id was received empty";
	echo "<script type='text/javascript'>alert('$message');</script>";
}

?>