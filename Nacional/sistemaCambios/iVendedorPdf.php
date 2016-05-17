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

$consulta = "SELECT c.nombre, c.nud FROM Clientes c INNER JOIN Operaciones o ON c.idDeposito = o.idDeposito INNER JOIN CapturaCambios cc ON o.idoperacion = cc.idoperacion WHERE c.nud = cc.nud AND cc.idoperacion = $idoperacion AND cc.FechaCambio = '$fecha' GROUP BY  c.nombre";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);
class PDF extends FPDF
{
    // Cabecera de página
    /*function Header()
    {
        // Logo
        $this->Image('img/logo_gepp.jpg',170,8,33);
        // Arial bold 15
        $this->SetFont('Arial','B',15);
        // Movernos a la derecha
        $this->Cell(80);
        // Título
        $this->Cell(30,10,'Vendedor',0,0,'C');
        // Salto de línea
        $this->Ln(20);
    }*/

    // Pie de página
    /*function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-25);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Número de página
        $this->Cell(0,10,'__________________',0,1,'C');
        $this->Cell(0,10,'Firma',0,0,'C');
    }*/
}

// Creación del objeto de la clase heredada


$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
$contador = 0;

do{
    $total = 0;
    $pdf->Image('img/logo_gepp.jpg',170,8,33);
    if($contador==1){
      $pdf->Image('img/logo_gepp.jpg',170,120,33,0);  
    }  
    $pdf->Cell(10,10);
    $pdf->Cell(38,10,substr($row['nombre'],0,14),1,0);
    $pdf->Cell(20,10,'Cantidad',1,1);

    $consulta2 = "SELECT pc.DescripcionInterna, cc.cantidad FROM CapturaCambios cc INNER JOIN ProductosCambios pc ON cc.idProductoCambio = pc.idProductoCambio WHERE cc.idoperacion = $idoperacion AND cc.FechaCambio = '$fecha' AND cc.nud = ".$row['nud'];
    $resultado2 = $db->consulta($consulta2);
    $row2 = $db->fetch_assoc($resultado2);

    do{

        $pdf->cell(10,10);
        $pdf->cell(38,10,$row2['DescripcionInterna'],1,0);
        $pdf->cell(20,10,$row2['cantidad'],1,1);

        $total = $total + $row2['cantidad'];

    }while($row2 = $db->fetch_assoc($resultado2));

    $pdf->cell(10,10);
    $pdf->Cell(38,10,'Total',1,0);
    $pdf->Cell(20,10,$total,1,1);
    $pdf->cell(10,10);
    $pdf->Cell(48,10,'______________',0,1,'C');
    $pdf->cell(10,10);
    $pdf->Cell(48,10,'Firma',0,1,'C');
    $pdf->ln();
    if($contador==1){
      $pdf->ln();
      $pdf->ln();
      $contador=-1;  
    } 
    $contador++;
}while($row = $db->fetch_assoc($resultado));
$pdf->Output();
?>