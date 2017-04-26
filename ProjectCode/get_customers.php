<?php 
include 'connect_my_sql_db.php';
$sql="SELECT * FROM customer 
        WHERE cust_name LIKE '%".$_REQUEST['term']."%'";

$cust_name = array();
$father_name = array();
$result=mysqli_query($conn, $sql);
while($row=mysqli_fetch_assoc($result)) 
{ 
$title=$row['cust_name']; 
$url=$row['father_name']; 
$posts[] = array('name'=> $title, 'fname'=> $url, 'address'=> $row['address'], 'phone'=> $row['phone'], 'custid'=> $row['cust_id'],
        'details'=> $row['other_details']);
} 
echo json_encode($posts);
?>