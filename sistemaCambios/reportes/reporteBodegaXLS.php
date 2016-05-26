<?php 
if (!isset($_SESSION)) 
{
	session_start();
}
date_default_timezone_set('America/Mexico_City');
$idoperacion = $_SESSION['idoperacion'];
$fechaIni = $_POST['fechaIni'];
$fechaFin = $_POST['fechaFin'];

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=reporteBodega_".$fechaIni.'_'.date('H:i:s').".xls");
header("Pragma: no-cache");
header("Expires: 0");

require_once('../clases/class.MySQL.php');
$db = new MySQL();

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

$idDeposito = $rowDep['idDeposito'];

$encabezado = '<tr>
			      <td width="250"><tt>Gepp México</tt></td>
			      <td width="250"><tt>Compañía:</tt></td>
			      <td width="250"><tt>Gepp S de RL de CV</tt></td>
			      <td width="250"><tt>'.date('Y-m-d H:i:s').'</tt></td>
			    </tr>
			    <tr>
			      <td><tt>Reporte de Cambios</tt></td>
			      <td><tt>Bodega:</tt></td>
			      <td><tt>'.$rowDep['idDeposito'].' '.$rowDep['deposito'].'</tt></td>
			    </tr>
			    <tr>
			      <td><tt>Grupos Supervisión:</tt></td>
			      <td><tt>Localidad:</tt></td>
			      <td><tt>'.$rowDep['region'].'</tt></td>
			    </tr>
			    <tr>
			      <td><tt></tt></td>
			      <td><tt>Fecha Inicio</tt></td>
			      <td><tt>'.$fechaIni.'</tt></td>
			    </tr>
			    <tr>
			      <td><tt></tt></td>
			      <td><tt>Fecha Fin</tt></td>
			      <td><tt>'.$fechaFin.'</tt></td>
			    </tr>';

	$consulta = "SELECT 
    pc.sku,
    pc.DescripcionInterna,
    pc.skuconver,
    p.descripcion,
    cc.nud,
    SUM(cc.cantidad) AS cantidad,
    FORMAT(SUM(cc.cantidad)/cavidades,0) AS cfisica,
    cavidades
    
    FROM
        CapturaCambios cc
            INNER JOIN
        ProductosCambios pc ON cc.idProductoCambio = pc.idProductoCambio
            INNER JOIN 
        productos p ON pc.skuConver = p.sku
    WHERE
        cc.FechaCambio BETWEEN '$fechaIni' AND '$fechaFin'
        AND cc.idoperacion = $idoperacion
        AND estatusDis !=0
    GROUP BY pc.skuconver
    ORDER BY pc.skuconver";
	
	$resultado = $db->consulta($consulta);
	$row = $db->fetch_assoc($resultado);
	$sumaTotal = 0;
	$idruta = $row['idruta'];
	$bandera = 0;
	do{
		
		$idrutaIni = $row['idruta'];

		if($sku!=$skuIni){

			$tr2 = '<tr>
				      	<td>&nbsp;</td>
				      	<td>&nbsp;</td>
				      	<td>&nbsp;</td>
				      	<td>&nbsp;</td>
				      	<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
    				</tr>';
    		$ruta = $row['idruta'];		

		}

		$sumaTotal = $sumaTotal + $row['cantidad'];
		$sumaTotal = $sumaTotal;

		$sumaTotalF = $sumaTotalF + $row['cfisica'];
		$sumaTotalF = $sumaTotalF;

		$tdBody .= $tr2.'<tr align="center">
						<td><tt>'.$row['skuconver'].'</tt></td>
						<td><tt>'.$row['descripcion'].'</tt></td>
						<td><tt>'.$row['cantidad'].'</tt></td>
						<td><tt>'.$row['cfisica'].'</tt></td>
						<td><tt>______</tt></td>
						<td><tt>______</tt></td>
						<td><tt>______</tt></td>
						<td><tt>______</tt></td>
						<td><tt>______</tt></td>
						
					</tr>';
		$tr2 = NULL;			
				
	}while($row = $db->fetch_assoc($resultado));

	$tr2 = '<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
    		</tr><tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td align="center">'.$sumaTotal.'</td>
				<td align="center">'.$sumaTotalF.'</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
    		</tr>';

	$tdBody .= $tr2;
?>
	<!doctype html>
	<html>
	<head>
	<meta charset="UTF-8">
	<title>Documento sin título</title>
	</head>
	<body>
	<table width="750" height="112" border="0">
	  <tbody>
	    <?php echo $encabezado;?>
	  </tbody>
	</table>
	<hr>
	<table width="750" height="112" border="0">
	  <tbody>
	  	<tr>
	      <td colspan="3" align="center"><tt>SALIDA</tt></td>
	      <td colspan="5" align="center"><tt>ENTRADA</tt></td>
	    </tr>
	    <tr>
	      <td width="50"><tt>SKU Conversión</tt></td>
	      <td width="50"><tt>Producto Conversión</tt></td>
	      <td width="50"><tt>Cantidad Pzas</tt></td>
	      <td width="50"><tt>Cajas Físicas</tt></td>
	      <td width="50"><tt>Merma</tt></td>
	      <td width="50"><tt>Caduco</tt></td>
	      <td width="50"><tt>Cobro</tt></td>
	      <td width="50"><tt>Devolución</tt></td>
	      <td width="50"><tt>Total</tt></td>
	    </tr>
	    <?php echo $tdBody; ?>
	  </tbody>
	</table>
	</body>
	</html>