<?php
include 'connect_my_sql_db.php';
$cat_id = $_POST['cid'];
$cat_name    = $_POST['cname'];
$cat_details = $_POST['cdetails'];
$cat_hsn_code = $_POST['hsncode'];
$cat_sgst = $_POST['sgst'];
$cat_cgst = $_POST['cgst'];
$qry = "UPDATE category ". "SET cat_name = '$cat_name', ".
						" cat_hsn_code = '$cat_hsn_code', ".
						" cat_sgst = $cat_sgst, ".
						" cat_cgst = $cat_cgst, ".
						" cat_details = '$cat_details' ". 
               "WHERE cat_id = $cat_id" ;
//$qry = "UPDATE category ". "SET cat_name = '$cat_name' "."WHERE cat_id = $cat_id" ;
echo $qry;
$que1 = mysqli_query($conn, $qry);
if (!$que1) {
    echo "not updated";
}
header('Location: see_categories.php');
?>