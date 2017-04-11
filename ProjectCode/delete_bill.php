<?php
include 'connect_my_sql_db.php';

$qry = "DELETE FROM bill WHERE bill_no=".$_GET['billno'];
echo $qry;
$que1 = mysqli_query($conn, $qry);
if (!$que1) {
    echo "not deleted";
}

header('Location: see_bills.php');
?>