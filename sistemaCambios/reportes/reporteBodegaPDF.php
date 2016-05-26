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
        $fechaIni = $_POST['fechaIni'];
        $fechaFin = $_POST['fechaFin'];

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
        $this->Image('../img/Pepsi-logo.png',0,8,33);
        // Arial bold 15
        $this->SetFont('Times','',12);  
        //Portrait
        // Movernos a la derecha
        $this->Cell(15);
        // Título
        $this->Cell(40,5,'Gepp',0,0,'L');
        $this->Cell(50,5,utf8_decode('Compañía:'),0,0,'L');
        $this->Cell(50,5,'Gepp S de RL de CV',0,0,'L');
        $this->Cell(50,5,date('Y-m-d H:i:s'),0,1,'L');

        // Movernos a la derecha
        $this->Cell(15);
        $this->Cell(40,5,'Reporte de Cambios',0,0,'L');
        $this->Cell(50,5,utf8_decode('Depósito:'),0,0,'L');
        $this->Cell(50,5,$rowDep['idDeposito']." ".utf8_decode($rowDep['deposito']),0,1,'L');
        // Movernos a la derecha
        $this->Cell(15);
        $this->Cell(40,5,'',0,0,'L');
        $this->Cell(50,5,utf8_decode('Fecha Preventa'),0,0,'L');
        $this->Cell(50,5,$fechaIni,0,1,'L');
        // Movernos a la derecha
        $this->Cell(15);
        $this->Cell(40,5,'',0,0,'L');
        $this->Cell(50,5,utf8_decode('Fecha Entrega'),0,0,'L');
        $this->Cell(50,5,$fechaEntrega,0,1,'L');
        // Salto de línea
        $this->Ln(20);
    }

    function Footer()
    {
        // Go to 1.5 cm from bottom
        $this->SetY(-15);
        // Select Arial italic 8
        $this->SetFont('Arial','I',8);
        // Print centered page number
        $this->Cell(96,10,'Nombre y Firma del Vendedor','T',0,'C');
        $this->Cell(6,10,'',0,0,'C');
        $this->Cell(96,10,'Nombre y Firma del Verificador','T',0,'C');
    }

    function crearEncabezado($header,$w,$empaque){

        $w1 = array($w[0],$w[1],$w[2],$w[3]);
        $w2 = array($w[4],$w[5],$w[6],$w[7],$w[8]);

        $this->Cell(array_sum($w1),6,'SALIDA',1,0,'C');
        $this->Cell(array_sum($w2),6,'ENTRADA',1,0,'C');
        $this->Ln();

        for($i=0;$i<count($header);$i++){
            $position = 'B';

            if($i==3){
                $position = 'BR';

            }

            $this->Cell($w[$i],7,utf8_decode($header[$i]),$position,0,'C',false);
        }
        $this->Ln();

        if($empaque!=''){
            $this->Cell($w[0],6,'',0,0);
            $this->Cell($w[1],6,'',0,0);
            $this->SetFont('Times','BU',12);
            $this->SetFillColor(219,219,219);
            $this->Cell($w[2],6,$empaque,0,0,'C');
            $this->SetFillColor(255,255,255);
            $this->SetFont('Times','',10);
            $this->Cell($w[3],6,'','TR',0,'C');
            $this->Cell($w[4],6,'',0,0);
            $this->Cell($w[5],6,'',0,0);
            $this->Cell($w[6],6,'',0,0);
            $this->Cell($w[7],6,'',0,0);
            $this->Cell($w[8],6,'',0,0);
            $this->Ln();
        } 
    }


}


// Creación del objeto de la clase heredada
$pdf = new PDF('P','mm','Letter');

/** Query para obtener el idDeposito**/
$consultaDep = "SELECT idDeposito FROM Operaciones o WHERE o.idoperacion = ".$idoperacion." LIMIT 1";
$resultadoDep = $db->consulta($consultaDep);
$rowDep = $db->fetch_assoc($resultadoDep);

$idDeposito = $rowDep['idDeposito'];

/*$consulta = "SELECT 
    cc.idruta,
    pc.idempaque,
    em.descripcion AS dempaque,
    pc.sku,
    pc.DescripcionInterna,
    pc.skuconver,
    p.descripcion,
    cc.nud,
    SUM(cc.cantidad) AS cantidad    
    FROM
        CapturaCambios cc
            INNER JOIN
        ProductosCambios pc ON cc.idProductoCambio = pc.idProductoCambio
            INNER JOIN 
        productos p ON pc.skuConver = p.sku
            INNER JOIN
        empaque em ON pc.idempaque = em.idempaque
    WHERE
        cc.FechaCambio = '$fechaPreventa'
        AND cc.idoperacion = $idoperacion
        AND estatusDis !=0
    GROUP BY cc.idruta, pc.skuconver
    ORDER BY cc.idruta,em.descripcion DESC";*/

$consulta = "SELECT 
    cc.idruta,
    pc.sku,
    pr.descripcion AS dempaque,
    pr.idpresentacion AS idempaque,
    pc.DescripcionInterna,
    pc.skuconver,
    p.descripcion,
    cc.nud,
    SUM(cc.cantidad) AS cantidad    
    FROM
        CapturaCambios cc
            INNER JOIN
        ProductosCambios pc ON cc.idProductoCambio = pc.idProductoCambio
            INNER JOIN 
        productos p ON pc.skuConver = p.sku
            INNER JOIN
        presentacion pr ON pr.idpresentacion = p.idpresentacion
          
    WHERE
        cc.FechaCambio = '$fechaIni'
        AND cc.idoperacion = $idoperacion
        AND estatusDis !=0
    GROUP BY cc.idruta, pc.skuconver
    ORDER BY cc.idruta,pr.descripcion DESC";    

$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);

/** Creo un array para guardar el id producto cambio **/
$arrayProductos = array();
$contP = 0;

// Títulos de las columnas
//$header = array('Ruta','SKU','Producto','SKU Conv.','Producto Conv.','Cant. Pzas','Merma','Caduco','Cobro','Devolución','Total');
$header = array('Ruta','SKU Conv.','Producto Conv.','Cant. Pzas','Merma','Caduco','Cobro','Devolución','Total');

// Anchuras de las columnas
$w = array(11,14,55,20,20,20,20,20,20);
$pdf->SetFont('Times','',10);
$pdf->AddPage();
$pdf->crearEncabezado($header,$w,$row['dempaque']);

if($row['idruta']!=''){
    $sumaTotal = 0;
    $idruta = $row['idruta'];
    $idempaque = $row['idempaque'];
    $bandera = 0;

    do{

        $idrutaIni = $row['idruta'];
        $empaqueIni = $row['idempaque'];
        $ruta = $row['idruta'];

        /****** Preguntamos si la ruta cambio *******/    
        if($idruta!=$idrutaIni){

            $pdf->Cell($w[0],6,'',0,0);
            $pdf->Cell($w[1],6,'',0,0);
            $pdf->Cell($w[2],6,'',0,0);
            $pdf->Cell($w[3],6,$sumaTotal,'TR',0,'C');
            $pdf->Cell($w[4],6,'',0,0);
            $pdf->Cell($w[5],6,'',0,0);
            $pdf->Cell($w[6],6,'',0,0);
            $pdf->Cell($w[7],6,'',0,0);
            $pdf->Cell($w[8],6,'',0,0);
            $pdf->Ln();

            $sumaTotal=0;
            $pdf->AddPage();
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
            
            $pdf->Cell($w[0],6,'',0,0);
            $pdf->Cell($w[1],6,'',0,0);
            $pdf->SetFont('Times','BU',12);
            $pdf->SetFillColor(219,219,219);
            $pdf->Cell($w[2],6,$row['dempaque'],0,0,'C');
            $pdf->SetFillColor(255,255,255);
            $pdf->SetFont('Times','',10);
            $pdf->Cell($w[3],6,'','TR',0,'C');
            $pdf->Cell($w[4],6,'',0,0);
            $pdf->Cell($w[5],6,'',0,0);
            $pdf->Cell($w[6],6,'',0,0);
            $pdf->Cell($w[7],6,'',0,0);
            $pdf->Cell($w[8],6,'',0,0);
            $pdf->Ln();
        }

        $sumaTotal = $sumaTotal + $row['cantidad'];
        $sumaTotal = $sumaTotal;

       
        $pdf->Cell($w[0],6,$ruta,0,0,'C');
        $pdf->Cell($w[1],6,$row['skuconver'],0,0,'C');
        $pdf->SetFont('Times','',8);
        $pdf->Cell($w[2],6,substr(ucwords(strtolower($row['descripcion'])),0,38),0,0,'C');
        $pdf->SetFont('Times','',10);
        $pdf->Cell($w[3],6,$row['cantidad'],'R',0,'C');
        $pdf->Cell($w[4],6,'______',0,0,'C');
        $pdf->Cell($w[5],6,'______',0,0,'C');
        $pdf->Cell($w[6],6,'______',0,0,'C');
        $pdf->Cell($w[7],6,'______',0,0,'C');
        $pdf->Cell($w[8],6,'______',0,0,'C');
        $pdf->Ln();

        $idruta = $idrutaIni;
        $idempaque = $empaqueIni;


    }while($row = $db->fetch_assoc($resultado));

    $pdf->Cell($w[0],6,'',0,0,'C');
    $pdf->Cell($w[1],6,'',0,0,'C');
    $pdf->Cell($w[2],6,'',0,0);
    $pdf->Cell($w[3],6,$sumaTotal,'TR',0,'C');
    $pdf->Cell($w[4],6,'',0,0,'C');
    $pdf->Cell($w[5],6,'',0,0,'C');
    $pdf->Cell($w[6],6,'',0,0,'C');
    $pdf->Cell($w[7],6,'',0,0,'C');
    $pdf->Cell($w[8],6,'',0,0,'C');
    $pdf->Ln();
}// fin de if validacion
$pdf->Output('reporteBodega_'.$fechaIni.'_'.date('H:i:s').'.pdf','D');
?>