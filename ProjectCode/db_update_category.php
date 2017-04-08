<?php
include 'connect_my_sql_db.php';
$cat_id = $_POST['cid'];
$cat_name    = $_POST['cname'];
$cat_details = $_POST['cdetails'];
$qry = "UPDATE category ". "SET cat_name = '$cat_name', "." cat_details = '$cat_details' ". 
               "WHERE cat_id = $cat_id" ;
//$qry = "UPDATE category ". "SET cat_name = '$cat_name' "."WHERE cat_id = $cat_id" ;
echo $qry;
$que1 = mysqli_query($conn, $qry);
if (!$que1) {
    echo "not updated";
}
header('Location: see_categories.php');
?>