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

$consulta = "SELECT pc.idProductoCambio, pc.DescripcionInterna FROM ProductosCambios pc INNER JOIN CapturaCambios cc ON pc.idProductoCambio = cc.idProductoCambio WHERE cc.idoperacion = $idoperacion AND cc.FechaCambio = '$fecha' GROUP BY  cc.idProductoCambio";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);
class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        // Logo
        $this->Image('img/logo_gepp.jpg',230,8,33);
        // Arial bold 15
        $this->SetFont('Arial','B',15);
        // Movernos a la derecha
        $this->Cell(125);
        // Título
        $this->Cell(30,10,'Almacen',0,0,'C');
        // Salto de línea
        $this->Ln(20);
    }

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


$pdf = new PDF('L','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
$pdf->SetXY(10,40);
$arrayProductos = array();
$arrayRutas = array();
$x=0;
$y = 0;

/** Se crea la columna de productos **/
do{
  
    $pdf->Cell(38,10,$row['DescripcionInterna'],1,1);
    $arrayProductos[$x] = $row['idProductoCambio'];
    $x++;
  }while($row = $db->fetch_assoc($resultado));

/** Se crea la fila de rutas **/
$consulta2 = "SELECT o.idRuta FROM CapturaCambios cc INNER JOIN Orden o ON cc.idoperacion = o.idoperacion AND cc.FechaCambio = o.fecha_preventa AND cc.nud = o.nud WHERE cc.FechaCambio = '".$fecha."' AND cc.idoperacion = ".$idoperacion." GROUP BY  o.idRuta";
$resultado2 = $db->consulta($consulta2);
$row2 = $db->fetch_assoc($resultado2);
$pdf->SetXY(48,30);  
do{
    $pdf->cell(12,10,$row2['idRuta'],1,0,'C');
    $arrayRutas[$y] = $row2['idRuta'];
    $y++;
}while($row2 = $db->fetch_assoc($resultado2));

$y1 = 40;
$pdf->SetXY(48,$y1);
/** Se crea la matriz producto-rutas **/
for ($i=0; $i < count($arrayProductos); $i++){

    for ($z=0; $z < count($arrayRutas); $z++){
        $consulta3 = "SELECT SUM(cc.cantidad) c_productos, o.idRuta FROM CapturaCambios cc INNER JOIN Orden o ON cc.idoperacion = o.idoperacion AND cc.FechaCambio = o.fecha_preventa AND cc.nud = o.nud WHERE cc.FechaCambio = '".$fecha."' AND cc.idoperacion = ".$idoperacion." AND cc.idProductoCambio = ".$arrayProductos[$i]." AND o.idruta = ".$arrayRutas[$z]." LIMIT 1";
        $resultado3 = $db->consulta($consulta3);
        $row3 = $db->fetch_assoc($resultado3);
        $pdf->cell(12,10,$row3['c_productos'],1,0,'C');
      
     } 
     $y1 = $y1 + 10;
     $pdf->SetXY(48,$y1);
}
$pdf->Output();
?>