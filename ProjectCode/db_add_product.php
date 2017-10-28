<?php
include 'connect_my_sql_db.php';

$pname    	= $_POST['pname'];
$categories = $_POST['categories'];
$pstock   	= $_POST['pstock'];
$punitcostprice = $_POST['punitcostprice'];
$punitsaleprice = $_POST['punitsaleprice'];
$pdetails 		= $_POST['pdetails'];

$qry         = "INSERT INTO product(prod_name, cat_id, stock, unit_cost_price, 
				unit_sale_price, prod_details)
			    values('$pname', '$categories', '$pstock', 
			    	   '$punitcostprice', '$punitsaleprice', '$pdetails')";
			    
echo $qry;
$que1 = mysqli_query($conn, $qry);

if (!$que1) {
    echo "not inserted";
    header('Location: add_product.php');
} else {
    header('Location: see_products.php');
}
?>