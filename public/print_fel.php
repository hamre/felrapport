<?php
include("../sys/core/init.inc.php");
require_once('tcpdf/config/lang/swe.php');
require_once('tcpdf/tcpdf.php');
$k = new user;
$regnr = $_GET['regnr'];
$id = $_GET['id'];

$fel = $k->db->prepare("SELECT * FROM fel WHERE regnr = :reg AND id = :id");
$fel->execute(array("reg" => $regnr, "id" => $id));

$fel2 = $fel->fetch();

$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, false, 'ISO-8859-1', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Björn Ax');
$pdf->SetTitle('Högbergs buss AB felanmälan');
$pdf->SetSubject('Felanmälan');

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_RIGHT);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// set font
$pdf->SetFont('times', '', 15);

// add a page
$pdf->AddPage();

// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
$pdf->setCellMargins(1, 1, 1, 1);

// set color for background
$pdf->SetFillColor(255, 255, 127);

$pdf->setJPEGQuality(75);

switch($fel2['allvar']) {
    case 1:
        $allvar = "Normal";
        break;
    case 2:
        $allvar = "Kritisk";
        break;
    case 0:
        $allvar = "Låg";
        break;
}

if($fel2['vem'] == "") {
$text = "Inlagd av: Ej angivet\nInlagd: ".$fel2['datum']."\nFordon: ".$fel2['regnr']."\nNivå: ".$allvar;
} else {
$text = "Inlagd av: ".$fel2['vem']."\nInlagd: ".$fel2['datum']."\nFordon: ".$fel2['regnr']."\nNivå: ".$allvar;
}

$pdf->Image('logo_1.jpg', 120, 17, 75, 20, 'JPG', 'http://www.hogbergsbuss.se', '', true, 150, '', false, false, 1, false, false, false);

$feldesc = $fel2['beskrivning'];

$pdf->MultiCell(75, 5, $text, 0, 'L', 0, 1, '', '', true);
if($fel2['allvar'] == 2) {
  $html = '<span style="color: red; background-color: yellow">DETTA ÄR EN KRITISK FELRAPPORT</span>';
  $pdf->WriteHtml($html, true, false, true, false, '');
  //$pdf->MultiCell(105, 5, 'DETTA ÄR EN KRITISK FELRAPPORT', 0, 'L', 1, 1, '', '', true);
}
$pdf->Multicell(55, 5, 'Felbeskrivning', 0, 'L', 0, 1, '', '', true);
$pdf->MultiCell(180, 165, $feldesc, 1, 'L', 0, 1, '', '', true);
//$pdf->MultiCell(55, 5, '[JUSTIFY] '.$txt."\n", 1, 'J', 1, 2, '' ,'', true);
//$pdf->MultiCell(55, 5, '[DEFAULT] '.$txt, 1, '', 0, 1, '', '', true);

$pdf->Ln(4);

$pdf->lastPage();

$js = 'print(true)';

$pdf->IncludeJS($js);

$pdf->Output('fel.pdf', 'I');

?>