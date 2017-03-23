<?php
date_default_timezone_set('America/Mexico_City');
require_once('../fpdf/fpdf.php');
require_once('../clases/class.MySQL.php');
require_once('../clases/class.Funciones.php');


$db = new MySQL();
$fn = new Funciones();

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {

        require_once('../clases/class.MySQL.php');
        $db = new MySQL();

        $idoperacion = $_SESSION['idoperacion'];
        $fechaIni = $_POST['fechaIni'];

        /** array dias **/
        $dias = array('','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');

        $fechaDia = $dias[date('N', strtotime($fechaIni))];

        if($fechaDia=='Sabado'){
            $fechaEntrega = strtotime ('+2 day', strtotime ($fechaIni));
        }
        else
        {
            $fechaEntrega = strtotime ('+1 day', strtotime ($fechaIni));
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
        $this->Image('../img/Pepsi-logo.png',10,8,20);
        $this->Image('../img/tbMotivos.png',198,8,70);
        // Arial bold 15
        $this->SetFont('Times','',12);
        //Landscape
        // Movernos a la derecha
        $this->Cell(30);
        // Título
        $this->Cell(60,5,'Gepp',0,0,'L');
        $this->Cell(60,5,utf8_decode('Compañía: Gepp S de RL de CV'),0,0,'L');
        //$this->Cell(60,5,'Gepp S de RL de CV',0,0,'L');
        $this->Cell(60,5,'',0,1,'L');
        // Movernos a la derecha
        $this->Cell(30);
        $this->Cell(60,5,'Reporte Operador de Entrega',0,0,'L');
        $this->Cell(60,5,utf8_decode('Depósito: '.$rowDep['idDeposito'].' '.$rowDep['deposito']),0,0,'L');
        //$this->Cell(80,5,$rowDep['idDeposito']." ".utf8_decode($rowDep['deposito']),0,1,'L');
        $this->Cell(60,5,'',0,1,'L');
        // Movernos a la derecha
        $this->Cell(30);
        $this->Cell(60,5,'',0,0,'L');
        $this->Cell(60,5,utf8_decode('Fecha Preventa: '.$fechaIni),0,0,'L');
        $this->Cell(60,5,'',0,1,'L');
        //$this->Cell(80,5,$fechaIni,0,1,'L');
        // Movernos a la derecha
        $this->Cell(30);
        $this->Cell(60,5,date('Y-m-d H:i:s'),0,0,'L');
        $this->Cell(60,5,utf8_decode('Fecha Entrega: '.$fechaEntrega),0,0,'L');
        $this->Cell(60,5,'',0,1,'L');
        //$this->Cell(80,5,$fechaEntrega,0,1,'L');
        // Salto de línea
        $this->Ln(20);
    }

    function crearEncabezado($header,$w){

    	for($i=0;$i<count($header);$i++){
		    $this->Cell($w[$i],7,utf8_decode($header[$i]),'B',0,'C',false);
		}
		$this->Ln();

    }
}


// Creación del objeto de la clase heredada
$pdf = new PDF('L','mm','Letter');

/** Creo un array para guardar el id producto cambio **/
$arrayProductos = array();

// Títulos de las columnas
$header = array('OE','PPP','Nud','Cliente','SKU','Producto','Agrupador','Motivo','Cant. Pzas','Nota');
// Anchuras de las columnas
$w = array(12,12,12,54,15,40,40,40,16,25);

/** Inicio un for para sacar los totales por producto y ruta **/
$pdf->SetFont('Times','',10);
$pdf->AddPage();
$pdf->crearEncabezado($header,$w);
/** Query para obtener el idDeposito**/
$consultaDep = "SELECT idDeposito FROM Operaciones o WHERE o.idoperacion = ".$idoperacion." LIMIT 1";
$resultadoDep = $db->consulta($consultaDep);
$rowDep = $db->fetch_assoc($resultadoDep);

$idDeposito = $rowDep['idDeposito'];

$consulta =  "SELECT
    cc.idruta,
    cc.idCambiosMotivos,
    cm.Descripcion AS desMotivo,
    cm.agrupador,
    ppp,
    cc.nud,
    c.nombre,
    pc.sku,
    pc.DescripcionInterna,
    pc.skuconver,
    p.Descripcion,
    SUM(cc.cantidad) as cantidad
    FROM
       CapturaCambios cc
    INNER JOIN
        CambiosMotivos cm ON cc.idCambiosMotivos = cm.idCambiosMotivos
    INNER JOIN
        ProductosCambios pc ON cc.idProductoCambio = pc.idProductoCambio and cc.idoperacion=pc.idoperacion
    INNER JOIN
        productos p ON pc.skuConver = p.sku
    INNER JOIN
        operaciones op ON op.idoperacion=cc.idoperacion
    INNER JOIN
        Clientes c ON c.nud = cc.nud and op.iddeposito=c.iddeposito
    WHERE
        cc.idoperacion = (SELECT idoperacion FROM operaciones WHERE iddeposito = $idDeposito)
            AND cc.FechaCambio = '$fechaIni'
            AND estatusdis <> 0
    GROUP BY cc.idruta, cc.nud, sku
 order by cc.idruta , cc.nud";

$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);

if($row['idruta']!='')
{
    $sumaTotal = 0;
    $bandera = 0;
    $nud = $row['nud'];
    $ruta = $row['idruta'];
    do{
    	$nudIni = $row['nud'];
    	$idruta = $row['idruta'];
        $ppp = $row['ppp'];
    	$rutaIni = $idruta;
    	$nudC = $row['nud'];
    	$nombre = $row['nombre'];

    	if($nud!=$nudIni){

    		$pdf->Cell($w[0],6,'',0,0,'C');
            $pdf->Cell($w[1],6,'',0,0,'C');
            $pdf->Cell($w[2],6,'',0,0,'C');
            $pdf->Cell($w[3],6,'Firma del Cliente','T',0,'C',false);
            $pdf->Cell($w[4],6,'',0,0,'C');
            $pdf->Cell($w[5],6,'',0,0);
            $pdf->Cell($w[6],6,'',0,0);
            $pdf->Cell($w[7],6,'',0,0);
            $pdf->Cell(8,6,$sumaTotal,'R',0,'C');
            $pdf->Cell(8,6,'',0,0,'C');
            $pdf->Cell($w[9],6,'',0,0);
    		$pdf->Ln();
    		$pdf->Cell(array_sum($w),0,'','T');
    		$sumaTotal=0;


    		$pdf->Ln();
    	}
    	else{

    		if($bandera ==0){

    			$bandera=1;
    		}
    		else{

    			$idruta = NULL;
                $ppp = NULL;
    			$nudC = NULL;
    			$nombre = NULL;

    		}

    	}

    	$sumaTotal = $sumaTotal + $row['cantidad'];
    	$sumaTotal = $sumaTotal;

    	if($ruta!=$rutaIni){
    		$pdf->AddPage();
    		$pdf->crearEncabezado($header,$w);
    	}


    	$nud = $nudIni;
    	$ruta = $rutaIni;

    	$pdf->Cell($w[0],6,$idruta,0,0,'C');
      $pdf->Cell($w[1],6,$ppp,0,0,'C');
    	$pdf->Cell($w[2],6,$nudC,0,0,'C');
    	$pdf->Cell($w[3],6,substr($nombre, 0,25),0,0);
    	$pdf->Cell($w[4],6,$row['sku'],0,0,'C');
      $pdf->SetFont('Times','',8);
    	$pdf->Cell($w[5],6,substr(ucwords(strtolower($row['DescripcionInterna'])),0,31),0,0);
      $pdf->SetFont('Times','',10);
      $pdf->Cell($w[6],6,$row['agrupador'],0,0,'C');
      $pdf->Cell($w[7],6,$row['desMotivo'],0,0,'C');
    	$pdf->Cell(8,6,$row['cantidad'],'R',0,'C');
      $pdf->Cell(8,6,'__',0,0,'C');
    	$pdf->Cell($w[9],6,'__',0,0,'C');
    	$pdf->Ln();



    }while($row = $db->fetch_assoc($resultado));

    $pdf->Cell($w[0],6,'',0,0,'C');
    $pdf->Cell($w[1],6,'',0,0,'C');
    $pdf->Cell($w[2],6,'',0,0,'C');
    $pdf->Cell($w[3],'Firma del Cliente','T',0,'C',false);
    $pdf->Cell($w[4],6,'',0,0,'C');
    $pdf->Cell($w[5],6,'',0,0);
    $pdf->Cell($w[6],6,'',0,0);
    $pdf->Cell($w[7],6,'',0,0);
    $pdf->Cell(8,6,$sumaTotal,'R',0,'C');
    $pdf->Cell(8,6,'__',0,0,'C');
    $pdf->Cell($w[9],6,'__',0,0);
}//fin de if validacion
$pdf->Output('reporteOperadorEntrega_'.$fechaIni.'_'.date('H:i:s').'.pdf','D');
?>
