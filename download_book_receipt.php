<?php
session_start();
require('conn.php');
require('fpdf186/fpdf.php');
require('phpqrcode/qrlib.php');

if(!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

if(!isset($_GET['id'])) {
    die("Invalid request");
}

$booking_id = intval($_GET['id']);

// Fetch booking details
$sql = "SELECT b.*, u.uname, u.mobile, i.item_name, i.price 
        FROM bookings b
        JOIN user_table u ON b.user_id=u.id
        JOIN items i ON b.item_id=i.item_id
        WHERE b.booking_id=$booking_id AND b.admin_status='Approved'";
$result = $con->query($sql);
if($result->num_rows == 0) {
    die("Booking not found or not approved");
}
$row = $result->fetch_assoc();

// QR Code Data
$qrData = "Booking ID: ".$row['booking_id']."\n".
          "User: ".$row['uname']."\n".
          "Item: ".$row['item_name']."\n".
          "From: ".$row['from_date']."\n".
          "To: ".$row['to_date']."\n".
          "Price: ₹".$row['price'];

$tempDir = "qrcodes/";
if(!file_exists($tempDir)) mkdir($tempDir);
$qrFile = $tempDir.'qr_'.$row['booking_id'].'.png';
QRcode::png($qrData, $qrFile, QR_ECLEVEL_L, 4);

// Generate PDF Receipt
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,'Booking Receipt',0,1,'C');
$pdf->Ln(5);

$pdf->SetFont('Arial','',12);
$pdf->Cell(0,10,'Booking ID: '.$row['booking_id'],0,1);
$pdf->Cell(0,10,'User: '.$row['uname'].' ('.$row['mobile'].')',0,1);
$pdf->Cell(0,10,'Item: '.$row['item_name'],0,1);
$pdf->Cell(0,10,'Price: ₹'.$row['price'],0,1);
$pdf->Cell(0,10,'From: '.$row['from_date'],0,1);
$pdf->Cell(0,10,'To: '.$row['to_date'],0,1);
$pdf->Cell(0,10,'Admin Status: '.$row['admin_status'],0,1);
$pdf->Cell(0,10,'Admin Comment: '.$row['admin_comment'],0,1);
$pdf->Ln(5);

// QR Code in receipt
$pdf->Image($qrFile,150,60,40,40);

$pdf->Output();
?>
