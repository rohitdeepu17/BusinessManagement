<?php
include 'connect_my_sql_db.php';
$pid = $_POST['pid'];
$pname    	= $_POST['pname'];
$categories = $_POST['categories'];
$pstock   	= $_POST['pstock'];
$punitcostprice = $_POST['punitcostprice'];
$punitsaleprice = $_POST['punitsaleprice'];
$pdetails 		= $_POST['pdetails'];


$qry = "UPDATE product ". "SET prod_name = '$pname', "." prod_details = '$pdetails', "." cat_name = '$categories', ".
		" stock = $pstock, "." unit_cost_price = $punitcostprice, "." unit_sale_price = $punitsaleprice ".
               "WHERE prod_id = $pid" ;
//$qry = "UPDATE category ". "SET cat_name = '$cat_name' "."WHERE cat_id = $cat_id" ;
echo $qry;
$que1 = mysqli_query($conn, $qry);
if (!$que1) {
    echo "not updated";
}
//header('Location: see_products.php');
?>