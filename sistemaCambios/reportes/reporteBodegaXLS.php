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
			      <td><tt>Reporte Bodega</tt></td>
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
    idruta,
    sku,
    idproductocambio,
    idempaque,
    dempaque,
    descripcion,
    FORMAT(SUM(cfisica),0) AS cfisica,
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
            SUM(cantidad)/cavidades AS cfisica,
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
        capturacambios cc
    INNER JOIN cambiosmotivos cm ON cm.idcambiosmotivos = cc.idcambiosmotivos
    INNER JOIN productoscambios pc ON pc.idproductocambio = cc.idproductocambio
    INNER JOIN productos p ON p.sku = pc.idProductoCambio
    INNER JOIN presentacion pr ON pr.idpresentacion = p.idpresentacion
    WHERE
        FechaCambio = '$fechaIni'
            AND estatusDis != 0
            AND cc.idoperacion = (SELECT
                idoperacion
            FROM
                operaciones
            WHERE
                iddeposito = $idDeposito)) datos
    GROUP BY sku) datos2
    GROUP BY sku) datos3
GROUP BY sku
ORDER BY sku";

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

		$sumaTotal = $sumaTotal + $row['total'];
		$sumaTotal = $sumaTotal;

		$sumaTotalF = $sumaTotalF + $row['cfisica'];
		$sumaTotalF = $sumaTotalF;

		$sumaDefectoProduccion = $sumaDefectoProduccion + $row['DefectoProduccion'];
		$sumaDefectoProduccion = $sumaDefectoProduccion;

		$sumaMermaOperativa = $sumaMermaOperativa + $row['MermaOperativa'];
		$sumaMermaOperativa = $sumaMermaOperativa;

		$sumaProductoCaduco = $sumaProductoCaduco + $row['ProductoCaduco'];
		$sumaProductoCaduco = $sumaProductoCaduco;

		$sumaRetiroParaDonativo = $sumaRetiroParaDonativo + $row['RetiroParaDonativo'];
		$sumaRetiroParaDonativo = $sumaRetiroParaDonativo;

		$tdBody .= $tr2.'<tr align="center">
						<td><tt>'.$row['sku'].'</tt></td>
						<td><tt>'.$row['descripcion'].'</tt></td>
						<td><tt>'.$row['cfisica'].'</tt></td>
						<td><tt>'.$row['DefectoProduccion'].'</tt></td>
						<td><tt>'.$row['MermaOperativa'].'</tt></td>
						<td><tt>'.$row['ProductoCaduco'].'</tt></td>
						<td><tt>'.$row['RetiroParaDonativo'].'</tt></td>
						<td><tt>'.$row['total'].'</tt></td>

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
    		</tr><tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td align="center">'.$sumaTotalF.'</td>
				<td align="center">'.$sumaDefectoProduccion.'</td>
				<td align="center">'.$sumaMermaOperativa.'</td>
				<td align="center">'.$sumaProductoCaduco.'</td>
				<td align="center">'.$sumaRetiroParaDonativo.'</td>
				<td align="center">'.$sumaTotal.'</td>
    		</tr>';

	$tdBody .= $tr2;
	?>
	<!doctype html>
	<html>
	<head>
	<meta charset="UTF-8">
	<title>Reporte Bodega</title>
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
	      <td colspan="5" align="center"><tt>AGRUPADOR</tt></td>
	    </tr>
	    <tr>
	      <td width="50"><tt>SKU</tt></td>
	      <td width="50"><tt>Producto</tt></td>
	      <td width="50"><tt>Cajas Físicas</tt></td>
	      <td width="50"><tt>Defecto Producción</tt></td>
	      <td width="50"><tt>Merma Operativa</tt></td>
	      <td width="50"><tt>Producto Caduco</tt></td>
	      <td width="50"><tt>Retiro Para Donativo</tt></td>
	      <td width="50"><tt>Total</tt></td>
	    </tr>
	    <?php echo $tdBody; ?>
	  </tbody>
	</table>
	</body>
	</html>
