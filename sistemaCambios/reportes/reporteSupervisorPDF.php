<?php
date_default_timezone_set('America/Mexico_City');
require_once('../fpdf/fpdf.php');
require_once('../clases/class.MySQL.php');

$db = new MySQL();

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {

        require_once('../clases/class.MySQL.php');
        $db = new MySQL();

        $idoperacion = $_SESSION['idoperacion'];
        $fechaPreventa = $_POST['fechaPre'];
        $tipoReporte = $_POST['tipoR'];
        $tArchivo = $_POST['optionsRadios'];

        /** array dias **/
        $dias = array('','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');

        $fechaDia = $dias[date('N', strtotime($fechaPreventa))];

        if($fechaDia=='Sabado'){
            $fechaEntrega = strtotime ('+2 day', strtotime ($fechaPreventa));
        }
        else
        {
            $fechaEntrega = strtotime ('+1 day', strtotime ($fechaPreventa));
        }

        $fechaEntrega = date('Y-m-d', $fechaEntrega);

        /** Query para obtener el idDeposito**/
        $consultaDep = "SELECT d.idDeposito, d.deposito, r.region FROM Operaciones o
        INNER JOIN Deposito d ON d.idDeposito = o.idDeposito
        INNER JOIN Zona z ON z.idZona = d.idZona
        INNER JOIN Region r ON r.idRegion = z.idRegion
        WHERE o.idoperacion = ".$idoperacion." LIMIT 1";
        $resultadoDep = $db->consulta($consultaDep);
        $rowDep = $db->fetch_assoc($resultadoDep);

        // Logo
        //$this->Image('logo_pb.png',10,8,33);
        // Arial bold 15
        $this->SetFont('Times','',12);
         /*
        //Portrait
            // Movernos a la derecha
            $this->Cell(15);
            // Título
            $this->Cell(30,5,'Gepp',1,0,'L');
            $this->Cell(50,5,utf8_decode('Compañía:'),1,0,'L');
            $this->Cell(80,5,'Gepp S de RL de CV',1,1,'L');
            // Movernos a la derecha
            $this->Cell(15);
            $this->Cell(30,5,'Reporte de Cambios',1,0,'L');
            $this->Cell(50,5,utf8_decode('Depósito:'),1,0,'L');
            $this->Cell(80,5,$rowDep['idDeposito']." ".utf8_decode($rowDep['deposito']),1,1,'L');
            // Movernos a la derecha
            $this->Cell(15);
            $this->Cell(30,5,'',1,0,'L');
            $this->Cell(50,5,utf8_decode('Fecha Preventa'),1,0,'L');
            $this->Cell(80,5,$fechaPreventa,1,1,'L');
            // Movernos a la derecha
            $this->Cell(15);
            $this->Cell(30,5,'',1,0,'L');
            $this->Cell(50,5,utf8_decode('Fecha Entrega'),1,0,'L');
            $this->Cell(80,5,$fechaEntrega,1,1,'L');
            // Salto de línea
            $this->Ln(20);*/

        //Landscape
            // Movernos a la derecha
            $this->Cell(30);
            // Título
            $this->Cell(60,5,'Gepp',0,0,'L');
            $this->Cell(60,5,utf8_decode('Compañía:'),0,0,'L');
            $this->Cell(60,5,'Gepp S de RL de CV',0,0,'L');
            $this->Cell(60,5,date('Y-m-d H:i:s'),0,1,'L');
            // Movernos a la derecha
            $this->Cell(30);
            $this->Cell(60,5,'Reporte de Cambios',0,0,'L');
            $this->Cell(60,5,utf8_decode('Depósito:'),0,0,'L');
            $this->Cell(60,5,$rowDep['idDeposito']." ".utf8_decode($rowDep['deposito']),0,1,'L');
            // Movernos a la derecha
            $this->Cell(30);
            $this->Cell(60,5,'',0,0,'L');
            $this->Cell(60,5,utf8_decode('Fecha Preventa'),0,0,'L');
            $this->Cell(60,5,$fechaPreventa,0,1,'L');
            // Movernos a la derecha
            $this->Cell(30);
            $this->Cell(60,5,'',0,0,'L');
            $this->Cell(60,5,utf8_decode('Fecha Entrega'),0,0,'L');
            $this->Cell(60,5,$fechaEntrega,0,1,'L');
            // Salto de línea
            $this->Ln(20);
    }

    function Footer()
    {
        // Go to 1.5 cm from bottom
        $this->SetY(-11);
        // Select Arial italic 8
        $this->SetFont('Arial','I',8);
        // Print centered page number
        $this->Cell(0,10,utf8_decode('Página ').$this->PageNo(),0,0,'R');

    }

    // Una tabla más completa
    function ImprovedTable($header, $data)
    {

        // Cabeceras
        for($i=0;$i<count($header);$i++)
            $this->Cell(20,7,$header[$i],0,0,'C');
        $this->Ln();

        // Datos
        //foreach($data as $row)
        //{
            $this->Cell(20,6,$row[0],0,0);
            $this->Cell(20,6,$row[1],0,0);
            $this->Cell(20,6,number_format($row[2]),0,0);
            $this->Cell(20,6,number_format($row[3]),0,0);
            $this->Ln();
        //}
        // Línea de cierre
    }
}


// Creación del objeto de la clase heredada
$pdf = new PDF('L','mm','Letter');

/** Query para obtener los productos en los cambios **/
$consultaPro = "SELECT cc.idProductoCambio,pc.DescripcionInterna FROM CapturaCambios cc
INNER JOIN ProductosCambios pc ON cc.idProductoCambio = pc.idProductoCambio
AND cc.idoperacion = $idoperacion
AND FechaCambio = '$fechaPreventa'
GROUP BY pc.idProductoCambio";
$resultadoPro = $db->consulta($consultaPro);
$rowPro = $db->fetch_assoc($resultadoPro);

/** Creo un array para guardar el id producto cambio **/
$arrayProductos = array();
$contP = 0;

// Títulos de las columnas
$header = array('Ruta','#Clientes');
// Anchuras de las columnas
$w = array(20,20);
$contador = 2;
    do{

        $header[$contador] = substr($rowPro['DescripcionInterna'],0,12);
        $w[$contador]=20;
        $arrayProductos[$contP] = $rowPro['idProductoCambio'];
        $contP++;
        $contador++;

    }while($rowPro = $db->fetch_assoc($resultadoPro));
$tdPro = substr($tdPro,0,-1);

/** Inicio un for para sacar los totales por producto y ruta **/
for ($i=0;$i<count($arrayProductos);$i++){

    $consulta3 = "SELECT COUNT(pc.idProductoCambio) AS cantP FROM CapturaCambios cc
    INNER JOIN ProductosCambios pc ON cc.idProductoCambio = pc.idProductoCambio
    WHERE cc.idoperacion = $idoperacion AND cc.FechaCambio = '$fechaPreventa'
    AND cc.idruta = ".$row['idruta']." AND pc.idProductoCambio = ".$arrayProductos[$i];
    $resultado3 = $db->consulta($consulta3);
    $row3 = $db->fetch_assoc($resultado3);

    $tdCP .= '<td width="50"><tt>'.$row3['cantP'].'</tt></td>';

}


$pdf->SetFont('Times','',10);
$pdf->AddPage();
$pdf->ImprovedTable($header,$data);
$pdf->Output('reporteSupervisor_'.$fechaPreventa.'_'.date('H:i:s').'.pdf','D');
?>
