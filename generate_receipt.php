<?php
require_once 'conn.php';
require('fpdf186/fpdf.php');      // FPDF library
require('phpqrcode/qrlib.php');   // QR Code library

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "SELECT * FROM payments WHERE id = $id AND payment_status='Paid'";
    $result = mysqli_query($con, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        $pdf = new FPDF();
        $pdf->AddPage();

        // ---------- HEADER ----------
        if (file_exists("images/logo.png")) {
            $pdf->Image('images/logo.png',10,8,25);
        }
        $pdf->SetFont('Arial','B',18);
        $pdf->SetTextColor(0,102,204);
        $pdf->Cell(0,10,'E-Gram Panchayat',0,1,'C');
        $pdf->SetFont('Arial','I',12);
        $pdf->SetTextColor(100,100,100);
        $pdf->Cell(0,8,'Village Development Office - Government of India',0,1,'C');
        $pdf->Cell(0,8,'Contact: +91-9876543210 | Email: contact@egram.gov.in',0,1,'C');

        $pdf->SetDrawColor(0,102,204);
        $pdf->SetLineWidth(1);
        $pdf->Line(10, 40, 200, 40);
        $pdf->Ln(15);

        // ---------- TITLE ----------
        $pdf->SetFont('Arial','B',16);
        $pdf->SetTextColor(255,69,0);
        $pdf->Cell(0,10,'Payment Receipt',0,1,'C');
        $pdf->Ln(5);

        // ---------- RECEIPT DETAILS ----------
        $pdf->SetFont('Arial','B',12);
        $pdf->SetFillColor(0,102,204);
        $pdf->SetTextColor(255,255,255);
        $pdf->Cell(0,10,'Transaction Details',1,1,'C',true);

        $pdf->SetFont('Arial','',12);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFillColor(245,245,245);

        $pdf->Cell(60,10,'Property ID',1,0,'L',true);
        $pdf->Cell(0,10,$row['property_id'],1,1);

        $pdf->Cell(60,10,'Property Owner',1,0,'L',true);
        $pdf->Cell(0,10,$row['property_owner'],1,1);

        $pdf->Cell(60,10,'Payment Amount',1,0,'L',true);
        $pdf->Cell(0,10,$row['payment_amount'],1,1);

        $pdf->Cell(60,10,'Payment Method',1,0,'L',true);
        $pdf->Cell(0,10,$row['payment_method'],1,1);

        $pdf->Cell(60,10,'Payment Date',1,0,'L',true);
        $pdf->Cell(0,10,$row['payment_date'],1,1);

        $pdf->Cell(60,10,'Status',1,0,'L',true);
        $pdf->SetTextColor(0,128,0);
        $pdf->Cell(0,10,$row['payment_status'].' .',1,1);
        $pdf->SetTextColor(0,0,0);

        $pdf->Ln(15);

        // ---------- QR CODE ----------
        $qrText = "Receipt ID: ".$row['id']."\nOwner: ".$row['property_owner']."\nAmount: ₹ ".$row['payment_amount']."\nDate: ".$row['payment_date'];
        $qrFile = 'qrcodes/receipt_'.$row['id'].'.png';

        if (!file_exists('qrcodes')) {
            mkdir('qrcodes'); // create folder if not exists
        }
        QRcode::png($qrText, $qrFile, QR_ECLEVEL_L, 4);

        if (file_exists($qrFile)) {
            $pdf->Image($qrFile, 160, 100, 35, 35); // QR Code position
        }

        // ---------- THANK YOU ----------
        $pdf->SetFont('Arial','B',14);
        $pdf->SetTextColor(0,102,204);
        $pdf->Cell(0,10,'Thank you for your payment! Your contribution supports village development.',0,1,'C');
        $pdf->Ln(10);

        // ---------- SIGNATURE ----------
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(130,10,'Authorized Signature:',0,0,'L');

        if (file_exists("images/panchayatt.jpg")) {
            $pdf->Image('images/panchayatt.jpg',150,160,40);
        }

        $pdf->Ln(40);

        // ---------- FOOTER ----------
        $pdf->SetDrawColor(200,200,200);
        $pdf->Line(10, 270, 200, 270);
        $pdf->SetFont('Arial','I',10);
        $pdf->SetTextColor(100,100,100);
        $pdf->Cell(0,10,'This is a computer-generated receipt. No signature required.',0,1,'C');

        // OUTPUT
        $pdf->Output("D", "receipt_{$row['id']}.pdf");
    } else {
        echo "Invalid or unpaid payment.";
    }
} else {
    echo "Invalid request.";
}
?>
