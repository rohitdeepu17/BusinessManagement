<?php
include 'session_check_common.php';
include 'connect_my_sql_db.php';
require('fpdf.php');
date_default_timezone_set("Asia/Kolkata");

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
function ImprovedTable($header, $conn)
{
// Column widths
$w = array(45, 30, 30, 30, 40, 30, 20, 50);
//height
$h = 4;
// Header
for($i=0;$i<count($header);$i++)
   $this->Cell($w[$i],5,$header[$i],1,0,'C');
$this->Ln();
// Data
$row_count = 0;
$total_amount = 0;
$total_paid = 0;
$total_discount = 0;

$qry = "SELECT * FROM vendor ORDER BY address;";
$total_balance = 0.00;
$res = mysqli_query($conn, $qry);
// Color and font restoration
$this->SetFillColor(216,216,216);
//fill or not
$fill = false;
while($data = mysqli_fetch_assoc($res)){
   $row_count = $row_count + 1;
   $total_balance += $data['balance'];
   $this->Cell($w[0],$h,$data['vendor_name'],'LR', 0, 'L', $fill);
   $this->Cell($w[1],$h,$data['address'],'LR', 0, 'L', $fill);
   $this->Cell($w[2],$h,$data['person_name'],'LR', 0, 'L', $fill);
   $this->Cell($w[3],$h,$data['phone'],'LR', 0, 'L', $fill);
   $this->Cell($w[4],$h,$data['bank_account'],'LR',0,'R', $fill);
   $this->Cell($w[5],$h,$data['ifsc_code'],'LR',0,'R', $fill);
   $this->Cell($w[6],$h,number_format($data['balance']),'LR',0,'R', $fill);
   $this->Cell($w[7],$h,$data['other_details'],'LR',0,'R', $fill);
   //separation line
   $this->Ln();
   $this->Cell(array_sum($w),0,'','T');
   $this->Ln();
   $fill = !$fill;
}
// Closing line
$this->Cell(array_sum($w),0,'','T');
$this->Ln();
$this->Cell($w[0],$h,"Total Balance","L");
$this->Cell(array_sum($w)-$w[0], $h, number_format($total_balance),'R', 0, 'R');
$this->Ln();
$this->Cell($w[0],$h,"No. of Vendors","L");
$this->Cell(array_sum($w)-$w[0], $h, $row_count,'R', 0, 'R');
$this->Ln();
// Closing line
$this->Cell(array_sum($w),0,'','T');
}
}

$pdf = new PDF();
// Column headings
$header = array('Vendor Name', 'Address', 'Person Name', 'Phone', 'Bank Account', 'IFSC Code', 'Balance', 'Other Details');
// Data loading
$pdf->SetFont('Arial','',10);
$pdf->AddPage('L');
$pdf->ImprovedTable($header, $conn);
//Need to look better logic to take understandable date/time
$pdf->Output("", "Vendors_".date("Y-m-d",time()).".pdf", false);
?>