<?php
set_time_limit(600); 
if (!isset($_SESSION)) 
{
	session_start();
}
date_default_timezone_set('America/Mexico_City');

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=rIndicadores_Segmento".$fechaIni.'_'.date('H:i:s').".xls");
header("Pragma: no-cache");
header("Expires: 0");

require_once('../clases/class.MySQL.php');
$db = new MySQL();

//Query para obtener el total general por segmento
$consultaTotalGeneral = "SELECT 
	SUM(cc.cantidad) AS total, s.descripcion AS segmento
FROM
	productos p
		INNER JOIN
	segmento s ON p.idsegmento = s.idsegmento
		INNER JOIN
	ProductosCambios pc ON p.sku = pc.sku
		INNER JOIN
	capturacambios cc ON pc.idProductoCambio = cc.idProductoCambio
		AND cc.idruta IS NOT NULL
		AND cc.idoperacion = $idoperacion
		AND cc.FechaCambio BETWEEN '$fechaIni' AND '$fechaFin'
GROUP BY segmento
ORDER BY segmento";
$resultadoTotalGeneral = $db->consulta($consultaTotalGeneral);
$rowTotalGeneral = $db->fetch_assoc($resultadoTotalGeneral);
$totalTotal = 0;
do{ 
	$tdTotalGeneral .= "<td>".utf8_encode($rowTotalGeneral['total'])."</td>";
	$totalTotal = $rowTotalGeneral['total'] + $totalTotal;
}while($rowTotalGeneral = $db->fetch_assoc($resultadoTotalGeneral));
									
// Query para saber los grupos y supervisores
$consulta = "SELECT 
    gs.idgruposupervision, us.Nombre, gs.numgrupo
FROM
    capturacambios cc
        INNER JOIN
    usrcambios usr ON cc.numempleado = usr.numempleado
        INNER JOIN
    rutascambios ru ON usr.ppp = ru.ruta
    	INNER JOIN
    gruposupervision gs ON gs.idgruposupervision = ru.idgruposupervision
		INNER JOIN 
    usrcambios us ON us.numempleado = gs.numempleado
WHERE
    cc.idoperacion = $idoperacion AND usr.idoperacion = $idoperacion AND gs.idoperacion=$idoperacion
        AND fechacambio BETWEEN '$fechaIni' AND '$fechaFin'
GROUP BY gs.idgruposupervision ORDER BY gs.numgrupo";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado); 

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
			    <!--  <td width="250"><tt>Compañía:</tt></td>
			      <td width="250"><tt>Gepp S de RL de CV</tt></td> -->
			      <td width="250"><tt>'.date('Y-m-d H:i:s').'</tt></td>
			    </tr>
			    <tr>
			      <td><tt>Reporte Indicadores Segmento</tt></td>
			    </tr>
			    <tr>
			      <td><tt>Deposito:</tt></td>
			      <td><tt>'.$rowDep['idDeposito'].' '.$rowDep['deposito'].'</tt></td>
			    </tr>
			    <tr>
			      <td><tt>Fecha Inicio</tt></td>
			      <td><tt>'.$fechaIni.'</tt></td>
			    </tr>
			    <tr>
			      <td><tt>Fecha Fin</tt></td>
			      <td><tt>'.$fechaFin.'</tt></td>
			    </tr>';  
?>
<!DOCTYPE html>
	<html>
		<head>
			<meta charset="UTF-8">
			<title>Reporte Indicadores Segmento</title>
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
						<?php do{?>
							<tr>
								<td>
									<table border = "0">
										<tr>
											<td colspan="2"></td>
										</tr>
										<tr>
											<td>Grupo <?php echo $row['numgrupo'];?></td>
											<td><?php echo ucwords(strtolower($row['Nombre']));?></td>
										</tr>
										<?php 
											$consultaR = "SELECT 
											    ruta
											FROM
											    rutasCambios rc
											        INNER JOIN
											    usrcambios u ON rc.ruta = u.PPP
											        INNER JOIN
											    capturacambios cc ON u.NumEmpleado = cc.NumEmpleado
											    	AND cc.idruta IS NOT NULL
											        AND rc.idoperacion = $idoperacion
											        AND idgruposupervision = ".$row['idgruposupervision']."
											        AND cc.FechaCambio BETWEEN '$fechaIni' AND '$fechaFin'
											GROUP BY ruta
											ORDER BY ruta";
											$resultadoR = $db->consulta($consultaR);
											$rowR = $db->fetch_assoc($resultadoR);
											$arrayRuta = array();
											$contadorR=0;
											do{
												$arrayRuta[$contadorR] = $rowR['ruta'];
												$contadorR++;
										?>
												<tr>
													<td>Ruta <?php echo $rowR['ruta'];?></td>
													<td></td>
												</tr>
										<?php }while($rowR = $db->fetch_assoc($resultadoR)); ?>
										<tr>
											<td colspan="2" align="center"> </td>
										</tr>
									</table>
								</td>
								<td>
									<table border="1">
										<?php 
											$consultaS = "SELECT 
											    p.sku, s.descripcion AS segmento
											FROM
											    productos p
											        INNER JOIN
											    segmento s ON p.idsegmento = s.idsegmento
											        INNER JOIN
											    ProductosCambios pc ON p.sku = pc.sku
													INNER JOIN
												capturacambios cc ON pc.idProductoCambio = cc.idProductoCambio
													AND cc.idruta IS NOT NULL
											        AND cc.idoperacion = $idoperacion
											        AND cc.FechaCambio BETWEEN '$fechaIni' AND '$fechaFin'
											GROUP BY segmento
											ORDER BY segmento";
											$resultadoS = $db->consulta($consultaS);
											$rowS = $db->fetch_assoc($resultadoS);
											$contador = 0;
											$arraySegmento = array();
											$tdSegmento = "";
											$tdSegmentoTS = "";
											do{
												$tdSegmento .= "<td>".utf8_encode($rowS['segmento'])."</td>";
												$arraySegmento[$contador] = $rowS['segmento'];
												$contador++;
												/**Query totales segmento**/
												$consultaTS = "SELECT 
												   SUM(cc.cantidad) AS total, s.descripcion AS segmento
												FROM
												    productos p
												        INNER JOIN
												    segmento s ON p.idsegmento = s.idsegmento
												        INNER JOIN
												    ProductosCambios pc ON p.sku = pc.sku
														INNER JOIN
													capturacambios cc ON pc.idProductoCambio = cc.idProductoCambio
														INNER JOIN 
													usrcambios u ON cc.NumEmpleado = u.NumEmpleado
														INNER JOIN 
													rutasCambios rc ON rc.ruta = u.PPP
														AND cc.idruta IS NOT NULL
														AND rc.idgruposupervision = ".$row['idgruposupervision']."
												        AND cc.idoperacion = $idoperacion
												        AND cc.FechaCambio BETWEEN '$fechaIni' AND '$fechaFin'
												        AND s.descripcion = '".$rowS['segmento']."'
												GROUP BY segmento
												ORDER BY segmento";
												$resultadoTS = $db->consulta($consultaTS);
												$rowTS = $db->fetch_assoc($resultadoTS);
												$tdSegmentoTS .= "<td>".utf8_encode($rowTS['total'])."</td>";
											}while($rowS = $db->fetch_assoc($resultadoS));
										?>
										<tr>
											<td colspan="<?php echo $contador+1; ?>" align="center" bgcolor="#ABABAB">Segmento</td>	
										</tr>
										<tr>
											<?php echo $tdSegmento;?>
											<td>Total</td>
										</tr>
										<?php
											$totalt=0;
											//preparamos un for con el array de rutas
											for($i=0;$i<count($arrayRuta);$i++){
											$total = 0; 
											//Query para saber cuanto contiene por segmento la ruta;
										?>
										<tr>
											<?php for($z=0;$z<count($arraySegmento);$z++) { 
												# code...
											 	$consultaSegmento= "SELECT 
														    uc.PPP, SUM(cc.cantidad) AS cantidad, s.descripcion AS Segmento
														FROM
														    usrcambios uc
														        INNER JOIN
														    capturacambios cc ON uc.NumEmpleado = cc.NumEmpleado
														        INNER JOIN
														    productoscambios pc ON cc.idProductoCambio = pc.idProductoCambio
														        INNER JOIN
														    productos p ON pc.sku = p.sku
																INNER JOIN
															segmento s ON p.idsegmento = s.idsegmento
														WHERE
														    cc.idoperacion = $idoperacion AND uc.ppp =  ".$arrayRuta[$i]."
														    	AND cc.idruta IS NOT NULL
														        AND cc.FechaCambio BETWEEN '$fechaIni' AND '$fechaFin'
														        AND s.descripcion = '".$arraySegmento[$z]."'
														GROUP BY s.descripcion
														ORDER BY s.descripcion";
												$resultadoSegmento = $db->consulta($consultaSegmento);
												$rowSegmento = $db->fetch_assoc($resultadoSegmento);
												$total = $total + $rowSegmento['cantidad'];
												$total = $total;
												$totalt = $totalt + $rowSegmento['cantidad'];
											?>
												<td><?php echo $rowSegmento['cantidad']?></td>
											<?php 
													$db->liberar($resultadoSegmento);
												}//cierre de for segmento
											?>
											<td><?php echo $total;?></td>
										</tr>
										<?php
											}//cierre de for ruta
										?>
										<tr bgcolor="#c2f0c2">
											<?php echo $tdSegmentoTS;?>
											<td><?php echo $totalt;?></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr></tr>
						<?php }while($row = $db->fetch_assoc($resultado));?>
						<tr>
							<td></td>
							<td>
								<table border="1">
									<tr>
										<?php echo $tdTotalGeneral;?>
										<td><?php echo $totalTotal;?></td>
									</tr>
								</table>	
							</td>	
						</tr>
					</tbody>
				</table>
			</center>
		</body>
	</html>