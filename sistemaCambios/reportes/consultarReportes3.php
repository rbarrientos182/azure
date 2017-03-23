<?php
if (!isset($_SESSION))
{
	session_start();
}
require_once('../clases/class.MySQL.php');

require_once("../dompdf/dompdf_config.inc.php");

$db = new MySQL();

$idoperacion = $_SESSION['idoperacion'];
$fechaPreventa = $_POST['fechaPre'];
$tipoReporte = $_POST['tipoR'];


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

$idDeposito = $rowDep['idDeposito'];

$encabezado = '<tr>
			      <td width="250"><tt>Gepp México</tt></td>
			      <td width="250"><tt>Compañía:</tt></td>
			      <td width="250"><tt>Gepp S de RL de CV</tt></td>
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
			      <td><tt>Fecha Preventa</tt></td>
			      <td><tt>'.$fechaPreventa.'</tt></td>
			    </tr>
			    <tr>
			      <td><tt></tt></td>
			      <td><tt>Fecha Entrega</tt></td>
			      <td><tt>'.$fechaEntrega.'</tt></td>
			    </tr>';

/** Si el tipo de reporte es igual a 0 significa que es el reporte supervisor por producto **/
if($tipoReporte==0)
{

			/** Query para obtener los motivos dados de alta en el deposito**/
			$consultaMo = "SELECT cc.idCambiosMotivos,cm.Descripcion FROM CambiosMotivos cm
			INNER JOIN capturacambios cc ON cm.idCambiosMotivos = cc.idCambiosMotivos
			WHERE cc.idoperacion = $idoperacion AND cc.FechaCambio = '$fechaPreventa' GROUP BY cm.Descripcion";
			$resultadoMo = $db->consulta($consultaMo);
			$rowMo = $db->fetch_assoc($resultadoMo);


			/** Creo un array para guardar el id Motivos y formar la tabla **/
			$arrayMotivos = array();
			$contM = 0;
			do{

				$tdMo .= '<td width="50"><tt>'.$rowMo['Descripcion'].'</tt></td>';
				$arrayMotivos[$contM] = $rowMo['idCambiosMotivos'];
				$contM++;


			}while($rowMo = $db->fetch_assoc($resultadoMo));


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

			do{

				$tdPro .= '<td width="50"><tt>'.$rowPro['DescripcionInterna'].'</tt></td>';
				$arrayProductos[$contP] = $rowPro['idProductoCambio'];
				$contP++;

			}while($rowPro = $db->fetch_assoc($resultadoPro));

			/** Query para obtener las rutas, cuantos clientes y total de piezas por rutas**/
				$consulta = "SELECT
			    cc.idruta,
			    COUNT(cc.nud) AS ncliente,
			    SUM(cc.cantidad) AS totalC,
			    FechaCambio
				FROM
			    CapturaCambios cc
			        INNER JOIN
			    CambiosMotivos cm ON cc.idCambiosMotivos = cm.idCambiosMotivos
			        INNER JOIN
			    ProductosCambios pc ON cc.idProductoCambio = pc.idProductoCambio
			        INNER JOIN
			    UsrCambios uc ON cc.NumEmpleado = uc.NumEmpleado
			        INNER JOIN
			    Clientes c ON c.nud = cc.nud AND c.idDeposito = $idDeposito
			        AND cc.idoperacion = $idoperacion
			        AND FechaCambio = '$fechaPreventa'
				GROUP BY cc.idRuta
				ORDER BY cc.idRuta";

			$resultado = $db->consulta($consulta);
			$row = $db->fetch_assoc($resultado);

			do{

				/** Inicio un for para sacar los totales por motivo y ruta**/
				for($x=0;$x<count($arrayMotivos);$x++){

					$consulta2 = "SELECT COUNT(cc.idCambiosMotivos) AS cantM FROM CapturaCambios cc
					INNER JOIN CambiosMotivos cm ON cc.idCambiosMotivos = cm.idCambiosMotivos
					WHERE cc.idoperacion = $idoperacion AND cc.FechaCambio = '$fechaPreventa'
					AND cc.idruta = ".$row['idruta']." AND cc.idCambiosMotivos = ".$arrayMotivos[$x];
					$resultado2 = $db->consulta($consulta2);
					$row2 = $db->fetch_assoc($resultado2);


					$tdCM .= '<td width="50"><tt>'.$row2['cantM'].'</tt></td>';
				}

				//echo $tdCM;

				/** Inicio un for para sacar los totales por producto y ruta **/
				for ($i=0;$i<count($arrayProductos);$i++) {

						$consulta3 = "SELECT COUNT(pc.idProductoCambio) AS cantP FROM CapturaCambios cc
						INNER JOIN ProductosCambios pc ON cc.idProductoCambio = pc.idProductoCambio
						WHERE cc.idoperacion = $idoperacion AND cc.FechaCambio = '$fechaPreventa'
						AND cc.idruta = ".$row['idruta']." AND pc.idProductoCambio = ".$arrayProductos[$i];
						$resultado3 = $db->consulta($consulta3);
						$row3 = $db->fetch_assoc($resultado3);

						$tdCP .= '<td width="50"><tt>'.$row3['cantP'].'</tt></td>';

					}

				$tdBody  .= '<tr>
							    <td><tt>'.$row['idruta'].'</tt></td>
							    <td><tt>'.$row['ncliente'].'</tt></td>
							    '.$tdCM.'
							    <td><tt>'.$row['totalC'].'</tt></td>
							    <!--<td><tt>.125</tt></td>-->
							    '.$tdCP.'
							</tr>';
				$tdCM = NULL;
				$tdCP = NULL;

			}while($row = $db->fetch_assoc($resultado));


	$codigo = '<!doctype html>
		<html>
		<head>
		<meta charset="UTF-8">
		<title>Documento sin título</title>
		</head>

		<body>
		<center>
			<table width="750" height="112" border="0">
			  <tbody>
			    '.$encabezado.'
			  </tbody>
			</table>
			<p>&nbsp;</p>
			<hr>
			<p>&nbsp;</p>
			<table width="750" height="112" border="0">
			  <tbody>
			    <tr>
			      <td width="50"><tt>Ruta</tt></td>
			      <td width="50"><tt>#Clientes</tt></td>
			      '.$tdMo.'
			      <td width="50"><tt>Total Pzas</tt></td>
			      <!--<td width="50"><tt>Cajas Fisicas</tt></td>-->
			      '.$tdPro.'
			    </tr>
			    '.$tdBody.'
			    <!--<tr>
			      <td><tt></tt></td>
			      <td><tt>Totales</tt></td>
			      <td><tt>Totales</tt></td>
			      <td><tt>Totales</tt></td>
			      <td><tt>Totales</tt></td>
			      <td><tt>Totales</tt></td>
			      <td><tt>Totales</tt></td>
			      <td><tt>Totales</tt></td>
			    </tr>-->
			  </tbody>
			</table>
			<p>&nbsp;</p>
			<p>&nbsp;</p>
		</center>
		</body>
		</html>';

		$nombreReporte = 'reporteSupervisor.pdf';
}

if($tipoReporte==1){

	$consulta = "SELECT cc.idruta, cc.nud, c.nombre, pc.sku, pc.DescripcionInterna,cc.cantidad  FROM CapturaCambios cc
	INNER JOIN ProductosCambios pc ON cc.idProductoCambio = pc.idProductoCambio
	INNER JOIN Clientes c ON c.nud = cc.nud WHERE c.iddeposito = $idDeposito
	AND cc.FechaCambio = '$fechaPreventa' AND cc.idoperacion = $idoperacion ORDER BY cc.idruta,cc.nud";
	$resultado = $db->consulta($consulta);
	$row = $db->fetch_assoc($resultado);
	$sumaTotal = 0;
	$nud = $row['nud'];
	do{

		$nudIni = $row['nud'];

		if($nud!=$nudIni){

			$tr2 = '<tr>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td><tt>'.$sumaTotal.'</tt></td>
				      <td><tt>Firma del Cliente</tt></td>
    				</tr>';

    		$sumaTotal = 0;

		}
		$sumaTotal = $sumaTotal + $row['cantidad'];
		$sumaTotal = $sumaTotal;

		$nud = $nudIni;
		$tdBody .= $tr2.'<tr>
						<td><tt>'.$row['idruta'].'</tt></td>
						<td><tt>'.$row['nud'].'</tt></td>
						<td><tt>'.$row['nombre'].'</tt></td>
						<td><tt>'.$row['sku'].'</tt></td>
						<td><tt>'.$row['DescripcionInterna'].'</tt></td>
						<td><tt>'.$row['cantidad'].'</tt></td>
					</tr>';
		$tr2 = NULL;

	}while($row = $db->fetch_assoc($resultado));

	$tr2 = '<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td><tt>'.$sumaTotal.'</tt></td>
				<td><tt>Firma del Cliente</tt></td>
    		</tr>';

	$tdBody .= $tr2.'<tr>
						<td><tt>'.$row['idruta'].'</tt></td>
						<td><tt>'.$row['nud'].'</tt></td>
						<td><tt>'.$row['nombre'].'</tt></td>
						<td><tt>'.$row['sku'].'</tt></td>
						<td><tt>'.$row['DescripcionInterna'].'</tt></td>
						<td><tt>'.$row['cantidad'].'</tt></td>
					</tr>';

	$codigo = '<!doctype html>
	<html>
	<head>
	<meta charset="UTF-8">
	<title>Documento sin título</title>
	</head>

	<body>
	<table width="750" height="112" border="0">
	  <tbody>
	    '.$encabezado.'
	  </tbody>
	</table>
	<p>&nbsp;</p>
	<hr>
	<p>&nbsp;</p>
	<table width="750" height="112" border="0">
	  <tbody>
		<tr>
	      <td width="50"><tt>Ruta</tt></td>
	      <td width="50"><tt>Nud</tt></td>
	      <td width="50"><tt>Cliente</tt></td>
	      <td width="50"><tt>Sku</tt></td>
	      <td width="50"><tt>Descripción</tt></td>
	      <td width="50"><tt>Cantidad Pzas</tt></td>
	      <td width="50">&nbsp;</td>
	    </tr>
	    '.$tdBody.'
	  </tbody>
	</table>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	</body>
	</html>';

	$nombreReporte = 'reporteOperadorEntrega.pdf';
}

if($tipoReporte==2) {

	$codigo = '<!doctype html>
	<html>
	<head>
	<meta charset="UTF-8">
	<title>Documento sin título</title>
	</head>
	<body>
	<table width="750" height="112" border="0">
	  <tbody>
	    '.$encabezado.'
	  </tbody>
	</table>
	<p>&nbsp;</p>
	<hr>
	<p>&nbsp;</p>
	<table width="1125" height="112" border="0">
	  <tbody>
	    <tr>
	      <td width="50"><tt>Ruta</tt></td>
	      <td width="50"><tt>SKU</tt></td>
	      <td width="50"><tt>Descripción</tt></td>
	      <td width="50"><tt>Cantidad Pzas</tt></td>
	    </tr>
	    <tr>
	      <td><tt>8065</tt></td>
	      <td><tt>1234</tt></td>
	      <td><tt>Pepsi 600ml</tt></td>
	      <td><tt>10</tt></td>
	    </tr>
	    <tr>
	      <td>&nbsp;</td>
	      <td>&nbsp;</td>
	      <td>&nbsp;</td>
	      <td><tt>total</tt></td>
	    </tr>

	  </tbody>
	</table>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	</body>
	</html>';

	$nombreReporte = 'reporteBodega.pdf';
}

/** aca se genera el reporte **/
$codigo = utf8_decode($codigo);
$dompdf = new DOMPDF();
$dompdf->set_paper("A4","landscape");
$dompdf->load_html($codigo);
ini_set("memory_limit","32M");
$dompdf->render();
$dompdf->stream($nombreReporte);
?>
