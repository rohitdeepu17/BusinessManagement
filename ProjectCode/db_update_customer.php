<?php
include 'connect_my_sql_db.php';
$cid = $_POST['cid'];
$cname    	= $_POST['cname'];
$fname = $_POST['fname'];
$caddress   	= $_POST['caddress'];
$cphone = $_POST['cphone'];
$cdetails 		= $_POST['cdetails'];


$qry = "UPDATE customer ". "SET cust_name = '$cname', "." other_details = '$cdetails', "." father_name = '$fname', ".
		" phone = $cphone, "." address = '$caddress' ".
               "WHERE cust_id = $cid" ;
//$qry = "UPDATE category ". "SET cat_name = '$cat_name' "."WHERE cat_id = $cat_id" ;
echo $qry;
$que1 = mysqli_query($conn, $qry);
if (!$que1) {
    echo "not updated";
}
header('Location: see_customers.php');
?>