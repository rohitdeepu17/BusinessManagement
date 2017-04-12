<?php
include 'connect_my_sql_db.php';

$qry = "SELECT * FROM billcontent where bill_no=".$_GET['billno'].";";
$res = mysqli_query($conn, $qry);
while($data = mysqli_fetch_assoc($res)){
	//echo "Hello".$data['prod_id'];	
	$qry2 = "UPDATE product SET stock = stock + ".$data['qty']. 
               " WHERE prod_id = ".$data['prod_id'].";" ;
    //echo $qry2;
    $res2 = mysqli_query($conn, $qry2);
    if(!$res2)
        echo "stock not updated";
}

$qry = "DELETE FROM bill WHERE bill_no=".$_GET['billno'];
echo $qry;
$que1 = mysqli_query($conn, $qry);
if (!$que1) {
    echo "not deleted";
}

header('Location: see_bills.php');
?>