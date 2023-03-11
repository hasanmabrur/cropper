<?php
require('assets/fpdf/fpdf.php');

// buat variabel data
$nama = "John Doe";
$alamat = "Jl. Sudirman No. 123";
$tanggal_lahir = "01 Januari 1990";
$foto = "foto.jpg";

// buat objek PDF baru
$pdf = new FPDF();
$pdf->AddPage();

// import halaman template PDF yang sudah ada
$pageCount = $pdf->setSourceFile("template.pdf");
$templateIndex = 1;
$templatePage = $pdf->importPage($templateIndex);
$pdf->useTemplate($templatePage);

// ganti data pada template PDF
$pdf->SetFont('Arial','B',16);
$pdf->SetXY(50, 50);
$pdf->Cell(0, 0, $nama);
$pdf->SetXY(50, 60);
$pdf->Cell(0, 0, $alamat);
$pdf->SetXY(50, 70);
$pdf->Cell(0, 0, $tanggal_lahir);
$pdf->Image($foto,10,100,50);

// simpan hasil penggantian data pada file PDF baru
$pdf->Output('hasil.pdf', 'F');
?>
