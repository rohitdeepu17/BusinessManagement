<?php
include 'session_check_common.php';
include 'connect_my_sql_db.php';
require('fpdf.php');

$billno = $_GET['billno'];

class PDF extends FPDF
{

// Page header
function Header()
{
   // Logo
   $this->Image('MTC.png',10,6,30);
   // Arial bold 15
   $this->SetFont('Arial','B',15);
   // Move to the right
   $this->Cell(80);
   // Title
   $this->Cell(30,10,'Invoice',1,0,'C');
   // Line break
   $this->Ln(30);
}	

// Load data
function LoadData($file)
{
   // Read file lines
   $lines = file($file);
   $data = array();
   foreach($lines as $line)
       $data[] = explode(';',trim($line));
   return $data;
}

// Better table
function ImprovedTable($header, $billno, $conn)
{
$this->Cell(20,6,"Bill No.");
$this->Cell(15,6,$billno);




$qry = "SELECT * FROM bill where bill_no=".$billno.";";
$res = mysqli_query($conn, $qry);
$custid = null;
$billamount = null;
$billdiscount = null;
$paidamount = null;
$billdate = null;

$custname = null;
$custfathername = null;
$custaddress = null;
$custphone = null;

while($data = mysqli_fetch_assoc($res)){
	$custid = $data['cust_id'];
	$billamount = $data['amount'];
	$billdiscount = $data['discount'];
	$paidamount = $data['paid_amount'];
	$billdate = $data['bill_date'];
}
date_default_timezone_set("Asia/Kolkata");
// Create a new DateTime object
$dateinnewformat = DateTime::createFromFormat('Y-m-d', $billdate);

$this->Cell(25,6,"Bill Date: ");
$this->Cell(25,6,$dateinnewformat->format('d-m-Y'));
$this->Ln();

if($custid){
	$qry = "SELECT * FROM customer where cust_id=".$custid.";";
	$res = mysqli_query($conn, $qry);
	while($data = mysqli_fetch_assoc($res)){
		$custname = $data['cust_name'];
		$custfathername = $data['father_name'];
		$custaddress = $data['address'];
		$custphone = $data['phone'];
	}
	$this->Cell(40,6,"Customer Name: ");
	$this->Cell(40,6,$custname);
	$this->Cell(35,6,"Father's Name: ");
	$this->Cell(40,6,$custfathername);
	$this->Ln();
	$this->Cell(40,6,"Address: ");
	$this->Cell(40,6,$custaddress);
	$this->Cell(40,6,"Phone No: ");
	$this->Cell(40,6,$custphone);
	$this->Ln(10);
}

// Column widths
$w = array(20, 55, 16, 17, 20, 20, 20, 30);
// Header
for($i=0;$i<count($header);$i++)
   $this->Cell($w[$i],7,$header[$i],1,0,'C');
$this->Ln();
// Data
$row_count = 0;
$total_amount = 0;

$qry = "SELECT * FROM billcontent where bill_no=".$billno.";";
$res = mysqli_query($conn, $qry);
while($data = mysqli_fetch_assoc($res)){
   $row_count = $row_count + 1;
   $this->Cell($w[0],6,number_format($row_count).".",'LR', 0, 'R');
   
    $qry1 = "SELECT prod_name, cat_id FROM product WHERE prod_id = ".$data['prod_id'].";";
	//echo $qry1;
	$res1 = mysqli_query($conn, $qry1);
	$prodname = null;
	$catid = null;
	while($data1 = mysqli_fetch_assoc($res1)){
		$prodname = $data1['prod_name'];
		$catid = $data1['cat_id'];
	}
	
	$qry2 = "SELECT cat_hsn_code FROM category WHERE cat_id = '".$catid."';";
	$res2 = mysqli_query($conn, $qry2);
	$hsncode = null;
	while($data2 = mysqli_fetch_assoc($res2)){
		$hsncode = $data2['cat_hsn_code'];
	}
	
   $this->Cell($w[1],6,$prodname,'LR');
   //$this->Cell($w[2],6,number_format($data['qty']),'LR',0,'R');
   $this->Cell($w[2],6,$hsncode,'LR',0,'R');
   $this->Cell($w[3],6,$data['qty'],'LR',0,'R');
   //$this->Cell($w[3],6,number_format($data['unit_price']),'LR',0,'R');
   
   $amount = $data['qty']*$data['unit_price'];
   $total_amount = $total_amount + $amount;
   
   $base_price = $amount/(1+$data['sgst_percent']/100+$data['cgst_percent']/100);
   $sgst_amount = ($data['sgst_percent']*$base_price)/100;
   $cgst_amount = ($data['cgst_percent']*$base_price)/100;
   //$this->Cell($w[5],6,$data['sgst_percent'],'LR',0,'R');
   //$this->Cell($w[4],6,$data['unit_price'],'LR',0,'R');
   $this->Cell($w[4],6,number_format((float)$base_price, 2, '.', ''),'LR',0,'R');
   $this->Cell($w[5],6,number_format((float)$sgst_amount, 2, '.', ''),'LR',0,'R');
   //$this->Cell($w[5],6,'@'.$data['sgst_percent'].'%='.$sgst_amount,'LR',0,'R');
   //$this->Cell($w[6],6,$data['cgst_percent'],'LR',0,'R');
   $this->Cell($w[5],6,number_format((float)$cgst_amount, 2, '.', ''),'LR',0,'R');
   //$this->Cell($w[4],6,number_format($amount),'LR',0,'R');
   $this->Cell($w[7],6,$amount,'LR',0,'R');
   $this->Ln();
}
// Closing line
$this->Cell(array_sum($w),0,'','T');
$this->Ln();
$this->Cell($w[0],6,"Total Amount","L");
$this->Cell(array_sum($w)-$w[0], 6, $total_amount,'R', 0, 'R');
$this->Ln();
$this->Cell($w[0],6,"Bill Discount","L");
$this->Cell(array_sum($w)-$w[0], 6, $billdiscount,'R', 0, 'R');
$this->Ln();
$this->Cell($w[0],6,"Paid Amount","L");
$this->Cell(array_sum($w)-$w[0], 6, $paidamount,'R', 0, 'R');
$this->Ln();
$this->Cell($w[0],6,"Balance","L");
$this->Cell(array_sum($w)-$w[0], 6, $total_amount-$billdiscount-$paidamount,'R', 0, 'R');
$this->Ln();
// Closing line
$this->Cell(array_sum($w),0,'','T');
}
}

$pdf = new PDF();
// Column headings
$header = array('Sr. No.', 'Product Name', 'HSN', 'Qty', 'Price', 'SGST', 'CGST', 'Amount');
// Data loading
$pdf->SetFont('Arial','',14);
$pdf->AddPage();
$pdf->ImprovedTable($header, $billno, $conn);
$pdf->Output("", "Bill_".$billno.".pdf", false);
?>