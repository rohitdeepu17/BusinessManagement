<?php
include 'connect_my_sql_db.php';

$cat_name    = $_POST['cname'];
$cat_details = $_POST['cdetails'];
$cat_hsncode = $_POST['hsncode'];
$cat_sgst = $_POST['sgst'];
$cat_cgst = $_POST['cgst'];
$qry         = "INSERT INTO category(cat_name,cat_details,cat_hsn_code, cat_sgst, cat_cgst) values('$cat_name','$cat_details','$cat_hsncode','$cat_sgst','$cat_cgst')";
echo $qry;
$que1 = mysqli_query($conn, $qry);
if (!$que1) {
    echo "not inserted";
    header('Location: add_category.php');
} else {
    header('Location: see_categories.php');
}
?>