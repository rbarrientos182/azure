<?php
if (!isset($_SESSION)) 
{
    session_start();
}
require_once('clases/fpdf/fpdf.php');
require_once('clases/class.MySQL.php');

$fecha = $_GET['f'];
$idoperacion = $_SESSION['idoperacion'];

$db = new MySQL();

$consulta = "SELECT COUNT(cc.nud) AS clientes, SUM(cc.cantidad) AS cant, o.idRuta, o.idoperacion FROM CapturaCambios cc INNER JOIN Orden o ON cc.nud = o.nud AND cc.idoperacion = o.idoperacion AND cc.FechaCambio = o.fecha_preventa WHERE cc.FechaCambio = '".$fecha."' AND cc.idoperacion = ".$idoperacion." GROUP BY  o.idRuta";
//$consulta = "SELECT * FROM CapturaCambios WHERE idoperacion = $idoperacion AND FechaCambio ='$fecha'";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);

$consulta2 = "SELECT COUNT(cc.idCambiosMotivos) AS motivos, cm.Descripcion FROM CapturaCambios cc INNER JOIN CambiosMotivos cm ON cc.idCambiosMotivos = cm.idCambiosMotivos WHERE cc.FechaCambio = '$fecha' AND cc.idoperacion = $idoperacion GROUP BY cc.idCambiosMotivos";
$resultado2 = $db->consulta($consulta2);
$row2 = $db->fetch_assoc($resultado2);

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        // Logo
        $this->Image('img/logo_gepp.jpg',170,8,33);
        // Arial bold 15
        $this->SetFont('Arial','B',15);
        // Movernos a la derecha
        $this->Cell(80);
        // Título
        $this->Cell(30,10,'Supervisor',0,0,'C');
        // Salto de línea
        $this->Ln(20);
    }

    // Pie de página
    /*function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Número de página
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }*/
}

// Creación del objeto de la clase heredada


$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
$pdf->SetY(40);
$pdf->Cell(10,10);
$pdf->Cell(17,10,'Ruta',0,0);
$pdf->Cell(17,10,'Clientes',0,0);
$pdf->Cell(17,10,'Cantidad',0,1);

do{
    $pdf->Cell(10,10);
    $pdf->Cell(17,10,$row['idRuta'],0,0);
    $pdf->Cell(17,10,$row['clientes'],0,0);
    $pdf->Cell(17,10,$row['cant'],0,1);
}while($row = $db->fetch_assoc($resultado));

$pdf->SetXY(120,40);
$pdf->Cell(17,10,'Motivo',0,1);

do{
    $pdf->SetX(120);
    $pdf->Cell(17,10,$row2['motivos'].' - '.$row2['Descripcion'],0,1);

}while($row2 = $db->fetch_assoc($resultado2));
$pdf->Output();
?>