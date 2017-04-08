<?php
include 'connect_my_sql_db.php';

$qry = "DELETE FROM category WHERE cat_id=".$_GET['catid'];
echo $qry;
$que1 = mysqli_query($conn, $qry);
if (!$que1) {
    echo "not inserted";
}

header('Location: see_categories.php');
?>