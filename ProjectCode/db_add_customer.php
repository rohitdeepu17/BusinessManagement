<?php
include 'connect_my_sql_db.php';

$cname    	= $_POST['cname'];
$fname = $_POST['fname'];
$caddress   	= $_POST['caddress'];
$cphone = $_POST['cphone'];
$cdetails 		= $_POST['cdetails'];

$qry         = "INSERT INTO customer(cust_name, father_name, address, phone, other_details)
			    values('$cname', '$fname', '$caddress', 
			    	   '$cphone', '$cdetails')";
			    
echo $qry;
$que1 = mysqli_query($conn, $qry);

if (!$que1) {
    echo "not inserted";
    header('Location: add_customer.php');
} else {
    header('Location: see_customers.php');
}
?>