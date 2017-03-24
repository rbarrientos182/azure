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
header("Content-Disposition: attachment; filename=reporteAdministracionDetallado_".$fechaIni.'_'.date('H:i:s').".xls");
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
						<td width="250"><tt>Gepp</tt></td>
			    	<!--<td width="250"><tt>Compañía:</tt></td>
			      <td width="250"><tt>Gepp S de RL de CV</tt></td>-->
			      <td width="250" align="left"><tt>'.date('Y-m-d H:i:s').'</tt></td>
			    </tr>
			    <tr>
			      <td><tt>Reporte Bodega Detallado</tt></td>
			    </tr>
			    <tr>
			      <td><tt>Deposito:</tt></td>
			      <td align="left"><tt>'.$rowDep['idDeposito'].' '.$rowDep['deposito'].'</tt></td>
			    </tr>
			    <tr>
			      <td><tt>Fecha Inicio:</tt></td>
			      <td align="left"><tt>'.$fechaIni.'</tt></td>
			    </tr>
			    <tr>
			      <td><tt>Fecha Fin:</tt></td>
			      <td align="left"><tt>'.$fechaFin.'</tt></td>
			    </tr>';


				/** Query para obtener las rutas, clientes y fecha**/
				$consulta = "SELECT
                FechaCambio AS fecha,
				    cc.idruta AS vpp,
				    numgrupo,
				    c.ppp,
				    cc.nud,
				    c.nombre,
                    uc.nombre AS nombreusuario,
                    ugs.nombre AS nombresupervisor,
				    agrupador AS agrupador_Merma,
				    mo.descripcion AS motivo,
                    seg.descripcion AS nombresegmento,
				    pc.sku,
				    pr.descripcion AS empaque,
				    p.Descripcion AS sku_Descripcion,
				    cc.cantidad
				FROM
				    CapturaCambios cc
				        INNER JOIN
				    ProductosCambios pc ON cc.idProductoCambio = pc.idProductoCambio
				        INNER JOIN
				    productos p ON pc.skuConver = p.sku
								INNER JOIN
						segmento seg ON p.idsegmento = seg.idsegmento
				        INNER JOIN
				    Operaciones op ON op.idoperacion = cc.idoperacion
				        INNER JOIN
				    Clientes c ON c.nud = cc.nud
				        INNER JOIN
				    cambiosmotivos mo ON mo.idcambiosmotivos = cc.idcambiosmotivos
				        INNER JOIN
				    usrcambios uc ON cc.NumEmpleado = uc.NumEmpleado
				        INNER JOIN
				    rutascambios rc ON uc.PPP = rc.ruta
				        INNER JOIN
				    gruposupervision gs ON rc.idgruposupervision = gs.idgruposupervision
								INNER JOIN
					usrcambios ugs ON gs.NumEmpleado = ugs.NumEmpleado
							  INNER JOIN
					presentacion pr ON pr.idpresentacion = p.idpresentacion
			 WHERE
				    c.iddeposito = $idDeposito
				        AND rc.idoperacion = (SELECT idoperacion FROM operaciones WHERE iddeposito = $idDeposito)
				        AND cc.idoperacion = (SELECT idoperacion FROM operaciones WHERE iddeposito = $idDeposito)
				        AND cc.FechaCambio BETWEEN '$fechaIni' AND '$fechaFin'
				        AND estatusDis != 0
				ORDER BY FechaCambio, cc.idruta , pc.sku";
				$resultado = $db->consulta($consulta);
				$row = $db->fetch_assoc($resultado);

				do{

					$tdBody  .= '<tr>
										<td><tt>'.$row['fecha'].'</tt></td>
								    <td><tt>'.$row['vpp'].'</tt></td>
										<td><tt>'.$row['nombreusuario'].'</tt></td>
								    <td><tt>'.$row['numgrupo'].'</tt></td>
										<td><tt>'.$row['nombresupervisor'].'</tt></td>
								    <td><tt>'.$row['ppp'].'</tt></td>
								    <td><tt>'.$row['nud'].'</tt></td>
								    <td><tt>'.$row['nombre'].'</tt></td>
										<td><tt>'.$row['agrupador_Merma'].'</tt></td>
										<td><tt>'.$row['motivo'].'</tt></td>
								    <td><tt>'.$row['sku'].'</tt></td>
										<td><tt>'.$row['empaque'].'</tt></td>
										<td><tt>'.$row['nombresegmento'].'</tt></td>
								    <td><tt>'.$row['sku_Descripcion'].'</tt></td>
								    <td><tt>'.$row['cantidad'].'</tt></td>
								</tr>';
						$total = $total + $row['cantidad'];
				}while($row = $db->fetch_assoc($resultado));

?>
	<!doctype html>
		<html>
		<head>
		<meta charset="UTF-8">
		<title>Reporte Bodega Detallado</title>
		</head>

		<body>
		<center>
			<table width="750" height="112" border="0">
			  <tbody>
			    <?php echo  $encabezado ?>
				</tbody>
			</table>
			<hr>
			<table width="750" height="112" border="0">
			  <tbody>
			    <tr>
			    		<td width="25"><tt>Fecha Cambio</tt></td>
			      	<td width="25"><tt>OE</tt></td>
							<td width="25"><tt>Nombre Promotor</tt></td>
			      	<td width="25"><tt>Grupo Supervisor</tt></td>
							<td width="25"><tt>Nombre Supervisor</tt></td>
			      	<td width="25"><tt>PPP</tt></td>
			      	<td width="25"><tt>NUD</tt></td>
			      	<td width="25"><tt>Cliente</tt></td>
							<td width="25"><tt>Agrupador Merma</tt></td>
							<td width="25"><tt>Motivo</tt></td>
			      	<td width="25"><tt>SKU</tt></td>
			      	<td width="25"><tt>Empaque</tt></td>
							<td width="25"><tt>Segmento</tt></td>
							<td width="25"><tt>Producto</tt></td>
			      	<td width="25"><tt>Cantidad</tt></td>
			    </tr>
			    <?php echo $tdBody; ?>
					<tr>
			    		<td width="25"><tt></tt></td>
			      	<td width="25"><tt></tt></td>
			      	<td width="25"><tt></tt></td>
			      	<td width="25"><tt></tt></td>
			      	<td width="25"><tt></tt></td>
			      	<td width="25"><tt></tt></td>
							<td width="25"><tt></tt></td>
							<td width="25"><tt></tt></td>
			      	<td width="25"><tt></tt></td>
			      	<td width="25"><tt></tt></td>
							<td width="25"><tt></tt></td>
			      	<td width="25"><tt><?php echo $total;?></tt></td>
			    </tr>
			  </tbody>
			</table>
		</center>
		</body>
		</html>
