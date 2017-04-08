<?php
include 'connect_my_sql_db.php';

$qry = "DELETE FROM product WHERE prod_id=".$_GET['prodid'];
echo $qry;
$que1 = mysqli_query($conn, $qry);
if (!$que1) {
    echo "not inserted";
}

header('Location: see_products.php');
?>