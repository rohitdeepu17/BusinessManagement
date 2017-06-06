<?php
include 'session_check_common.php';
include 'connect_my_sql_db.php';
require('fpdf.php');
date_default_timezone_set("Asia/Kolkata");

$vendorid = $_GET['vendorid'];

$vendorname = null;
$qry1 = "SELECT * FROM vendor WHERE vendor_id = $vendorid;";
$res1 = mysqli_query($conn, $qry1);
while($data1 = mysqli_fetch_assoc($res1)){
	$vendorname = $data1['vendor_name'];
}


function printTransactionMode($transmode = 1) {
	switch($transmode){
		case 1:
			return "Cash";
			break;			//although break has no meaning after return
		case 2:
			return "Cheque";
			break;
		case 3:
			return "NEFT";
			break;
		case 4:
			return "Return";
			break;
		case 5:
			return "Discount";
			break;
		case 6:
			return "Purchase";
			break;
		default:
			return "Cash";
	}
}
		
function printTransactionType($transtype = 1) {
	switch($transtype){
		case 1:
			return "C";
			break;			//although break has no meaning after return
		case 2:
			return "D";
			break;
		default:
			return "C";
	}
}

class PDF extends FPDF
{

// Page header
function Header()
{
   // Arial bold 15
   $this->SetFont('Arial','B',15);
   // Move to the right
   $this->Cell(80);
   // Title
   $this->Cell(40,10,'Transactions',1,0,'C');
   // Line break
   $this->Ln(15);
}	

function ImprovedTable($header, $vendorid, $conn){
$vendorname = null;
$vendoraddress = null;
$qry1 = "SELECT * FROM vendor WHERE vendor_id = $vendorid;";
$res1 = mysqli_query($conn, $qry1);
while($data1 = mysqli_fetch_assoc($res1)){
	$vendorname = $data1['vendor_name'];
	$vendoraddress = $data1['address'];
}

// Color and font restoration
$this->SetFillColor(216,216,216);
// Column widths
$w = array(30, 10, 30, 30, 30, 100);
//height
$h = 6;

$this->Cell(40, $h, "Vendor Name : ");
$this->Cell(50, $h, $vendorname);
$this->Cell(30, $h, "Address : ");
$this->Cell(30, $h, $vendoraddress);

$this->Ln();
$this->Ln();

// Header
for($i=0;$i<count($header);$i++)
   $this->Cell($w[$i],5,$header[$i],1,0,'C');
$this->Ln();
// Data
$row_count = 0;

$qry = "SELECT * FROM vendor_transaction WHERE vendor_id = $vendorid ORDER BY transaction_date;";
$res = mysqli_query($conn, $qry);

//fill or not
$fill = false;
$balance = 0.00;
while($data = mysqli_fetch_assoc($res)){
   $row_count = $row_count + 1;
   if($data['transaction_type']==1)		//credit
			$balance-=$data['transaction_amount'];
	else
			$balance+=$data['transaction_amount'];
   $this->Cell($w[0],$h,$data['transaction_date'],'LR', 0, 'L', $fill);
   $this->Cell($w[1],$h,printTransactionType($data['transaction_type']),'LR',0,'R', $fill);
   $this->Cell($w[2],$h,printTransactionMode($data['transaction_mode']),'LR', 0, 'L', $fill);
   $this->Cell($w[3],$h,number_format($data['transaction_amount']),'LR', 0, 'R', $fill);
   $this->Cell($w[4],$h,number_format($balance),'LR',0,'R', $fill);
   $this->Cell($w[5],$h,$data['transaction_details'],'LR',0,'R', $fill);
   //separation line
   $this->Ln();
   $this->Cell(array_sum($w),0,'','T');
   $this->Ln();
   $fill = !$fill;
}

}


}

$pdf = new PDF();
// Column headings
$header = array('Tr Date', 'C/D', 'Tr Mode', 'Tr Amount', 'Balance', 'Tr Details');
// Data loading
$pdf->SetFont('Arial','',14);
$pdf->AddPage('L');
$pdf->ImprovedTable($header, $vendorid, $conn);
$pdf->Output("", "VTransactions_".$vendorname."_".date("Y-m-d",time()).".pdf", false);
?>