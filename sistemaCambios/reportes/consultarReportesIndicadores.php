<?php 
if (!isset($_SESSION)) 
{
	session_start();
}
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
		$fechaDe = $_POST['fechaDe'];
		$fechaPara = $_POST['fechaPara'];
		$jt = $_POST['jt'];
		$seg = $_POST['seg'];
		$mot = $_POST['mot'];

		if($seg==0){
			$seg = 'Todos';
		}

        /** Query para obtener el idDeposito**/
        $consultaDep = "SELECT d.idDeposito, d.deposito, r.region FROM Operaciones o 
        INNER JOIN Deposito d ON d.idDeposito = o.idDeposito 
        INNER JOIN Zona z ON z.idZona = d.idZona 
        INNER JOIN Region r ON r.idRegion = z.idRegion 
        WHERE o.idoperacion = ".$idoperacion." LIMIT 1";
        $resultadoDep = $db->consulta($consultaDep);
        $rowDep = $db->fetch_assoc($resultadoDep);

        /** Query para obtener al JT **/
        if($jt!=0)
        {
	        $consultaJT = "SELECT nombre FROM usrcambios WHERE numempleado = $jt AND idoperacion = ".$idoperacion." LIMIT 1";
	        $resultadoJT = $db->consulta($consultaJT);
	        $rowJT = $db->fetch_assoc($resultadoJT);
    	}
    	else{
    		$rowJT['nombre'] = 'Todos';
    	}

    	/** Query para obtener Motivo **/
    	if($mot!=0){    		$consultaMot = "SELECT descripcion FROM cambiosmotivos WHERE idoperacion = $idoperacion AND idCambiosMotivos = $mot LIMIT 1";
    		$resultadoMot = $db->consulta($consultaMot);
    		$rowMot = $db->fetch_assoc($resultadoMot);
    	}
    	else{
    		$rowMot['descripcion'] = 'Todos';
    	}

        // Logo
        $this->Image('../img/Pepsi-logo.png',0,8,33);
        // Arial bold 15
        $this->SetFont('Times','',12);  
        //Portrait
        // Movernos a la derecha
        $this->Cell(15);
        // Título
        $this->Cell(95,5,'Gepp',0,0,'L');
        $this->Cell(40,5,utf8_decode('Compañía: '),0,0,'L');
        $this->Cell(95,5,'Gepp S de RL de CV',0,1,'L');
        //$this->Cell(55,5,date('Y-m-d H:i:s'),1,1,'L');

        // Movernos a la derecha
        $this->Cell(15);
        $this->Cell(95,5,'Reporte de Cambios',0,0,'L');
        $this->Cell(40,5,utf8_decode('Depósito: '),0,0,'L');
        $this->Cell(95,5,$rowDep['idDeposito']." ".utf8_decode(ucwords(strtolower($rowDep['deposito']))),0,1,'L');
        // Movernos a la derecha
        $this->Cell(15);
        $this->Cell(95,5,'JT: '.utf8_decode(ucwords(strtolower($rowJT['nombre']))),0,0,'L');
        $this->Cell(40,5,utf8_decode('De: '),0,0,'L');
        $this->Cell(95,5,$fechaDe,0,1,'L');
        // Movernos a la derecha
        $this->Cell(15);
        $this->Cell(95,5,'Segmento:'." ".utf8_decode($seg),0,0,'L');
        $this->Cell(40,5,utf8_decode('Para: '),0,0,'L');
        $this->Cell(95,5,$fechaPara,0,1,'L');
        // Movernos a la derecha
        $this->Cell(15);
        $this->Cell(95,5,'Motivo:'." ".utf8_decode(ucwords(strtolower($rowMot['descripcion']))),0,0,'L');
        $this->Cell(40,5,'',0,0,'L');
        $this->Cell(95,5,'',0,1,'L');
        // Salto de línea
        $this->Ln(20);
    }
}

// Creación del objeto de la clase heredada
$pdf = new PDF('L','mm','Letter');

$pdf->SetFont('Times','',10);
$pdf->AddPage();

$idoperacion = $_SESSION['idoperacion'];
$fechaDe = $_POST['fechaDe'];
$fechaPara = $_POST['fechaPara'];
$jt = $_POST['jt'];
$seg = $_POST['seg'];
$mot = $_POST['mot'];

$condicionJT = NULL;
$condicionSeg = NULL;
$condicionMo = NULL;

if($jt!=0){
    $condicionJT = " AND u.NumEmpleado = $jt ";
}

if($eg!=0){

    $condicionSeg = " AND p.Segmento = '$seg' ";
}

if($mot!=0){
    $condicionMo = " AND cc.idCambiosMotivos = $mot ";
}
/** Consulta para JT **/
$consultaJT = "SELECT 
    UPPER(u.Nombre) AS nombre,
    SUM(cc.cantidad) AS piezassolicitadas

FROM
    usrcambios u
        INNER JOIN
    gruposupervision gs ON u.NumEmpleado = gs.NumEmpleado
        INNER JOIN
    rutascambios rc ON gs.idgruposupervision = rc.idgruposupervision
        INNER JOIN
    usrcambios u2 ON rc.ruta = u2.ppp
        INNER JOIN
    capturacambios cc ON u2.NumEmpleado = cc.NumEmpleado
        INNER JOIN
    productoscambios pc ON cc.idproductocambio = pc.idProductoCambio
        INNER JOIN
    productos p ON pc.sku = p.sku
    WHERE cc.idoperacion = $idoperacion AND cc.FechaCambio BETWEEN '$fechaDe' AND '$fechaPara' $condicionJT $condicionMo $condicionSeg GROUP BY u.NumEmpleado";
$resultadoJT = $db->consulta($consultaJT);
$rowJT = $db->fetch_assoc($resultadoJT);

/** Se arma la tabla de por JT **/

// Títulos de las columnas
$header = array('JT','PZAS');
// Anchuras de las columnas
$w = array(80,20);

$pdf->SetXY(150,55);
/** Movernos a la derecha **/

for($i=0;$i<count($header);$i++){
    $pdf->Cell($w[$i],7,utf8_decode($header[$i]),1,0,'C',false);
}
$pdf->Ln();

$y = 62;
$totalPzaP = 0;
do{ 
    $pdf->SetXY(150,$y);
    $pdf->Cell($w[0],7,utf8_decode($rowJT['nombre']),1,0,'L',false);
    $pdf->Cell($w[1],7,utf8_decode($rowJT['piezassolicitadas']),1,0,'R',false);
    $y = $y + 7;
    $totalPzaJ = $totalPzaJ + $rowJT['piezassolicitadas'];
    $pdf->Ln();
}while($rowJT = $db->fetch_assoc($resultadoJT));
$pdf->SetXY(150,$y);
$pdf->Cell($w[0],7,'TOTAL',1,0,'L',false);
$y = $y + 7;
$pdf->Cell($w[1],7,$totalPzaJ,1,1,'R',false);
/** Consulta Presentacion **/
$consultaPre = "SELECT 
    UPPER(p.presentacion) AS presentacion,
    SUM(cc.cantidad) AS piezassolicitadas
FROM
    usrcambios u
        INNER JOIN
    gruposupervision gs ON u.NumEmpleado = gs.NumEmpleado
        INNER JOIN
    rutascambios rc ON gs.idgruposupervision = rc.idgruposupervision
        INNER JOIN
    usrcambios u2 ON rc.ruta = u2.ppp
        INNER JOIN
    capturacambios cc ON u2.NumEmpleado = cc.NumEmpleado
        INNER JOIN
    productoscambios pc ON cc.idproductocambio = pc.idProductoCambio
        INNER JOIN
    productos p ON pc.sku = p.sku
WHERE
    cc.idoperacion = $idoperacion
        AND cc.FechaCambio BETWEEN '$fechaDe' AND '$fechaPara' $condicionJT $condicionMo $condicionSeg
GROUP BY p.presentacion";
$resultadoPre = $db->consulta($consultaPre);
$rowPre = $db->fetch_assoc($resultadoPre);

/** Se arma la tabla de por presentacion **/

// Títulos de las columnas
$header = array('PRESENTACIÓN','PZAS');
// Anchuras de las columnas
$w = array(46,20);
/** Movernos a la derecha **/
//$pdf->Cell(15);

$pdf->SetXY(10,55);
for($i=0;$i<count($header);$i++){
    $pdf->Cell($w[$i],7,utf8_decode($header[$i]),1,0,'C',false);
}
$pdf->Ln();

$totalPzaP = 0;
do{
    $pdf->Cell($w[0],7,utf8_decode($rowPre['presentacion']),1,0,'L',false);
    $pdf->Cell($w[1],7,utf8_decode($rowPre['piezassolicitadas']),1,0,'R',false);
    $totalPzaP = $totalPzaP + $rowPre['piezassolicitadas'];
    $pdf->Ln();
}while($rowPre = $db->fetch_assoc($resultadoPre));
$pdf->Cell($w[0],7,'TOTAL',1,0,'L',false);
$pdf->Cell($w[1],7,$totalPzaP,1,1,'R',0);
$pdf->Ln();
/***************************************************************************************************************************************************************/

/** Consulta para segmento **/
$consultaSeg = "SELECT 
    UPPER(p.segmento) AS segmento,
    SUM(cc.cantidad) AS piezassolicitadas
FROM
    usrcambios u
        INNER JOIN
    gruposupervision gs ON u.NumEmpleado = gs.NumEmpleado
        INNER JOIN
    rutascambios rc ON gs.idgruposupervision = rc.idgruposupervision
        INNER JOIN
    usrcambios u2 ON rc.ruta = u2.ppp
        INNER JOIN
    capturacambios cc ON u2.NumEmpleado = cc.NumEmpleado
        INNER JOIN
    productoscambios pc ON cc.idproductocambio = pc.idProductoCambio
        INNER JOIN
    productos p ON pc.sku = p.sku
WHERE
    cc.idoperacion = $idoperacion
        AND cc.FechaCambio BETWEEN '$fechaDe' AND '$fechaPara' $condicionJT $condicionMo $condicionSeg
GROUP BY p.Segmento;";
$resultadoSeg = $db->consulta($consultaSeg);
$rowSeg = $db->fetch_assoc($resultadoSeg);

/** Se arma la tabla de por Segmento **/

// Títulos de las columnas
$header = array('SEGMENTO','PZAS');
// Anchuras de las columnas
$w = array(46,20);
/** Movernos a la derecha **/
//$pdf->Cell(15);

for($i=0;$i<count($header);$i++){
    $pdf->Cell($w[$i],7,utf8_decode($header[$i]),1,0,'C',false);
}
$pdf->Ln();

$totalPzaS = 0;
do{
    $pdf->Cell($w[0],7,utf8_decode($rowSeg['segmento']),1,0,'L',false);
    $pdf->Cell($w[1],7,utf8_decode($rowSeg['piezassolicitadas']),1,0,'R',false);
    $totalPzaS = $totalPzaS + $rowSeg['piezassolicitadas'];
    $pdf->Ln();
}while($rowSeg = $db->fetch_assoc($resultadoSeg));
$pdf->Cell($w[0],7,'TOTAL',1,0,'L',false);
$pdf->Cell($w[1],7,$totalPzaS,1,1,'R',false);
$pdf->Ln();
/***************************************************************************************************************************************************************/

/** Consulta para motivos **/
$consultaMo = "SELECT 
    UPPER(cm.Descripcion) AS motivo,
    SUM(cc.cantidad) AS piezassolicitadas
FROM
    usrcambios u
        INNER JOIN
    gruposupervision gs ON u.NumEmpleado = gs.NumEmpleado
        INNER JOIN
    rutascambios rc ON gs.idgruposupervision = rc.idgruposupervision
        INNER JOIN
    usrcambios u2 ON rc.ruta = u2.ppp
        INNER JOIN
    capturacambios cc ON u2.NumEmpleado = cc.NumEmpleado
        INNER JOIN
    productoscambios pc ON cc.idproductocambio = pc.idProductoCambio
        INNER JOIN
    productos p ON pc.sku = p.sku
        INNER JOIN 
    cambiosmotivos cm ON cc.idCambiosMotivos = cm.idCambiosMotivos
    WHERE cc.idoperacion = $idoperacion AND cc.FechaCambio BETWEEN '$fechaDe' AND '$fechaPara' $condicionJT $condicionMo $condicionSeg GROUP BY cc.idCambiosMotivos";
$resultadoMo = $db->consulta($consultaMo);
$rowMo = $db->fetch_assoc($resultadoMo);

/** Se arma la tabla de por motivos **/

// Títulos de las columnas
$header = array('MOTIVOS','PZAS');
// Anchuras de las columnas
$w = array(46,20);
/** Movernos a la derecha **/
//$pdf->Cell(15);

for($i=0;$i<count($header);$i++){
    $pdf->Cell($w[$i],7,utf8_decode($header[$i]),1,0,'C',false);
}
$pdf->Ln();

$totalPzaP = 0;
do{
    $pdf->Cell($w[0],7,utf8_decode($rowMo['motivo']),1,0,'L',false);
    $pdf->Cell($w[1],7,utf8_decode($rowMo['piezassolicitadas']),1,0,'R',false);
    $totalPzaM = $totalPzaM + $rowMo['piezassolicitadas'];
    $pdf->Ln();
}while($rowMo = $db->fetch_assoc($resultadoMo));
$pdf->Cell($w[0],7,'TOTAL',1,0,'L',false);
$pdf->Cell($w[1],7,$totalPzaM,1,1,'R',false);
$pdf->Ln();
/*************************************************************************************************************************************************/
$pdf->Ln();

$pdf->Output('reporteIndicadores_'.$fechaDe.'_'.$fechaPara.'.pdf','D');
?>