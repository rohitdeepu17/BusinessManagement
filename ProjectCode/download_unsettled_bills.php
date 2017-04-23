<?php
include 'session_check_common.php';
include 'connect_my_sql_db.php';
require('fpdf.php');
date_default_timezone_set("Asia/Kolkata");
//$billno = $_GET['billno'];

class PDF extends FPDF
{

// Page header
function Header()
{
   // Arial bold 15
   $this->SetFont('Arial','B',10);
   // Title
   $this->Cell(30,5,date("Y-m-d",time()),1,0,'C');
   // Line break
   $this->Ln(7);
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
//date_default_timezone_set("Asia/Kolkata");
// Create a new DateTime object
//$dateinnewformat = DateTime::createFromFormat('Y-m-d', $billdate);

//$this->Cell(25,6,$dateinnewformat->format('d-m-Y'));

// Column widths
$w = array(15, 45, 45, 30, 30, 20, 20, 20, 20, 20);
//height
$h = 4;
// Header
for($i=0;$i<count($header);$i++)
   $this->Cell($w[$i],5,$header[$i],1,0,'C');
$this->Ln();
// Data
$row_count = 0;
$total_amount = 0;
$total_balance = 0;
$total_paid = 0;
$total_discount = 0;

$qry = "SELECT * FROM bill WHERE (amount-paid_amount-discount) > 0.10;";
$res = mysqli_query($conn, $qry);
while($data = mysqli_fetch_assoc($res)){
   $row_count = $row_count + 1;
   $this->Cell($w[0],$h,number_format($data['bill_no']).".",'LR', 0, 'R');
   
    $qry1 = "SELECT * FROM customer WHERE cust_id = ".$data['cust_id'].";";
	//echo $qry1;
	$res1 = mysqli_query($conn, $qry1);
	$custname = null;
	$address = null;
	$father = null;
	$phone = null;
	while($data1 = mysqli_fetch_assoc($res1)){
		$custname = $data1['cust_name'];
		$father = $data1['father_name'];
		$address = $data1['address'];
		$phone = $data1['phone'];
	}
	
   $this->Cell($w[1],$h,$custname,'LR');
   $this->Cell($w[2],$h,$father,'LR');
   $this->Cell($w[3],$h,$address,'LR');
   $this->Cell($w[4],$h,$phone,'LR');
   
   date_default_timezone_set("Asia/Kolkata");
   $dateinnewformat = DateTime::createFromFormat('Y-m-d', $data['bill_date']);
   $this->Cell($w[5],$h,$dateinnewformat->format('d-m-Y'),'LR',0,'R');
   $this->Cell($w[6],$h,$data['amount'],'LR',0,'R');
   $this->Cell($w[7],$h,$data['discount'],'LR',0,'R');
   $this->Cell($w[8],$h,$data['paid_amount'],'LR',0,'R');
   $balance = $data['amount']-$data['paid_amount']-$data['discount'];
   $total_balance += $balance;
   $total_amount += $data['amount'];
   $total_paid += $data['paid_amount'];
   $total_discount += $data['discount'];
   $this->Cell($w[9],$h,$balance,'LR',0,'R');
   $this->Ln();
}
// Closing line
$this->Cell(array_sum($w),0,'','T');
$this->Ln();
$this->Cell($w[0],$h,"Total Amount","L");
$this->Cell(array_sum($w)-$w[0], $h, $total_amount,'R', 0, 'R');
$this->Ln();
$this->Cell($w[0],$h,"Total Discount","L");
$this->Cell(array_sum($w)-$w[0], $h, $total_discount,'R', 0, 'R');
$this->Ln();
$this->Cell($w[0],$h,"Total Paid","L");
$this->Cell(array_sum($w)-$w[0], $h, $total_paid,'R', 0, 'R');
$this->Ln();
$this->Cell($w[0],$h,"Total Balance","L");
$this->Cell(array_sum($w)-$w[0], $h, $total_balance,'R', 0, 'R');
$this->Ln();
$this->Cell($w[0],$h,"No. of Bills","L");
$this->Cell(array_sum($w)-$w[0], $h, $row_count,'R', 0, 'R');
$this->Ln();
// Closing line
$this->Cell(array_sum($w),0,'','T');
}
}

$pdf = new PDF();
// Column headings
$header = array('Bill No.', 'Customer Name', 'Father Name', 'Village', 'Phone', 'Bill Date', 'Amount', 'Discount', 'Paid', 'Balance');
// Data loading
$pdf->SetFont('Arial','',10);
$pdf->AddPage('L');
$pdf->ImprovedTable($header, $billno, $conn);
//Need to look better logic to take understandable date/time
$pdf->Output("", "UnsettledBills_".time().".pdf", false);
?>