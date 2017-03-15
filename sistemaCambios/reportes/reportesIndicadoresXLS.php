<?php
set_time_limit(600); 
if (!isset($_SESSION)) 
{
	session_start();
}
date_default_timezone_set('America/Mexico_City');

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=reporteIndicadores_".$fechaIni.'_'.date('H:i:s').".xls");
header("Pragma: no-cache");
header("Expires: 0");

require_once('../clases/class.MySQL.php');
$db = new MySQL();

$idoperacion = $_SESSION['idoperacion'];
$fechaIni = $_POST['fechaIni'];
$fechaFin = $_POST['fechaFin'];

// Query para saber los grupos y supervisores

$consulta = "SELECT 
    gs.numgrupo, uc.Nombre, gs.idgruposupervision
FROM
    gruposupervision gs
        INNER JOIN
    usrcambios uc ON gs.NumEmpleado = uc.NumEmpleado
        AND gs.idoperacion = $idoperacion
ORDER BY gs.numgrupo";
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
			      <td><tt>Reporte de Indicadores</tt></td>
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

<!doctype html>
	<html>
		<head>
			<meta charset="UTF-8">
			<title>Reporte Indicadores</title>
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
											<td><?php echo $row['Nombre'];?></td>
										</tr>
										<?php 
											//$consultaR = "SELECT ruta FROM rutasCambios WHERE idoperacion = $idoperacion AND idgruposupervision = ".$row['idgruposupervision']." ORDER BY ruta";
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
											ORDER BY segmento;";
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
								<td></td>
								<td>
									<table border="1">
										<?php 
											$consultaM = "SELECT 
											    cm.idCambiosMotivos, cm.Descripcion
											FROM
											    cambiosmotivos cm
													INNER JOIN
											    capturacambios cc ON cm.idCambiosMotivos = cc.idCambiosMotivos
											    AND cc.idruta IS NOT NULL
												AND cc.idoperacion = $idoperacion
											    AND cc.FechaCambio BETWEEN '$fechaIni' AND '$fechaFin'
											GROUP BY Descripcion
											ORDER BY Descripcion";
											$resultadoM = $db->consulta($consultaM);
											$rowM = $db->fetch_assoc($resultadoM);
											$contador2 = 0;
											$tdMotivos = "";
											$tdMotivosTM = "";
											$arrayMotivo = array();
											do{
												$tdMotivos .= "<td>".utf8_encode($rowM['Descripcion'])."</td>";
												$arrayMotivo[$contador2] = $rowM['idCambiosMotivos'];
												$contador2++;
												$consultaTM	= "SELECT 
												    SUM(cc.cantidad) AS total, cm.Descripcion AS motivos
												FROM
												    cambiosmotivos cm
														INNER JOIN
												    capturacambios cc ON cm.idCambiosMotivos = cc.idCambiosMotivos
												     INNER JOIN 
													usrcambios u ON cc.NumEmpleado = u.NumEmpleado
														INNER JOIN 
													rutasCambios rc ON rc.ruta = u.PPP
														AND cc.idruta IS NOT NULL
														AND rc.idgruposupervision = ".$row['idgruposupervision']."
												        AND cc.idoperacion = $idoperacion
												        AND cc.FechaCambio BETWEEN '$fechaIni' AND '$fechaFin'
												        AND cm.Descripcion = '".$rowM['Descripcion']."'
												GROUP BY motivos
												ORDER BY motivos";												
												$resultadoTM = $db->consulta($consultaTM);
												$rowTM = $db->fetch_assoc($resultadoTM);
												$tdMotivosTM .= "<td>".utf8_encode($rowTM['total'])."</td>";

											}while($rowM = $db->fetch_assoc($resultadoM));
										?>
										<tr>
											<td colspan="<?php echo $contador2+1; ?>" align="center" bgcolor="#ABABAB">Motivo</td>	
										</tr>
										<tr>
											<?php echo $tdMotivos;?>
											<td>Total</td>
										</tr>
										<?php
											//preparamos un for con el array de rutas
											$totalt2=0;
											for($i=0;$i<count($arrayRuta);$i++){ 
											$total = 0;
											//Query para saber cuanto contiene por motivo la ruta;
										?>
										<tr>
											<?php for($z=0;$z<count($arrayMotivo);$z++) { 
												# code...
												$consultaMotivo= "SELECT 
													uc.PPP,SUM(cc.cantidad) AS cantidad, cm.descripcion
												FROM
												    usrcambios uc
												        INNER JOIN
												    capturacambios cc ON uc.NumEmpleado = cc.NumEmpleado
														INNER JOIN
													cambiosmotivos cm ON cc.idCambiosMotivos = cm.idCambiosMotivos
												    WHERE cc.idoperacion = $idoperacion AND uc.ppp = ".$arrayRuta[$i]." AND cc.FechaCambio BETWEEN '$fechaIni' AND '$fechaFin' AND cm.idCambiosMotivos = '".$arrayMotivo[$z]."'
													AND cc.idruta IS NOT NULL
													GROUP BY cm.idCambiosMotivos
												    ORDER BY cm.descripcion";
												$resultadoMotivo = $db->consulta($consultaMotivo);
												$rowMotivo = $db->fetch_assoc($resultadoMotivo);
												$total = $total + $rowMotivo['cantidad'];
												$total = $total;
												$totalt2 = $totalt2 + $rowMotivo['cantidad'];
											?>
												<td><?php echo $rowMotivo['cantidad']?></td>
											<?php 
												$db->liberar($resultadoMotivo);
											}//cierre de for motivo
											?>
											<td><?php echo $total;?></td>
										</tr>
										<?php
											}//cierre de for ruta
										?>
										<tr bgcolor="#c2f0c2">
											<?php echo $tdMotivosTM;?>
											<td> <?php echo $totalt2;?></td>
										</tr>
									</table>
								</td>
								<td></td>
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
						<?php }while($row = $db->fetch_assoc($resultado));?>
					</tbody>
				</table>
			</center>
		</body>
	</html>