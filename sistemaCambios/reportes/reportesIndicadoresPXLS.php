<?php
set_time_limit(600); 
if (!isset($_SESSION)) 
{
	session_start();
}
date_default_timezone_set('America/Mexico_City');

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=rIndicadores_Presentacion_".$fechaIni.'_'.date('H:i:s').".xls");
header("Pragma: no-cache");
header("Expires: 0");

require_once('../clases/class.MySQL.php');
$db = new MySQL();

//Query para obtener el total general por presentacion
$consultaTotalGeneral = "SELECT 
    SUM(cc.cantidad) AS total, pr.descripcion AS presentacion
FROM
    productos p
        INNER JOIN
    presentacion pr ON p.idpresentacion = pr.idpresentacion
        INNER JOIN
    ProductosCambios pc ON p.sku = pc.sku
        INNER JOIN
    capturacambios cc ON pc.idProductoCambio = cc.idProductoCambio
    	AND cc.idruta IS NOT NULL
        AND cc.idoperacion = $idoperacion
        AND cc.FechaCambio BETWEEN '$fechaIni' AND '$fechaFin'
GROUP BY presentacion
ORDER BY presentacion";
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
			      <td><tt>Reporte Indicadores Presentación</tt></td>
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
			<title>Reporte Indicadores Presentación</title>
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
											$consultaP = "SELECT 
											    p.sku, pr.descripcion AS presentacion
											FROM
											    productos p
											        INNER JOIN
											    presentacion pr ON p.idpresentacion = pr.idpresentacion
											        INNER JOIN
											    ProductosCambios pc ON p.sku = pc.sku
											        INNER JOIN
											    capturacambios cc ON pc.idProductoCambio = cc.idProductoCambio
											    	AND cc.idruta IS NOT NULL
											        AND cc.idoperacion = $idoperacion
											        AND cc.FechaCambio BETWEEN '$fechaIni' AND '$fechaFin'
											GROUP BY pr.descripcion
											ORDER BY pr.descripcion";
											$resultadoP = $db->consulta($consultaP);
											$rowP = $db->fetch_assoc($resultadoP);
											$contador3 = 0;
											$tdPresentacion = "";
											$tdPresentacionTP = "";
											$arrayPresentacion = array();
											do{
												$tdPresentacion .= "<td>".utf8_encode($rowP['presentacion'])."</td>";
												$arrayPresentacion[$contador3] = $rowP['presentacion'];
												$contador3++;
												$consultaTP ="SELECT 
												     SUM(cc.cantidad) AS total, pr.descripcion AS presentacion
												FROM
												    productos p
												        INNER JOIN
												    presentacion pr ON p.idpresentacion = pr.idpresentacion
												        INNER JOIN
												    ProductosCambios pc ON p.sku = pc.sku
												        INNER JOIN
												    capturacambios cc ON pc.idProductoCambio = cc.idProductoCambio
												        INNER JOIN 
													usrcambios u ON cc.NumEmpleado = u.NumEmpleado
														INNER JOIN 
													rutasCambios rc ON rc.ruta = u.PPP
														AND cc.idruta IS NOT NULL
														AND rc.idgruposupervision =  ".$row['idgruposupervision']."
												        AND cc.idoperacion = $idoperacion
												        AND cc.FechaCambio BETWEEN '$fechaIni' AND '$fechaFin'
												        AND pr.descripcion = '".$rowP['presentacion']."'
												GROUP BY pr.descripcion
												ORDER BY pr.descripcion";
												$resultadoTP = $db->consulta($consultaTP);
												$rowTP = $db->fetch_assoc($resultadoTP);
												$tdPresentacionTP .= "<td>".utf8_encode($rowTP['total'])."</td>";

											}while($rowP = $db->fetch_assoc($resultadoP));
										?>
										<tr>
											<td colspan="<?php echo $contador3+1; ?>" align="center" bgcolor="#ABABAB">Presentación</td>	
										</tr>
										<tr>
											<?php echo $tdPresentacion;?>
											<td>Total</td>
										</tr>
										<?php
											$totalt3 = 0;
											//preparamos un for con el array de rutas
											for($i=0;$i<count($arrayRuta);$i++){ 
											//Query para saber cuanto contiene por motivo la ruta;
											$total = 0;
										?>
										<tr>
											<?php for($z=0;$z<count($arrayPresentacion);$z++) { 
												# code...
												$consultaPresentacion= "SELECT 
												    uc.PPP, SUM(cc.cantidad) AS cantidad, pr.descripcion AS presentacion
												FROM
												    usrcambios uc
												        INNER JOIN
												    capturacambios cc ON uc.NumEmpleado = cc.NumEmpleado
												        INNER JOIN
												    productoscambios pc ON cc.idProductoCambio = pc.idProductoCambio
												        INNER JOIN
												    productos p ON pc.sku = p.sku
														INNER JOIN
													presentacion pr ON p.idpresentacion = pr.idpresentacion
												WHERE
												    cc.idoperacion = $idoperacion AND uc.ppp = ".$arrayRuta[$i]."
												    	AND cc.idruta IS NOT NULL
												        AND cc.FechaCambio BETWEEN '$fechaIni' AND '$fechaFin'
												        AND pr.descripcion = '".$arrayPresentacion[$z]."'
												GROUP BY pr.descripcion
												ORDER BY pr.descripcion";
												$resultadoPresentacion = $db->consulta($consultaPresentacion);
												$rowPresentacion = $db->fetch_assoc($resultadoPresentacion);
												$total = $total + $rowPresentacion['cantidad'];
												$total = $total;
												$totalt3 = $totalt3 + $rowPresentacion['cantidad'];
											?>
												<td><?php echo $rowPresentacion['cantidad']?></td>
											<?php 
													$db->liberar($resultadoPresentacion);
												}//cierre de for motivo
											?>
											<td><?php echo $total;?></td>
										</tr>
										<?php
											}//cierre de for ruta
										?>
										<tr bgcolor="#c2f0c2">
											<?php echo $tdPresentacionTP;?>
											<td><?php echo $totalt3;?></td>
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