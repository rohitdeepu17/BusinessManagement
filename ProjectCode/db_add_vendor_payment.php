<?php
include 'connect_my_sql_db.php';

$vendorid    = $_POST['vendorid'];
$transactiontype = $_POST['transactiontype'];
$transactiondate = $_POST['transactiondate'];
$transactionmode = $_POST['transactionmode'];
$transactionamount = $_POST['transactionamt'];
$transactiondetails = $_POST['transactiondetails'];
$qry = "INSERT INTO vendor_transaction(vendor_id, transaction_type, transaction_date, transaction_mode, transaction_amount, transaction_details) values('$vendorid', '$transactiontype', '$transactiondate','$transactionmode', '$transactionamount', '$transactiondetails')";
echo $qry;
$que1 = mysqli_query($conn, $qry);
if (!$que1) {
    echo "not inserted";
    //header('Location: add_vendor_payment.php');
} else {
	echo "inserted";
	$qry2 = null;
	if($transactiontype==1)
		$qry2 = "UPDATE vendor ". "SET balance = balance - $transactionamount ". 
               "WHERE vendor_id = $vendorid;" ;
	else
		$qry2 = "UPDATE vendor ". "SET balance = balance + $transactionamount ". 
               "WHERE vendor_id = $vendorid;" ;
	echo $qry2;
	$res2 = mysqli_query($conn, $qry2);
	if(!$res2)
		echo "balance not updated";
	header('Location: see_vendors.php');
}
?>