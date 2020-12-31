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
$w = array(50, 50, 15, 65);
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

$qry = "SELECT P.prod_name, C.cat_name, P.unit_sale_price, P.prod_details FROM product P, category C WHERE P.cat_id = C.cat_id ORDER BY C.cat_id, P.prod_name;";

$res = mysqli_query($conn, $qry);
// Color and font restoration
$this->SetFillColor(216,216,216);
//fill or not
$fill = false;
while($data = mysqli_fetch_assoc($res)){
   $row_count = $row_count + 1;
   $this->Cell($w[0],$h,$data['prod_name'],'LR', 0, 'L', $fill);
   $this->Cell($w[1],$h,$data['cat_name'],'LR', 0, 'L', $fill);
   $this->Cell($w[2],$h,number_format($data['unit_sale_price']),'LR', 0, 'L', $fill);
   $this->Cell($w[3],$h,$data['prod_details'],'LR', 0, 'L', $fill);
   //separation line
   $this->Ln();
   $this->Cell(array_sum($w),0,'','T');
   $this->Ln();
   $fill = !$fill;
}
// Closing line
$this->Cell(array_sum($w),0,'','T');
$this->Ln();
// Closing line
$this->Cell(array_sum($w),0,'','T');
}
}

$pdf = new PDF();
// Column headings
$header = array('Product Name', 'Category', 'Unit SP', 'Product Details');
// Data loading
$pdf->SetFont('Arial','',10);
$pdf->AddPage('L');
$pdf->ImprovedTable($header, $conn);
//Need to look better logic to take understandable date/time
$pdf->Output("", "Vendors_".date("Y-m-d",time()).".pdf", false);
?>