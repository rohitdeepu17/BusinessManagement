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
function ImprovedTable($header, $datadoc, $billno, $conn)
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
$w = array(20, 65, 30, 30, 30);
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
   
    $qry1 = "SELECT prod_name FROM product WHERE prod_id = ".$data['prod_id'].";";
	//echo $qry1;
	$res1 = mysqli_query($conn, $qry1);
	$prodname = null;
	while($data1 = mysqli_fetch_assoc($res1)){
		$prodname = $data1['prod_name'];
	}
	
   $this->Cell($w[1],6,$prodname,'LR');
   //$this->Cell($w[2],6,number_format($data['qty']),'LR',0,'R');
   $this->Cell($w[2],6,$data['qty'],'LR',0,'R');
   //$this->Cell($w[3],6,number_format($data['unit_price']),'LR',0,'R');
   $this->Cell($w[3],6,$data['unit_price'],'LR',0,'R');
   $amount = $data['qty']*$data['unit_price'];
   $total_amount = $total_amount + $amount;
   //$this->Cell($w[4],6,number_format($amount),'LR',0,'R');
   $this->Cell($w[4],6,$amount,'LR',0,'R');
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
$header = array('Sr. No.', 'Product Name', 'Quantity', 'Unit Price', 'Amount');
// Data loading
$data = $pdf->LoadData('countries.txt');
$pdf->SetFont('Arial','',14);
$pdf->AddPage();
$pdf->ImprovedTable($header,$data, $billno, $conn);
$pdf->Output();
?>