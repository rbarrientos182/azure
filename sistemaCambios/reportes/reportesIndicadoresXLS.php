<?php
set_time_limit(600); 
if (!isset($_SESSION)) 
{
	session_start();
}
date_default_timezone_set('America/Mexico_City');

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=reporteIndicadores_".$fechaPreventa.'_'.date('H:i:s').".xls");
header("Pragma: no-cache");
header("Expires: 0");

require_once('../clases/class.MySQL.php');
$db = new MySQL();

$idoperacion = $_SESSION['idoperacion'];
$fechaPreventa = $_POST['fechaPre'];

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
											$consultaR = "SELECT ruta FROM rutasCambios WHERE idoperacion = $idoperacion AND idgruposupervision = ".$row['idgruposupervision']." ORDER BY ruta";
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
											    p.sku, s.descripcion as segmento
											FROM
											    productos p
											    	INNER JOIN
											    segmento s ON p.idsegmento = s.idsegmento
											        INNER JOIN
											    ProductosCambios pc ON p.sku = pc.sku AND idoperacion = $idoperacion
											GROUP BY segmento
											ORDER BY segmento";
											$resultadoS = $db->consulta($consultaS);
											$rowS = $db->fetch_assoc($resultadoS);
											$contador = 0;
											$arraySegmento = array();
											$tdSegmento = "";
											do{
												$tdSegmento .= "<td>".utf8_encode($rowS['segmento'])."</td>";
												$arraySegmento[$contador] = $rowS['segmento'];
												$contador++;
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
														        AND cc.FechaCambio = '$fechaPreventa'
														        AND s.descripcion = '".$arraySegmento[$z]."'
														GROUP BY s.descripcion
														ORDER BY s.descripcion";
												$resultadoSegmento = $db->consulta($consultaSegmento);
												$rowSegmento = $db->fetch_assoc($resultadoSegmento);
												$total = $total + $rowSegmento['cantidad'];
												$total = $total;
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
									</table>
								</td>
								<td></td>
								<td>
									<table border="1">
										<?php 
											$consultaM = "SELECT 
											    idCambiosMotivos, Descripcion
											FROM
											    cambiosmotivos cm WHERE
											    idoperacion = $idoperacion
											ORDER BY Descripcion";
											$resultadoM = $db->consulta($consultaM);
											$rowM = $db->fetch_assoc($resultadoM);
											$contador2 = 0;
											$tdMotivos = "";
											$arrayMotivo = array();
											do{
												$tdMotivos .= "<td>".utf8_encode($rowM['Descripcion'])."</td>";
												$arrayMotivo[$contador2] = $rowM['idCambiosMotivos'];
												$contador2++;
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
												    WHERE cc.idoperacion = $idoperacion AND uc.ppp = ".$arrayRuta[$i]." AND cc.FechaCambio = '$fechaPreventa' AND cm.idCambiosMotivos = '".$arrayMotivo[$z]."'
													GROUP BY cm.idCambiosMotivos
												    ORDER BY cm.descripcion";
												$resultadoMotivo = $db->consulta($consultaMotivo);
												$rowMotivo = $db->fetch_assoc($resultadoMotivo);
												$total = $total + $rowMotivo['cantidad'];
												$total = $total;
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
											presentacion pr ON p.idpresentacion = p.idpresentacion
											        INNER JOIN
											    ProductosCambios pc ON p.sku = pc.sku AND idoperacion = $idoperacion
											GROUP BY pr.descripcion
											ORDER BY pr.descripcion";
											$resultadoP = $db->consulta($consultaP);
											$rowP = $db->fetch_assoc($resultadoP);
											$contador3 = 0;
											$tdPresentacion = "";
											$arrayPresentacion = array();
											do{
												$tdPresentacion .= "<td>".utf8_encode($rowP['presentacion'])."</td>";
												$arrayPresentacion[$contador3] = $rowP['presentacion'];
												$contador3++;
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
												        AND cc.FechaCambio = '$fechaPreventa'
												        AND pr.descripcion = '".$arrayPresentacion[$z]."'
												GROUP BY pr.descripcion
												ORDER BY pr.descripcion";
												$resultadoPresentacion = $db->consulta($consultaPresentacion);
												$rowPresentacion = $db->fetch_assoc($resultadoPresentacion);
												$total = $total + $rowPresentacion['cantidad'];
												$total = $total;
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
									</table>
								</td>
							</tr>
						<?php }while($row = $db->fetch_assoc($resultado));?>
					</tbody>
				</table>
			</center>
		</body>
	</html>