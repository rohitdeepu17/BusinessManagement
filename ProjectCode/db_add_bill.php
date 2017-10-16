<?php
include 'connect_my_sql_db.php';

$cname = $_POST['cname'];
$cid  	= $_POST['cid'];
$fname   	= $_POST['fname'];
$caddress = $_POST['caddress'];
$cphone = $_POST['cphone'];
$cdetails 		= $_POST['cdetails'];
$bdate = $_POST['bdate'];
$bamount = $_POST['total_amount'];
$bdiscount = $_POST['total_discount'];
$bpaid = $_POST['total_paid'];
$bcopy = $_POST['ccopy'];
$bpage = $_POST['cpage'];
$profit = 0.0;

print_r($_POST); 
echo $_POST['cid'];

if($_POST['cid'])
	echo "cid not null and cid = ".$cid;
else
	echo "cid is null";
echo $cname;
echo $bdate;

$categories = $_POST['categories'];
$products = $_POST['products'];
$qtys = $_POST['qty'];
$unitprices = $_POST['unitprice'];
$calculatedprices = $_POST['calculatedprice'];
$sgst_percentages = $_POST['sgst'];
$cgst_percentages = $_POST['cgst'];

if(empty($products)) 
{
	echo("You didn't select any $products.");
	header('Location: add_bill.php');
} 
else
{
	if(!strcmp($cid, "N.A.")){
		echo "new customer";
		$qry = "INSERT INTO customer(cust_name, father_name, address, phone, other_details)
			    values('$cname', '$fname', '$caddress', 
			    	   '$cphone', '$cdetails')";
		echo $qry;
		$que1 = mysqli_query($conn, $qry);
		if (!$que1) {
    		echo "not inserted into customers table";
    		//header('Location: add_bill.php');
		}else{
			//fetch recently added customer id from table
			$res = mysqli_query($conn, "SELECT MAX(cust_id) FROM customer;");
			if($res)
				echo "result not null";
			else
				echo "result is null";
			while($data = mysqli_fetch_array($res)){
				$cid = $data[0];
				echo "hey data = ".$data[0];
			}
			echo "cid new inserted = ".$cid;
		}
	}else{
		echo "old customer";
	}
	
	
	//add a new bill
	$billno;
	$qry = "INSERT INTO bill(cust_id, bill_date, amount, discount, paid_amount, profit, copy_no, page_no)
			    values('$cid', '$bdate', '$bamount', 
			    	   '$bdiscount', '$bpaid', '$profit', '$bcopy', '$bpage')";
	echo $qry;
	$que1 = mysqli_query($conn, $qry);
	if (!$que1) {
		echo "not inserted into bill table";
		//header('Location: add_bill.php');
	}else{
		//fetch recently added billno from table
		$res = mysqli_query($conn, "SELECT MAX(bill_no) FROM bill;");
		if($res)
			echo "result not null";
		else
			echo "result is null";
		while($data = mysqli_fetch_array($res)){
			$billno = $data[0];
			echo "hey data = ".$data[0];
		}
		echo "bill new inserted = ".$billno;
	}
	
	//insert payment(by cash)
	if($bpaid>0.10){
		$qry = "INSERT INTO salepayment(bill_no, transaction_date, transaction_mode, transaction_amount)
				 values('$billno', '$bdate', 1, '$bpaid')";
		echo $qry;
		$que1 = mysqli_query($conn, $qry);
		if (!$que1) {
			echo "not inserted into salepayment table";
			//header('Location: add_bill.php');
		}
	}
	
	
	$n = count($products);
	for($i=0;$i<$n;$i++){
		echo $categories[$i]." ".$products[$i]." ".$qtys[$i]." ".$unitprices[$i]." ".$calculatedprices[$i]." ".$sgst_percentages[$i]." ".$cgst_percentages[$i]."<br>";
		$qry = "INSERT INTO billcontent(bill_no, prod_id, qty, unit_price, sgst_percent, cgst_percent)
			    values('$billno', '$products[$i]', '$qtys[$i]', '$unitprices[$i]', '$sgst_percentages[$i]', '$cgst_percentages[$i]')";
		echo $qry;
		$que1 = mysqli_query($conn, $qry);
		if (!$que1) {
			echo "not inserted into billcontent";
			//header('Location: add_bill.php');
		}else{
			echo "inserted into billcontent";
			$qry2 = "UPDATE product ". "SET stock = stock - $qtys[$i] ". 
               "WHERE prod_id = $products[$i];" ;
            echo $qry2;
            $res2 = mysqli_query($conn, $qry2);
            if(!$res2)
            	echo "stock not updated";
		}
	}
	header('Location: see_bills.php');
}

//http://www.fpdf.org/
//http://phppot.com/php/php-pdf-generation-using-fpdf/

?>