<?php
include 'connect_my_sql_db.php';

$cat_name    = $_POST['cname'];
$cat_details = $_POST['cdetails'];
$qry         = "INSERT INTO category(cat_name,cat_details) values('$cat_name','$cat_details')";
echo $qry;
$que1 = mysqli_query($conn, $qry);
if (!$que1) {
    echo "not inserted";
    header('Location: add_category.php');
} else {
    header('Location: see_categories.php');
}
?>