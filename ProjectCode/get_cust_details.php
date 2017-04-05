<?php
include 'connect_my_sql_db.php';
if(!empty($_POST["cust_id"])) {
	$qry ="SELECT father_name, phone, address, other_details FROM customer WHERE cust_id = " . $_POST["cust_id"] . "";
	$results = mysqli_query($conn, $qry);
	foreach($results as $prod) {
	echo('{'.'"cust_id":"'.$_POST["cust_id"].'","father_name":"'.$prod["father_name"].'","phone":"'.$prod["phone"].'","address":"'.$prod["address"].'","other_details":"'.$prod["other_details"].'"}');
	//echo json_encode("hey":"rohithere");
	}
}else{
	$message = "prod_id was received empty";
	echo "<script type='text/javascript'>alert('$message');</script>";
}

?>