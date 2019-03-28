<?php
require('fpdf.php');
// echo ($_GET['ntn']);
// die;
class PDF extends FPDF
{

    function header(){
        $this->Image('logo.png', 10, 20, 60);
    }

    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-33);
        // Arial italic 8
        $this->SetFont('Arial','B',12);
        // Text color in gray
        $this->SetTextColor(128);
        // Page number
        // $this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
        $this->Cell(0, 10, "H-Shippers",0,1,"C");
        $this->SetFont('Arial','B',10);
        $this->Cell(0, 5, "CL-1/1 SaifeeHouse DrZia UdDin Ahmed Road, Opposite ShaheenComplex, Karachi ",0,1,"C");
        $this->Cell(0, 5, "| 021-32212217| 0300-2070848 | ",0,1,"C");
        $this->Cell(0, 5, "| NTN# 8924782-4 | GST# 1200980575537 |",0,1,"C");
        $this->Cell(0, 5, "w  w  w  .  h  s  h  i  p  p  e  r  s  .  c  o  m",0,0,"C", false, 'http://hshippers.com');
    }

}

$pdf = new PDF();
$pdf->AddPage("P", "A4");

/* Starting Billed To Section */
$pdf->SetY(40);
$pdf->SetFont('Arial','B',16);
$pdf->Cell(0, 20, 'Billed To:', 0, 1);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,0,($_GET['company_name']),0,1);
$pdf->SetY(70);
$pdf->SetFont('Arial','',11);
$address = ($_GET['address']);
$pdf->Cell(0,0,$address,0,1);
$pdf->SetY(80);
$pdf->Cell(0,0,'NTN# '.($_GET['ntn']),0,1);
$pdf->SetY(85);
$pdf->Cell(0,0,'STRN# '.($_GET['strn']),0,1);
/* Ending Billed To Section */

/* Starting Invoice Section */
$pdf->SetXY(125, 25);
$pdf->setFillColor(53,72,122); 
$pdf->SetTextColor(255,255,255); 
$pdf->SetFont('Arial','',15);
$pdf->Cell(200,13,'   e-Invoice',0,1,'L',1);
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(125,45);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,0,'Account #',0,0);
$pdf->SetXY(160, 45);
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,0,($_GET['account_id']),0,0);

$pdf->SetXY(125, 53);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,0,'Invoice #',0,0);
$pdf->SetXY(160,53);
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,0,($_GET['invoice_num']),0,0);

$pdf->SetXY(125,61);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,0,'Invoice Date',0,0);
$pdf->SetXY(160, 61);
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,0,date('Y-m-d'),0,0);

$pdf->SetXY(125, 69);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,0,'Time Period',0,0);
$pdf->SetXY(160, 69);
$pdf->SetFont('Arial','',12);
setlocale(LC_CTYPE, 'en_US');
$pdf->Cell(0,0,iconv('UTF-8', 'ASCII//TRANSLIT', ($_GET['date'])." - ".date('Y-m-d')),0,0);
// /* Ending Invoice Section */

// /* Starting Invoice Table Section */
$pdf->SetY(100);
$pdf->setFillColor(53,72,122); 
$pdf->SetTextColor(255,255,255); 
$pdf->SetFont('Arial','B',10);
$pdf->Cell(12,10,' SN ',1,0,'L',1);
$pdf->Cell(60,10,' SERVICE ',1,0,'L',1);
$pdf->Cell(35,10,' QUANTITY ',1,0,'L',1);
$pdf->Cell(35,10,' WEIGHT ',1,0,'L',1);
$pdf->Cell(48,10,' TOTAL ',1,0,'L',1);

$yPos = 110;
$pdf->SetY($yPos);
$pdf->setFillColor(255,255,255); 
$pdf->SetTextColor(0,0,0); 
$pdf->SetFont('Arial','',10);
$pdf->Cell(12,10,'1',1,0,'L',1);
$pdf->Cell(60,10,'Over Night Delivery ',1,0,'L',1);
$pdf->Cell(35,10,($_GET['counts_over_night']),1,0,'L',1);
$pdf->Cell(35,10,($_GET['weight_over_night'] != '' ? $_GET['weight_over_night'] : "0"),1,0,'L',1);
$total = ((float)($_GET['price_over_night']) - ((float)($_GET['counts_over_night']) * (float)($_GET['fuel_charges']))) - ((float)($_GET['price_over_night']) / 100 * (float)($_GET['gst']));
$pdf->Cell(48,10,'Rs.'.$total,1,1,'L',1);
$yPos += 10;

$pdf->SetY($yPos);
$pdf->setFillColor(255,255,255); 
$pdf->SetTextColor(0,0,0); 
$pdf->SetFont('Arial','',10);
$pdf->Cell(12,10,'2',1,0,'L',1);
$pdf->Cell(60,10,'Same Day Delivery ',1,0,'L',1);
$pdf->Cell(35,10,($_GET['counts_same_day']),1,0,'L',1);
$pdf->Cell(35,10,($_GET['weight_same_day'] != '' ? $_GET['weight_same_day'] : "0"),1,0,'L',1);
$total_same_day = ((float)($_GET['price_same_day']) - ((float)($_GET['counts_same_day']) * (float)($_GET['fuel_charges']))) - ((float)($_GET['price_same_day']) / 100 * (float)($_GET['gst']));
$pdf->Cell(48,10,'Rs.'.$total_same_day,1,1,'L',1);
$yPos += 10;

$pdf->SetY($yPos);
$pdf->setFillColor(255,255,255); 
$pdf->SetTextColor(0,0,0); 
$pdf->SetFont('Arial','',10);
$pdf->Cell(12,10,'3',1,0,'L',1);
$pdf->Cell(60,10,'Second Day Delivery ',1,0,'L',1);
$pdf->Cell(35,10,($_GET['counts_second_day']),1,0,'L',1);
$pdf->Cell(35,10,($_GET['weight_second_day'] != "" ? $_GET['weight_second_day'] : "0"),1,0,'L',1);
$total_second_day = ((float)($_GET['price_second_day']) - ((float)($_GET['counts_second_day']) * (float)($_GET['fuel_charges']))) - ((float)($_GET['price_second_day']) / 100 * (float)($_GET['gst']));
$pdf->Cell(48,10,'Rs.'.$total_second_day,1,1,'L',1);
$yPos += 10;

$pdf->SetY($yPos);
$pdf->setFillColor(255,255,255); 
$pdf->SetTextColor(0,0,0); 
$pdf->SetFont('Arial','',10);
$pdf->Cell(12,10,'4',1,0,'L',1);
$pdf->Cell(60,10,'Over Land Delivery ',1,0,'L',1);
$pdf->Cell(35,10,($_GET['counts_over_land']),1,0,'L',1);
$pdf->Cell(35,10,($_GET['weight_over_land'] != "" ? $_GET['weight_over_land'] : "0"),1,0,'L',1);
$total_over_land = ((float)($_GET['price_over_land']) - ((float)($_GET['counts_over_land']) * (float)($_GET['fuel_charges']))) - ((float)($_GET['price_over_land']) / 100 * (float)($_GET['gst']));
$pdf->Cell(48,10,'Rs.'.$total_over_land,1,1,'L',1);
$yPos += 10;

$pdf->SetY($yPos);
$pdf->setFillColor(255,255,255); 
$pdf->SetTextColor(0,0,0); 
$pdf->SetFont('Arial','',10);
$pdf->Cell(12,10,'',0,0,'L',1);
$pdf->Cell(60,10,'',0,0,'L',1);
$pdf->Cell(70,10,' Fuel Charges ',1,0,'L',1);
$fuel = ((float)($_GET['counts_over_land']) + (float)($_GET['counts_over_night']) + (float)($_GET['counts_second_day']) + (float)($_GET['counts_same_day'])) * (float)($_GET['fuel_charges']);
$pdf->Cell(48,10,'Rs.'.$fuel,1,1,'L',1);
$yPos += 10;

$pdf->SetY($yPos);
$pdf->setFillColor(255,255,255); 
$pdf->SetTextColor(0,0,0); 
$pdf->SetFont('Arial','',10);
$pdf->Cell(12,10,'',0,0,'L',1);
$pdf->Cell(60,10,'',0,0,'L',1);
$pdf->Cell(70,10,' GST ('.($_GET['gst']).'%) ',1,0,'L',1);
$gst = ((float)($_GET['price_same_day']) + (float)($_GET['price_over_night']) + (float)($_GET['price_second_day']) + (float)($_GET['price_over_land'])) / 100 * (float)($_GET['gst']);
$pdf->Cell(48,10,'Rs.'.$gst,1,1,'L',1);
$yPos += 10;

$pdf->SetY($yPos);
$pdf->SetFont('Arial','',10);
$pdf->Cell(12,10,'',0,0,'L',1);
$pdf->Cell(60,10,'',0,0,'L',1);
$pdf->SetFont('Arial','B',10);
$pdf->setFillColor(53,72,122); 
$pdf->SetTextColor(255,255,255);
$pdf->Cell(70,10,' GRAND TOTAL ',1,0,'L',1);
$grand_total = (float)($_GET['price_same_day']) + (float)($_GET['price_over_night']) + (float)($_GET['price_second_day']) + (float)($_GET['price_over_land']);
$pdf->Cell(48,10,'Rs.'.$grand_total,1,1,'L',1);
$yPos += 10;

/* Ending Total Section */
$height = $pdf->h;
$pdf->SetY($yPos+30);
$image1 = "hships.PNG";
$pdf->Cell( 40, 40, $pdf->Image($image1, $pdf->GetX(), $pdf->GetY(), 120), 0, 0, 'L', false );

$pdf->Output();
?>
