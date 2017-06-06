<?php
include 'connect_my_sql_db.php';

$vname    	= $_POST['vname'];
$vaddress   	= $_POST['vaddress'];
$pname = $_POST['pname'];
$vphone = $_POST['vphone'];
$vbankacc = $_POST['vbankacc'];
$vbankifsc = $_POST['vbankifsc'];
$vdetails 		= $_POST['vdetails'];

$qry         = "INSERT INTO vendor(vendor_name, person_name, address, phone, bank_account, ifsc_code, balance, other_details)
			    values('$vname', '$pname', '$vaddress', 
			    	   '$vphone', '$vbankacc', '$vbankifsc', 0.00, '$vdetails')";
			    
echo $qry;
$que1 = mysqli_query($conn, $qry);

if (!$que1) {
    echo "not inserted";
    //header('Location: add_customer.php');
} else {
    header('Location: see_vendors.php');
}
?>