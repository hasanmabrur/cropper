<?php
require('assets/fpdf/fpdf.php');

class PDF extends FPDF
{
    // Page header
    function Header()
    {
        // Logo
        // $this->Image('avatar.png',10,6,30);
        // Arial bold 15
        // $this->SetFont('Arial','B',15);
        // Move to the right
        // $this->Cell(80);
        // Title
        // $this->Cell(30,10,'Title',1,0,'C');
        // Line break
        $this->Ln(20);
    }

    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        // $this->SetY(-15);
        // Arial italic 8
        // $this->SetFont('Arial','I',8);
        // Page number
        // $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }

    // Page content
    function Content()
    {
        // Halaman 1
        $this->AddPage('P', array(215,330)); // ukuran kertas dalam satuan mm
        $this->SetFont('Arial','B',16);
        $this->Cell(0,10,'Page 1',0,1,'C');
        $this->Image('avatar.png', 50, 50, 150, 0, 'png');

        // Halaman 2
        $this->AddPage('P', array(215,330)); // ukuran kertas dalam satuan mm
        $this->SetFont('Arial','B',16);
        $this->Cell(0,10,'Page 2',0,1,'C');
        $this->Image('avatar.png', 50, 50, 150, 0, 'png');

        // Halaman 3
        $this->AddPage('P', array(215,330)); // ukuran kertas dalam satuan mm
        $this->SetFont('Arial','B',16);
        $this->Cell(0,10,'Page 3',0,1,'C');
        $this->Image('avatar.png', 50, 50, 150, 0, 'png');

        // Halaman 4
        $this->AddPage('P', array(215,330)); // ukuran kertas dalam satuan mm
        $this->SetFont('Arial','B',16);
        $this->Cell(0,10,'Page 4',0,1,'C');
        $this->Image('avatar.png', 50, 50, 150, 0, 'png');

        // Halaman 5
        $this->AddPage('P', array(215,330)); // ukuran kertas dalam satuan mm
        $this->SetFont('Arial','B',16);
        $this->Cell(0,10,'Page 5',0,1,'C');
        $this->Image('avatar.png', 50, 50, 150, 0, 'png');

        // Halaman 6
        $this->AddPage('P', array(215,330)); // ukuran kertas dalam satuan mm
        $this->SetFont('Arial','B',16);
        $this->Cell(0,10,'Page 6',0,1,'C');
        $this->Image('avatar.png', 50, 50, 150, 0, 'png');
    }
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->Content();
$pdf->Output();
?>