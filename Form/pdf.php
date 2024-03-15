<?php

use Fpdf\Fpdf;

require "../vendor/autoload.php";
$pdf = new Fpdf();
$pdf->AddPage();
$pdf->Rect(5, 5, 200, 287);
$pdf->SetFont('Arial', 'B', 36);
$pdf->Cell(190, 36, "REPORT", 0, 1, 'C');
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(40, 20, "Full-Name: ", 0, 0, 'L');
$pdf->SetFont('Arial', '', 16);
$pdf->Cell(80, 20, $fullName, 0, 1, 'L');

$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(40, 20, "Email: ", 0, 0, 'L');
$pdf->SetFont('Arial', '', 16);
$pdf->Cell(80, 20, $email, 0, 1, 'L');

$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(40, 20, "Phone No.: ", 0, 0, 'L');
$pdf->SetFont('Arial', '', 16);
$pdf->Cell(80, 20, $phone, 0, 1, 'L');



$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(95, 15, "Subject", 1, 0, 'C');
$pdf->Cell(95, 15, "Marks", 1, 1, 'C');
foreach ($marksFinal as $x) {
  $pdf->Cell(95, 10, $x[0], 1, 0, 'C');
  $pdf->Cell(95, 10, $x[1], 1, 1, 'C');
}
// $pdf->Cell(100,10,$targetFile."HELLO",0,1,"C");
$pdf->Image($targetFile, 150, 50, 50, 50);
$pdf->Output('D', 'report.pdf');
