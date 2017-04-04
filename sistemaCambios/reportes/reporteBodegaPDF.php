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
        $fechaIni = $_POST['fechaIni'];

        /** array dias **/
        $dias = array('','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');

        $fechaDia = $dias[date('N', strtotime($fechaIni))];

        if($fechaDia=='Sabado')
        {
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
        $this->Image('../img/Pepsi-logo.png',3,8,20);
        // Arial bold 15
        $this->SetFont('Times','',12);
        //Portrait
        // Movernos a la derecha
        $this->Cell(15);
        // Título
        $this->Cell(50,5,'Gepp',0,0,'L');
        $this->Cell(60,5,utf8_decode('Compañía: Gepp S de RL de CV'),0,0,'L');
        //$this->Cell(50,5,'Gepp S de RL de CV',0,0,'L');
        $this->Cell(50,5,date('Y-m-d H:i:s'),0,1,'L');

        // Movernos a la derecha
        $this->Cell(15);
        $this->Cell(50,5,'Reporte Bodega',0,0,'L');
        $this->Cell(60,5,utf8_decode('Depósito: '.$rowDep['idDeposito'].' '.$rowDep['deposito']),0,0,'L');
        //$this->Cell(50,5,$rowDep['idDeposito']." ".utf8_decode($rowDep['deposito']),0,1,'L');
        $this->Cell(50,5,'',0,1,'L');

        // Movernos a la derecha
        $this->Cell(15);
        $this->Cell(50,5,'',0,0,'L');
        $this->Cell(60,5,utf8_decode('Fecha Preventa '.$fechaIni),0,0,'L');
        $this->Cell(50,5,' ',0,1,'L');
        // Movernos a la derecha
        $this->Cell(15);
        $this->Cell(50,5,'',0,0,'L');
        $this->Cell(60,5,utf8_decode('Fecha Entrega '.$fechaEntrega),0,0,'L');
        $this->Cell(50,5,' ',0,1,'L');
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
        $this->Cell(96,10,'Nombre y Firma del Operador de Entrega','T',0,'C');
        $this->Cell(6,10,'',0,0,'C');
        $this->Cell(96,10,'Nombre y Firma del Verificador','T',0,'C');
    }

    function crearEncabezado($header,$w,$empaque)
    {

        $w1 = array($w[0],$w[1],$w[2],$w[3],$w[4]);
        $w2 = array($w[5],$w[6],$w[7],$w[8],$w[9],$w[10]);

        $this->SetX(3);
        $this->SetFont('Times','',9);
        $this->Cell(array_sum($w1),6,'SALIDA',1,0,'C');
        $this->Cell(array_sum($w2),6,'AGRUPADOR',1,0,'C');
        $this->Ln();

        $this->SetX(3);
        for($i=0;$i<count($header);$i++){
            $position = 'B';

            if($i==5){
                $position = 'BR';

            }

            $this->Cell($w[$i],7,utf8_decode($header[$i]),1,0,'C',false);
        }
        $this->Ln();

        if($empaque!='')
        {
            $this->SetX(3);
            $this->Cell($w[0],6,'',0,0);
            $this->Cell($w[1],6,'',0,0);
            $this->SetFont('Times','B',12);
            $this->SetFillColor(219,219,219);
            $this->Cell($w[2],6,$empaque,'R',0,'C');
            $this->SetFillColor(255,255,255);
            $this->SetFont('Times','',10);
            $this->Cell($w[3],6,'','R',0,'C');
            $this->Cell($w[4],6,'','R',0,'C');
            $this->Cell(14,6,'','R',0);
            $this->Cell(14,6,'','R',0);
            $this->Cell(14,6,'','R',0);
            $this->Cell(14,6,'','R',0);
            $this->Cell(14,6,'','R',0);
            $this->Cell(14,6,'','R',0);
            $this->Cell(14,6,'','R',0);
            $this->Cell(14,6,'','R',0);
            $this->Cell(7,6,'','R',0);
            $this->Cell(7,6,'','R',0);
            $this->Ln();
        }
    }

}//fin de class


// Creación del objeto de la clase heredada
$pdf = new PDF('P','mm','Letter');

/** Query para obtener el idDeposito**/
$consultaDep = "SELECT idDeposito FROM Operaciones o WHERE o.idoperacion = ".$idoperacion." LIMIT 1";
$resultadoDep = $db->consulta($consultaDep);
$rowDep = $db->fetch_assoc($resultadoDep);

$idDeposito = $rowDep['idDeposito'];

$consulta = "SELECT
    idruta,
    sku,
    idproductocambio,
    idempaque,
    dempaque,
    descripcion,
    FLOOR(SUM(csio2)) AS csio,
    SUM(csio) AS sobra,
    SUM(DefectoProduccion) AS DefectoProduccion,
    SUM(MermaOperativa) AS MermaOperativa,
    SUM(ProductoCaduco) AS ProductoCaduco,
    SUM(RetiroParaDonativo) AS RetiroParaDonativo,
    SUM(DefectoProduccion) + SUM(MermaOperativa) + SUM(ProductoCaduco) + SUM(RetiroParaDonativo) AS total
FROM
    (SELECT
            sku,
            idempaque,
            dempaque,
            descripcion,
            idruta,
            idproductocambio,
            SUM(cantidad)/cavidades AS csio2,
            SUM(cantidad) MOD cavidades AS csio,
            IF(agrupador = 'Defecto Produccion', SUM(cantidad), 0) AS DefectoProduccion,
            IF(agrupador = 'Merma Operativa', SUM(cantidad), 0) AS MermaOperativa,
            IF(agrupador = 'Producto Caduco', SUM(cantidad), 0) AS ProductoCaduco,
            IF(agrupador = 'Retiro para donativo', SUM(cantidad), 0) AS RetiroParaDonativo
    FROM
        (SELECT
            sku,
            idempaque,
            dempaque,
            descripcion,
            idruta,
            idproductocambio,
            idcambiosmotivos,
            agrupador,
            cavidades,
            SUM(cantidad) cantidad
    FROM
        (SELECT
    p.sku AS sku,
            pr.idpresentacion AS idempaque,
            pr.descripcion AS dempaque,
            p.descripcion AS descripcion,
            idruta,
            cc.idproductocambio,
            cc.idcambiosmotivos,
            agrupador,
            cavidades,
            cantidad
    FROM

        CapturaCambios cc
        INNER JOIN cambiosmotivos cm ON cm.idcambiosmotivos = cc.idcambiosmotivos
            INNER JOIN
        ProductosCambios pc ON cc.idProductoCambio = pc.idProductoCambio
            INNER JOIN
        productos p ON pc.skuConver = p.sku
            INNER JOIN
        presentacion pr ON pr.idpresentacion = p.idpresentacion

    WHERE
        cc.FechaCambio = '$fechaIni'
        AND cc.idoperacion = (SELECT idoperacion FROM operaciones WHERE iddeposito = $idDeposito)
        AND estatusDis !=0) datos
    GROUP BY idruta, idproductocambio, idcambiosmotivos , agrupador) datos2
    GROUP BY idruta, dempaque, sku DESC) datos3
GROUP BY idruta, idproductocambio
ORDER BY idruta, dempaque DESC";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);

// Títulos de las columnas
$header = array('Ruta','SKU','Producto','CSIO','Pzas','Defecto Producción','Merma Operativa','Producto Caduco','Retiro Para Donativo','Tot. Pzas');

// Anchuras de las columnas
$w = array(8,8,50,8,8,28,28,28,28,14);
$pdf->AddPage();
$pdf->crearEncabezado($header,$w,$row['dempaque']);

$sumaTotal = 0;
$sumaDP = 0;
$sumaMO = 0;
$sumaPC = 0;
$sumaRD = 0;
$idruta = $row['idruta'];
$idempaque = $row['idempaque'];
$bandera = 0;

do{

    $idrutaIni = $row['idruta'];
    $empaqueIni = $row['idempaque'];
    $ruta = $row['idruta'];

    /****** Preguntamos si la ruta cambio *******/
    if($idruta!=$idrutaIni){

        $pdf->SetX(3);
        $pdf->SetFont('Times','',12);
        $pdf->Cell($w[0]+$w[1]+$w[2],6,'Totales','TBR',0,'R');
        $pdf->Cell($w[3],6,$sumaCSIO,'TBR',0,'C');
        $pdf->Cell($w[4],6,$sumaSobrante,'TBR',0,'C');
        $pdf->Cell(14,6,$sumaDP,'TBR',0,'C');
        $pdf->Cell(14,6,'','TBR',0,'C');
        $pdf->Cell(14,6,$sumaMO,'TBR',0,'C');
        $pdf->Cell(14,6,'','TBR',0,'C');
        $pdf->Cell(14,6,$sumaPC,'TBR',0,'C');
        $pdf->Cell(14,6,'','TBR',0,'C');
        $pdf->Cell(14,6,$sumaRD,'TBR',0,'C');
        $pdf->Cell(14,6,'','TBR',0,'C');
        $pdf->Cell(7,6,$sumaTotal,'TBR',0,'C');
        $pdf->Cell(7,6,'','TBR',0,'C');
        //$pdf->Cell($w[8],6,'',0,0);
        $pdf->Ln();

        $sumaCSIO=0;
        $sumaSobrante=0;
        $sumaTotal=0;
        $sumaDP=0;
        $sumaMO=0;
        $sumaPC=0;
        $sumaRD=0;
        $pdf->AddPage();
        $pdf->SetFont('Times','',9);
        $pdf->crearEncabezado($header,$w,'');
    }

    else{

        if($bandera==0){
            $bandera=1;

        }
        else{
            $ruta = NULL;
        }
    }
    /*** fin de comprabacion de cambio de ruta ***/

    /*** Comprobamos si cambio de empaque ***/
    if ($idempaque != $empaqueIni) {

        $pdf->SetX(3);
        $pdf->Cell($w[0],6,'',0,0);
        $pdf->Cell($w[1],6,'',0,0);
        $pdf->SetFont('Times','B',12);
        $pdf->SetFillColor(219,219,219);
        $pdf->Cell($w[2],6,$row['dempaque'],'R',0,'C');
        $pdf->SetFillColor(255,255,255);
        $pdf->SetFont('Times','U',10);
        $pdf->Cell($w[3],6,'','R',0,'C');
        $pdf->Cell($w[4],6,'','R',0,'C');
        $pdf->Cell(14,6,'','R',0);
        $pdf->Cell(14,6,'','R',0);
        $pdf->Cell(14,6,'','R',0);
        $pdf->Cell(14,6,'','R',0);
        $pdf->Cell(14,6,'','R',0);
        $pdf->Cell(14,6,'','R',0);
        $pdf->Cell(14,6,'','R',0);
        $pdf->Cell(14,6,'','R',0);
        $pdf->Cell(7,6,'','R',0);
        $pdf->Cell(7,6,'','R',0);
        $pdf->SetFont('Times','',8);
        //$pdf->Cell($w[8],6,'',0,0);
        $pdf->Ln();
    }

    $sumaCSIO = $sumaCSIO + $row['csio'];
    $sumaCSIO = $sumaCSIO;

    $sumaSobrante = $sumaSobrante + $row['sobra'];
    $sumaSobrante = $sumaSobrante;

    $sumaTotal = $sumaTotal + $row['total'];
    $sumaTotal = $sumaTotal;

    $sumaDP = $sumaDP + $row['DefectoProduccion'];
    $sumaDP = $sumaDP;

    $sumaMO = $sumaMO + $row['MermaOperativa'];
    $sumaMO = $sumaMO;

    $sumaPC = $sumaPC + $row['ProductoCaduco'];
    $sumaPC = $sumaPC;

    $sumaRD = $sumaRD + $row['RetiroParaDonativo'];
    $sumaRD = $sumaRD;

    $pdf->SetX(3);
    $pdf->Cell($w[0],6,$ruta,0,0,'C');
    $pdf->Cell($w[1],6,$row['sku'],0,0,'C');
    $pdf->SetFont('Times','',8);
    $pdf->Cell($w[2],6,substr(ucwords(strtolower($row['descripcion'])),0,38),'R',0,'C');
    $pdf->SetFont('Times','U',10);
    $pdf->Cell($w[3],6,$row['csio'],'R',0,'C');
    $pdf->Cell($w[4],6,$row['sobra'],'R',0,'C');
    $pdf->Cell(14,6," ".$row['DefectoProduccion']." ",'R',0,'C');//Defecto Producción
    $pdf->Cell(14,6,'    ','R',0,'C');
    $pdf->Cell(14,6," ".$row['MermaOperativa']." ",'R',0,'C');//Merma Operativa
    $pdf->Cell(14,6,'    ','R',0,'C');
    $pdf->Cell(14,6," ".$row['ProductoCaduco']." ",'R',0,'C');//Producto Caduco
    $pdf->Cell(14,6,'    ','R',0,'C');
    $pdf->Cell(14,6," ".$row['RetiroParaDonativo']." ",'R',0,'C');//Retiro para Donativo
    $pdf->Cell(14,6,'    ','R',0,'C');
    $pdf->Cell(7,6," ".$row['total']." ",'R',0,'C');
    $pdf->Cell(7,6,'    ','R',0,'C');
    $pdf->Ln();

    $idruta = $idrutaIni;
    $idempaque = $empaqueIni;

}while($row = $db->fetch_assoc($resultado));

$pdf->SetX(3);
$pdf->SetFont('Times','U',10);
$pdf->Cell($w[0]+$w[1]+$w[2],6,'Totales','TBR',0,'R');
$pdf->Cell($w[3],6,$sumaCSIO,'TBR',0,'C');
$pdf->Cell($w[4],6,$sumaSobrante,'TBR',0,'C');
$pdf->Cell(14,6,$sumaDP,'TBR',0,'C');
$pdf->Cell(14,6,'','TBR',0,'C');
$pdf->Cell(14,6,$sumaMO,'TBR',0,'C');
$pdf->Cell(14,6,'','TBR',0,'C');
$pdf->Cell(14,6,$sumaPC,'TBR',0,'C');
$pdf->Cell(14,6,'','TBR',0,'C');
$pdf->Cell(14,6,$sumaRD,'TBR',0,'C');
$pdf->Cell(14,6,'','TBR',0,'C');
$pdf->Cell(7,6,$sumaTotal,'TBR',0,'C');
$pdf->Cell(7,6,'','TBR',0,'C');
//$pdf->Cell($w[8],6,'',0,0);
$pdf->Ln();
$pdf->Output('reporteBodega_'.$fechaIni.'_'.date('H:i:s').'.pdf','D');
?>
