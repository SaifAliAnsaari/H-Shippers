<?php
require('fpdf.php');
require('db.php');

$client = $_GET['client'];
$month = $_GET['month'];
$hit_from = $_GET['hit_from'];
$year = date('Y');

$query_string = ($hit_from == 'admin' ? $client : "(Select id from clients where client_login_session = '$client')");

$data = [];
$sql = "SELECT ntn, strn, username, company_name, poc_name, address, (Select Count(*) from consignment_client where customer_id = $query_string AND Month(booking_date) = $month AND Year(booking_date) = $year AND consignment_service_type = 1) as counts_same_day, (Select SUM(consignment_weight) from consignment_client where customer_id = $query_string AND Month(booking_date) = $month AND Year(booking_date) = $year AND consignment_service_type = 1) as weight_same_day, (Select Sum(sub_total) from consignment_client where customer_id = $query_string AND Month(booking_date) = $month AND Year(booking_date) = $year AND consignment_service_type = 1) as sub_price_same_day, (Select Sum(total_price) from consignment_client where customer_id = $query_string AND Month(booking_date) = $month AND Year(booking_date) = $year AND consignment_service_type = 1) as price_same_day, (Select Count(*) from consignment_client where customer_id = $query_string AND Month(booking_date) = $month AND Year(booking_date) = $year AND consignment_service_type = 2) as counts_over_night, (Select SUM(consignment_weight) from consignment_client where customer_id = $query_string AND Month(booking_date) = $month AND Year(booking_date) = $year AND consignment_service_type = 2) as weight_over_night, (Select Sum(sub_total) from consignment_client where customer_id = $query_string AND Month(booking_date) = $month AND Year(booking_date) = $year AND consignment_service_type = 2) as sub_price_over_nigth, (Select Sum(total_price) from consignment_client where customer_id = $query_string AND Month(booking_date) = $month AND Year(booking_date) = $year AND consignment_service_type = 2) as price_over_night, (Select Count(*) from consignment_client where customer_id = $query_string AND Month(booking_date) = $month AND Year(booking_date) = $year AND consignment_service_type = 3) as counts_second_day, (Select SUM(consignment_weight) from consignment_client where customer_id = $query_string AND Month(booking_date) = $month AND Year(booking_date) = $year AND consignment_service_type = 3) as weight_second_day, (Select Sum(sub_total) from consignment_client where customer_id = $query_string AND Month(booking_date) = $month AND Year(booking_date) = $year AND consignment_service_type = 3) as sub_price_second_day, (Select Sum(total_price) from consignment_client where customer_id = $query_string AND Month(booking_date) = $month AND Year(booking_date) = $year AND consignment_service_type = 3) as price_second_day,(Select Count(*) from consignment_client where customer_id = $query_string AND Month(booking_date) = $month AND Year(booking_date) = $year AND consignment_service_type = 4) as counts_over_land, (Select SUM(consignment_weight) from consignment_client where customer_id = $query_string AND Month(booking_date) = $month AND Year(booking_date) = $year AND consignment_service_type = 4) as weight_over_land, (Select Sum(sub_total) from consignment_client where customer_id = $query_string AND Month(booking_date) = $month AND Year(booking_date) = $year AND consignment_service_type = 4) as sub_price_over_land, (Select Sum(total_price) from consignment_client where customer_id = $query_string AND Month(booking_date) = $month AND Year(booking_date) = $year AND consignment_service_type = 4) as price_over_land, (Select SUM(fuel_charge) from consignment_client where customer_id = $query_string AND Month(booking_date) = $month AND Year(booking_date) = $year) as fuel_charges, (Select SUM(gst_charge) from consignment_client where customer_id = $query_string AND Month(booking_date) = $month AND Year(booking_date) = $year) as total_tax, (Select tax from billing where customer_id = $query_string) as gst, (Select id from billing where customer_id = $query_string) as account_id, (SELECT Date(created_at) FROM `clients` WHERE id = $query_string) as date, (Select invoice_num from invoices_generated where client_id = $query_string AND month = $month) as invoice_num from clients WHERE id = $query_string";
$stmt = $conn->prepare($sql);
// $stmt->bind_param();
$stmt->execute();
$stmt->bind_result($ntn, $strn, $username, $company_name, $poc_name, $address, $counts_same_day, $weight_same_day, $sub_price_same_day, $price_same_day, $counts_over_night, $weight_over_night, $sub_price_over_nigth, $price_over_night, $counts_second_day, $weight_second_day, $sub_price_second_day, $price_second_day, $counts_over_land, $weight_over_land, $sub_price_over_land, $price_over_land, $fuel_charges, $total_tax, $gst, $account_id, $date, $invoice_num);
$reports = [];
while($stmt->fetch()){
    $reports = [ "ntn" => $ntn, "strn" => $strn, "username" => $username, "company_name" => $company_name, "poc_name" => $poc_name, "address" => $address, "counts_same_day" => $counts_same_day, "weight_same_day" => $weight_same_day, 'sub_price_same_day' => $sub_price_same_day, 'price_same_day' => $price_same_day, 'counts_over_night' => $counts_over_night, 'weight_over_night' => $weight_over_night, 'sub_price_over_nigth' => $sub_price_over_nigth, 'price_over_night' => $price_over_night, 'counts_second_day' => $counts_second_day, 'weight_second_day' => $weight_second_day, 'sub_price_second_day' => $sub_price_second_day, 'price_second_day' => $price_second_day, 'counts_over_land' => $counts_over_land, 'weight_over_land' => $weight_over_land, 'sub_price_over_land' => $sub_price_over_land, 'price_over_land' => $price_over_land, 'fuel_charges' => $fuel_charges, 'total_tax' => $total_tax, 'gst' => $gst, 'account_id' => $account_id, 'date' => $date, 'invoice_num' => $invoice_num];
}
$data["report"] = $reports;
$stmt->close();
unset($stmt);

$sql = "SELECT id, (SELECT city_short from pickup_delivery where LOWER(city_name) = LOWER(cc.origin_city)) as origin_city, booking_date, cnic, (SELECT city_short from pickup_delivery where LOWER(city_name) = LOWER(cc.consignment_dest_city)) as consignment_dest_city, consignment_service_type, consignment_weight, consignment_pieces, sub_total, fuel_charge, gst_charge, total_price from consignment_client as cc WHERE Month(booking_date) = $month AND Year(booking_date) = $year AND customer_id = $query_string"; 
$stmt = $conn->prepare($sql);
$stmt->execute();
$stmt->bind_result($id, $origin_city, $booking_date, $cnic, $consignment_dest_city, $consignment_service_type, $consignment_weight, $consignment_pieces, $sub_total, $fuel_charge, $gst_charge, $total_price);
$content = [];
while($stmt->fetch()){
    $content[] = [ "id" => $id, "origin_city" => $origin_city, "booking_date" => $booking_date, "cnic" => $cnic, "consignment_dest_city" => $consignment_dest_city, "consignment_service_type" => $consignment_service_type, "consignment_weight" => $consignment_weight, "consignment_pieces" => $consignment_pieces, 'sub_total' => $sub_total, 'fuel_charge' => $fuel_charge, 'gst_charge' => $gst_charge, 'total_price' => $total_price];
}
$data["content"] = $content;
$stmt->close();
unset($stmt);
//echo '<pre>'; print_r($data['content']); die;



class PDF extends FPDF
{
    public $data;
    public $month;

    function __construct($data, $month){
        parent::__construct();
        $this->data = $data;
        $this->month = $month;
    }

    function header($summary=false){

        $this->Image('logo.png', 10, 10, 60);
        $this->SetDrawColor(251,213,54); 
        $this->Line(15, 27.5, 70, 27.5);
        
        $this->SetXY(125, 10);
        $this->setFillColor(53,72,122); 
        $this->SetTextColor(255,255,255);  
        $this->SetFont('Arial','',15);
        $this->Cell(200,13,'   e-Invoice',0,1,'L',1);
        $this->SetTextColor(53,72,122);
        $this->SetXY(125,30);
        $this->SetFont('Arial','B',12);
        $this->Cell(0,0,'Account #',0,0);
        $this->SetXY(160, 30);
        $this->SetFont('Arial','',12);
        $this->Cell(0,0,($this->data['report']['account_id'] ? $this->data['report']['account_id'] : ''),0,0);

        $this->SetXY(125, 37);
        $this->SetFont('Arial','B',12);
        $this->Cell(0,0,'Invoice #',0,0);
        $this->SetXY(160,37);
        $this->SetFont('Arial','',12);
        $this->Cell(0,0,($this->data['report']['invoice_num'] ? $this->data['report']['invoice_num'] : ''),0,0);

        $this->SetXY(125,44);
        $this->SetFont('Arial','B',12);
        $this->Cell(0,0,'Invoice Date',0,0);
        $this->SetXY(160, 44);
        $this->SetFont('Arial','',12);
        $this->Cell(0,0,date('y/m/d'),0,0);

        $this->SetXY(125, 51);
        $this->SetFont('Arial','B',12);
        $this->Cell(0,0,'Time Period',0,0);
        $this->SetXY(160, 51);
        $this->SetFont('Arial','',12);
        setlocale(LC_CTYPE, 'en_US');
        $this->Cell(0,0,iconv('UTF-8', 'ASCII//TRANSLIT', date('1/'.$this->month.'/Y')." - ".date('t/'.$this->month.'/Y')),0,0);

        if($summary){
            $this->SetXY(125,58);
            $this->SetFont('Arial','B',12);
            $this->Cell(0,0,'Itemized Report',0,0);
            $this->SetXY(161, 58);
            $this->SetFont('Arial','',12);
            $pageStart = $this->PageNo()-1;
            $endPage = "{nb}";
            // $itemized = $pageStart."/".$endPage;
            $this->Cell(0, 0, $pageStart."/".$endPage, 0, 0, '');
            
            $this->SetTextColor(53,72,122); 
            $this->SetXY(10, 22);
            $this->SetFont('Arial','B',13);
            $this->Cell(65, 20, 'Got mail? We can deliver!', 0, 1, 'C');

            $this->SetXY(10, 37);
            $this->SetFont('Arial','B',12);
            $this->Cell(0, 20, 'Client: '.($this->data['report']['company_name'] ? $this->data['report']['company_name'] : ''), 0, 1);
            
            $this->SetXY(10, 50);
            $this->SetFont('Arial','',10);
            $this->MultiCell(80, 5, ($this->data['report']['address'] ? $this->data['report']['address'] : '') );
            
            $this->SetY(65);
            $this->setFillColor(53,72,122); 
            $this->SetTextColor(255,255,255); 
            $this->SetDrawColor(255,255,255); 
            $this->SetFont('Arial','B',8);
            $this->Cell(10,7,'SN',1,0,'C',1);
            $this->Cell(15,7,'Origin',1,0,'C',1);
            $this->Cell(20,7,'Tracking No.',1,0,'C',1);
            $this->Cell(15,7,'Dest',1,0,'C',1);
            $this->Cell(20,7,'Booking Date',1,0,'C',1);
            $this->Cell(20,7,'Services',1,0,'C',1);
            $this->Cell(15,7,'Weight',1,0,'C',1);
            $this->Cell(15,7,'Pieces',1,0,'C',1);
            $this->Cell(15,7,'Rates',1,0,'C',1);
            $this->Cell(15,7,'Fuel',1,0,'C',1);
            $this->Cell(15,7,'Gst',1,0,'C',1);
            $this->Cell(15,7,'Amount',1,0,'C',1);
        }else{
            $this->SetTextColor(53,72,122); 
            $this->SetXY(10, 22);
            $this->SetFont('Arial','B',13);
            $this->Cell(65, 20, 'Got mail? We can deliver!', 0, 1, 'C');

            $this->SetXY(10, 38);
            $this->SetFont('Arial','B',16);
            $this->Cell(0, 20, 'Billed To:', 0, 1);
            $this->SetXY(10,55);
            $this->SetFont('Arial','B',10);
            $this->Cell(0,0,($this->data['report']['company_name'] ? $this->data['report']['company_name'] : ''),0,1);
            $this->SetY(60);
            $this->SetFont('Arial','',8);
            $address = ($this->data['report']['address'] ? $this->data['report']['address'] : '');
            $this->Cell(0,0,$address,0,1);
            $this->SetY(65);
            $this->Cell(0,0,'NTN# '.($this->data['report']['ntn'] ? $this->data['report']['ntn'] : ''),0,1);
            $this->SetY(70);
            $this->Cell(0,0,'STRN# '.($this->data['report']['strn'] ? $this->data['report']['strn'] : ''),0,1);
        }
       

    }

    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(278);
        // Arial italic 8
        $this->SetFont('Arial','B',12);
        // Text color in gray
        $this->SetTextColor(128);
        // Page number
        $this->Cell(0, 5, "H-Shippers",0,1,"C");
        $this->SetFont('Arial','B',7);
        $this->Cell(0, 3, "CL-1/1 SaifeeHouse DrZia UdDin Ahmed Road, Opposite ShaheenComplex, Karachi ",0,1,"C");
        $this->Cell(0, 3, "| 021-32212217| 0300-2070848 | ",0,1,"C");
        $this->Cell(0, 3, "| NTN# 8924782-4 | GST# 1200980575537 |",0,1,"C");
        $this->Cell(0, 5, "w  w  w  .  h  s  h  i  p  p  e  r  s  .  c  o  m",0,0,"C", false, 'http://hshippers.com');
    }

}

$pdf = new PDF($data, $month);
$pdf->AddPage("P", "A4");
$pdf->AliasNbPages();

// /* Starting Invoice Table Section */
$pdf->SetY(85);
$pdf->setFillColor(53,72,122); 
$pdf->SetTextColor(255,255,255); 
$pdf->SetFont('Arial','B',9);
$pdf->Cell(12,10,' SN ',1,0,'L',1);
$pdf->Cell(60,10,' SERVICE ',1,0,'L',1);
$pdf->Cell(35,10,' QUANTITY ',1,0,'L',1);
$pdf->Cell(35,10,' WEIGHT ',1,0,'L',1);
$pdf->Cell(48,10,' TOTAL ',1,0,'L',1);
$totalFcharges = 0;
$yPos = 95;
$grandTotalPrice = 0;
$sNo = 1;
if($data['report']['counts_over_night']){
    $pdf->SetY($yPos);
    $pdf->setFillColor(255,255,255); 
    $pdf->SetTextColor(0,0,0); 
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(12,10,$sNo++,1,0,'L',1);
    $pdf->Cell(60,10,'Over Night Delivery ',1,0,'L',1);
    $pdf->Cell(35,10,($data['report']['counts_over_night']),1,0,'L',1);
    $pdf->Cell(35,10,($data['report']['weight_over_night'] != "" ? number_format($data['report']['weight_over_night']) : "0"),1,0,'L',1);
    $pdf->Cell(48,10,'Rs.'.number_format($data['report']['sub_price_over_nigth']),1,1,'L',1);
    $yPos += 10;
    $grandTotalPrice += $data['report']['price_over_night'];
}

if($data['report']['counts_same_day']){
    $pdf->SetY($yPos);
    $pdf->setFillColor(255,255,255); 
    $pdf->SetTextColor(0,0,0); 
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(12,10,$sNo++,1,0,'L',1);
    $pdf->Cell(60,10,'Same Day Delivery ',1,0,'L',1);
    $pdf->Cell(35,10,($data['report']['counts_same_day'] ? number_format($data['report']['counts_same_day']) : 0),1,0,'L',1);
    $pdf->Cell(35,10,($data['report']['weight_same_day'] != '' ? number_format($data['report']['weight_same_day']) : "0"),1,0,'L',1);
    $pdf->Cell(48,10,'Rs.'.number_format($data['report']['sub_price_same_day']),1,1,'L',1);
    $yPos += 10;
    $grandTotalPrice += $data['report']['price_same_day'];
}

if($data['report']['counts_second_day']){
    $pdf->SetY($yPos);
    $pdf->setFillColor(255,255,255); 
    $pdf->SetTextColor(0,0,0); 
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(12,10,$sNo++,1,0,'L',1);
    $pdf->Cell(60,10,'Second Day Delivery ',1,0,'L',1);
    $pdf->Cell(35,10,($data['report']['counts_second_day']),1,0,'L',1);
    $pdf->Cell(35,10,($data['report']['weight_second_day'] != "" ? number_format($data['report']['weight_second_day']) : "0"),1,0,'L',1);
    $pdf->Cell(48,10,'Rs.'.number_format($data['report']['sub_price_second_day']),1,1,'L',1);
    $yPos += 10;
    $grandTotalPrice += $data['report']['price_second_day'];
}

if($data['report']['counts_over_land']){
    $pdf->SetY($yPos);
    $pdf->setFillColor(255,255,255); 
    $pdf->SetTextColor(0,0,0); 
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(12,10,$sNo++,1,0,'L',1);
    $pdf->Cell(60,10,'Over Land Delivery ',1,0,'L',1);
    $pdf->Cell(35,10,($data['report']['counts_over_land']),1,0,'L',1);
    $pdf->Cell(35,10,($data['report']['weight_over_land'] != "" ? number_format($data['report']['weight_over_land']) : "0"),1,0,'L',1);
    $pdf->Cell(48,10,'Rs.'.number_format($data['report']['sub_price_over_land']),1,1,'L',1);
    $yPos += 10;
    $grandTotalPrice += $data['report']['price_over_land'];
}

$pdf->SetY($yPos);
$pdf->setFillColor(255,255,255); 
$pdf->SetTextColor(0,0,0); 
$pdf->SetFont('Arial','',9);
$pdf->Cell(12,10,'',0,0,'L',1);
$pdf->Cell(60,10,'',0,0,'L',1);
$pdf->Cell(70,10,' Fuel Charges ',1,0,'L',1);
$pdf->Cell(48,10,'Rs.'.number_format((float)$data['report']['fuel_charges']),1,1,'L',1);
$yPos += 10;

$pdf->SetY($yPos);
$pdf->setFillColor(255,255,255); 
$pdf->SetTextColor(0,0,0); 
$pdf->SetFont('Arial','',9);
$pdf->Cell(12,10,'',0,0,'L',1);
$pdf->Cell(60,10,'',0,0,'L',1);
$pdf->Cell(70,10,' GST ('.($data['report']['gst']).'%) ',1,0,'L',1);
$pdf->Cell(48,10,'Rs.'.number_format($data['report']['total_tax']),1,1,'L',1);
$yPos += 10;

$pdf->SetY($yPos);
$pdf->SetFont('Arial','',9);
$pdf->Cell(12,10,'',0,0,'L',1);
$pdf->Cell(60,10,'',0,0,'L',1);
$pdf->SetFont('Arial','B',9);
$pdf->setFillColor(53,72,122); 
$pdf->SetTextColor(255,255,255);
$pdf->Cell(70,10,' GRAND TOTAL ',1,0,'L',1);
$pdf->Cell(48,10,'Rs.'.number_format($grandTotalPrice),1,1,'L',1);
$yPos += 10;

/* Ending Total Section */
$height = $pdf->h;
$pdf->SetY($yPos+30);
$image1 = "hships.PNG";
$pdf->Cell( 40, 40, $pdf->Image($image1, $pdf->GetX(), $pdf->GetY(), 120), 0, 0, 'L', false );

// $pdf->AddPage();
$pdf->AddPage("P", "A4", 0, true);
$pdf->AliasNbPages();
$pdf->SetY(65);
$yPos = $pdf->GetY();
$sn = 1;
$pdf->setFillColor(255,255,255); 
$pdf->SetTextColor(53,72,122);
$pdf->SetY($yPos+7);
$pdf->SetFont('Arial','',8);
$pdf->SetDrawColor(53,72,122);
foreach($data['content'] as $content){
    if($yPos >= 235){
        $pdf->AddPage("P", "A4", 0, true);
        $pdf->AliasNbPages();
        $yPos = 72;
        $pdf->SetY($yPos);
    }
    $pdf->Cell(10,6,$sn,1,0,'C',1);
    $pdf->Cell(15,6,$content['origin_city'],1,0,'C',1);
    $pdf->Cell(20,6,$content['cnic'],1,0,'C',1);
    $pdf->Cell(15,6,$content['consignment_dest_city'],1,0,'C',1);
    $pdf->Cell(20,6,$content['booking_date'],1,0,'C',1);
    $pdf->Cell(20,6,($content['consignment_service_type'] == 1 ? 'SAME-DAY' : ($content['consignment_service_type'] == 2 ? 'OVERNIGHT' : ($content['consignment_service_type'] == 3 ? 'SECOND-DAY' : 'OVERLAND'))),1,0,'C',1);
    $pdf->Cell(15,6,$content['consignment_weight'],1,0,'C',1);
    $pdf->Cell(15,6,$content['consignment_pieces'],1,0,'C',1);
    $pdf->Cell(15,6,$content['sub_total'],1,0,'C',1);
    $pdf->Cell(15,6,$content['fuel_charge'],1,0,'C',1);
    $pdf->Cell(15,6,$content['gst_charge'],1,0,'C',1);
    $pdf->Cell(15,6,number_format($content['total_price']),1,1,'C',1);

        $yPos += 5;
    $sn ++ ;
}

$pdf->Output();
?>
