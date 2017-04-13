<?php
include 'connect_my_sql_db.php';

$billno    = $_POST['billno'];
$paymentdate = $_POST['paymentdate'];
$paymentmode = $_POST['paymentmode'];
$paymentamount = $_POST['paymentamt'];
$discountamount = $_POST['discount'];
$qry         = "INSERT INTO salepayment(bill_no, transaction_date, transaction_mode, transaction_amount) values('$billno','$paymentdate','$paymentmode', '$paymentamount')";
echo $qry;
$que1 = mysqli_query($conn, $qry);
if (!$que1) {
    echo "not inserted";
    header('Location: payment_details.php?billno='.$billno);
} else {
	if($discountamount>0.10){
		$qry2 = "UPDATE bill ". "SET discount = discount + $discountamount ". 
               "WHERE bill_no = $billno;" ;
		$res2 = mysqli_query($conn, $qry2);
		if(!$res2)
			echo "discount not updated";
	}
	
	$qry2 = "UPDATE bill ". "SET paid_amount = paid_amount + $paymentamount ". 
               "WHERE bill_no = $billno;" ;
	echo $qry2;
	$res2 = mysqli_query($conn, $qry2);
	if(!$res2)
		echo "paid amount not updated";
    header('Location: see_bills.php');
}
?>