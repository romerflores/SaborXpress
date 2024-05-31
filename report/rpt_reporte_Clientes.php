<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/app/config/global.php");
require_once(ROOT_DIR . "/model/ClienteModel.php.php");
include(ROOT_CORE . "/fpdf/fpdf.php");

class PDF extends FPDF{
    function convertxt($p_txt)
    {
        return iconv('UTF-8', 'iso-8859-1', $p_txt);
    }
    function Header()
    {
        $this -> SetFont('Arial', 'B', 20);
        $this -> Cell(0, 20, "Reporte de Inscritos", 0, 1, 'C');
    }
    function Footer()
    {
        $this -> SetY(-15);
        $this -> SetFont('Arial', 'I', 8);
        $this -> Cell(0, 10, $this -> convertxt("Página").$this -> PageNo().'/{nb}', 0, 0, 'c');
    }
}

$rpt = new ClienteModel();
$records = $rpt -> findall();
$records = $records['DATA'];


$pdf = new PDF();
$pdf -> AliasNbPages();
$pdf -> AddPage();

//Cabecera
$pdf -> SetFont('Arial', 'B', 12);
$header = array($pdf -> convertxt("No."), $pdf -> convertxt("Nombre"), $pdf -> convertxt("Apellido"), $pdf -> convertxt("Curso"), $pdf -> convertxt("Nivel"));
$widths = array(10, 40, 40, 40, 40);
for ($i = 0; $i < count($header); $i++) 
{
    $pdf -> Cell($widths[$i], 7, $header[$i], 1);
}
$pdf -> Ln();

//Cuerpo
$pdf -> SetFont('Arial', '', 10);
foreach($records as $row)
{
    $pdf -> Cell($widths[0], 6, $pdf -> convertxt($row['id']), 1);
    $pdf -> Cell($widths[1], 6, $pdf -> convertxt($row['nombre']), 1);
    $pdf -> Cell($widths[2], 6, $pdf -> convertxt($row['apellido']), 1);
    $pdf -> Cell($widths[3], 6, $pdf -> convertxt($row['curso']), 1);
    $pdf -> Cell($widths[4], 6, $pdf -> convertxt($row['nivel']), 1);
    $pdf -> Ln();
}

$pdf -> Output();

?>