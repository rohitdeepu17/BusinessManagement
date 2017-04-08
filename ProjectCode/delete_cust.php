<?php
include 'connect_my_sql_db.php';

$qry = "DELETE FROM customer WHERE cust_id=".$_GET['custid'];
echo $qry;
$que1 = mysqli_query($conn, $qry);
if (!$que1) {
    echo "not inserted";
}

header('Location: see_customers.php');
?>