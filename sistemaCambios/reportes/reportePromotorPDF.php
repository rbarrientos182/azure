<?php
if (!isset($_SESSION))
{
    session_start();
}
date_default_timezone_set('America/Mexico_City');
require_once('../fpdf/fpdf.php');
require_once('../clases/class.MySQL.php');

$db = new MySQL();

$idoperacion = $_SESSION['idoperacion'];
$numEmpleado = $_SESSION['NumEmpleado'];
$fechaPreventa = $_POST['fechaPre'];

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {

        require_once('../clases/class.MySQL.php');
        $db = new MySQL();

        $idoperacion = $_SESSION['idoperacion'];
        $numEmpleado = $_SESSION['NumEmpleado'];
        $fechaPreventa = $_POST['fechaPre'];

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
        $consultaDep = "SELECT
            d.idDeposito, d.deposito, r.region, u.Nombre, u.PPP
        FROM
            Operaciones o
                INNER JOIN
            Deposito d ON d.idDeposito = o.idDeposito
                INNER JOIN
            Zona z ON z.idZona = d.idZona
                INNER JOIN
            Region r ON r.idRegion = z.idRegion
                INNER JOIN
            usrcambios u ON o.idoperacion = u.idoperacion
        WHERE
            o.idoperacion = $idoperacion
                AND u.NumEmpleado = $numEmpleado LIMIT 1";
        $resultadoDep = $db->consulta($consultaDep);
        $rowDep = $db->fetch_assoc($resultadoDep);

        // Logo
        $this->Image('../img/Pepsi-logo.png',5,2,23);
        // Arial bold 15
        $this->SetFont('Times','',8);
        //Portrait

        // Título
        //$this->setY(15);
        // Movernos a la derecha
        $this->Cell(15);
        $this->Cell(55,5,'Gepp',0,0,'L');
        $this->Cell(65,5,utf8_decode('Compañía:'),0,0,'L');
        $this->Cell(65,5,'Gepp S de RL de CV',0,1,'L');


        // Movernos a la derecha
        //$this->setY(20);
        $this->Cell(15);
        $this->Cell(55,5,'Reporte de Promotor',0,0,'L');
        $this->Cell(55,5,utf8_decode('Depósito:'),0,0,'L');
        $this->Cell(55,5,$rowDep['idDeposito']." ".utf8_decode($rowDep['deposito']),0,1,'L');

        // Movernos a la derecha
        //$this->setY(25);
        $this->Cell(15);
        $this->Cell(55,5,'No. Empleado: '.$numEmpleado,0,0,'L');
        $this->Cell(55,5,utf8_decode('Fecha Preventa'),0,0,'L');
        $this->Cell(55,5,$fechaPreventa,0,1,'L');

        // Movernos a la derecha
        //$this->setY(30);
        $this->Cell(15);
        $this->Cell(55,5,'PPP: '.$rowDep['PPP'],0,0,'L');
        $this->Cell(55,5,utf8_decode('Fecha Entrega'),0,0,'L');
        $this->Cell(55,5,$fechaEntrega,0,1,'L');

        //$this->setY(30);
        $this->Cell(15);
        $this->Cell(55,5,utf8_decode(ucfirst($rowDep['Nombre'])),0,0,'L');
        $this->Cell(55,5,date('Y-m-d H:i:s'),0,1,'L');
        // Salto de línea
        $this->Ln(20);
    }

    function crearEncabezado($header,$w){

        for($i=0;$i<count($header);$i++){
            $position = 'B';

            /*if($i==3){
                $position = 'BR';

            }*/

            $this->Cell($w[$i],6,utf8_decode($header[$i]),$position,0,'C',false);
        }
        $this->Ln();
    }

    function Footer()
    {
        // Go to 1.5 cm from bottom
        $this->SetY(-11);
        $this->Cell(45);
        // Select Arial italic 8
        $this->SetFont('Arial','I',8);
        // Print centered page number
        $this->Cell(6,10,'',0,0,'C');
        $this->Cell(96,10,'Nombre y Firma','T',0,'C');
        $this->Cell(0,10,utf8_decode('Página ').$this->PageNo(),0,0,'R');

    }
}


// Creación del objeto de la clase heredada
$pdf = new PDF('P','mm','Letter');

/** Query para obtener el idDeposito**/
$consultaDep = "SELECT idDeposito FROM Operaciones o WHERE o.idoperacion = ".$idoperacion." LIMIT 1";
$resultadoDep = $db->consulta($consultaDep);
$rowDep = $db->fetch_assoc($resultadoDep);

$idDeposito = $rowDep['idDeposito'];


/** Query para obtener los cambios **/
$consulta = "SELECT
    pc.sku,
    cc.cantidad,
    pr.descripcion AS dempaque,
    pc.DescripcionInterna,
    pc.skuconver,
    p.descripcion,
    cc.nud,
    cl.nombre,
    cm.descripcion AS motivo
    FROM
        CapturaCambios cc
            INNER JOIN
        ProductosCambios pc ON cc.idProductoCambio = pc.idProductoCambio
            INNER JOIN
        productos p ON pc.skuConver = p.sku
            INNER JOIN
        presentacion pr ON pr.idpresentacion = p.idpresentacion
            INNER JOIN
        cambiosmotivos  cm ON cc.idCambiosMotivos = cm.idCambiosMotivos
            INNER JOIN
        operaciones op ON op.idoperacion = cc.idoperacion
            INNER JOIN
        deposito d ON d.idDeposito = op.idDeposito
            INNER JOIN
        clientes cl ON cl.nud = cc.nud AND cl.iddeposito = d.idDeposito
    WHERE
      cc.FechaCambio = '2017-06-12'
      AND cc.idoperacion = 8
      AND cc.NumEmpleado = 50014466
    ORDER BY idcambios";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);

// Títulos de las columnas
$header = array('SKU','Descripción','NUD','Cliente','Motivo','Piezas');

// Anchuras de las columnas
$w = array(11,55,11,55,20,14);
$pdf->SetFont('Times','',8);
$pdf->AddPage();
$pdf->crearEncabezado($header,$w);
$count = 0;

do{

    $pdf->Cell($w[0],6,$row['sku'],0,0,'L');
    $pdf->Cell($w[1],6,$row['DescripcionInterna'],0,0,'L');
    $pdf->Cell($w[2],6,$row['nud'],0,0,'L');
    $pdf->Cell($w[3],6,$row['nombre'],0,0,'L');
    $pdf->Cell($w[4],6,$row['motivo'],0,0,'L');
    $pdf->Cell($w[5],6,$row['cantidad'],0,0,'C');
    $pdf->Ln();
    $count = $row['cantidad'] + $count;
}while($row = $db->fetch_assoc($resultado));
$pdf->Ln();
$pdf->Cell($w[0]+$w[1]+$w[2]+$w[3]+$w[4],6,'Total de Piezas',0,0,'L');
$pdf->Cell($w[5],6,$count,0,0,'C');
$pdf->Ln();

$pdf->Output('reportePromotor_'.$fechaPreventa.'_'.date('H:i:s').'.pdf','D');
?>
