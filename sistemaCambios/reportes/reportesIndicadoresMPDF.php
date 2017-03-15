<?php
set_time_limit(600); 
if (!isset($_SESSION)) 
{
	session_start();
}
date_default_timezone_set('America/Mexico_City');

//header("Content-type: application/vnd.ms-excel");
//header("Content-Disposition: attachment; filename=rIndicadores_Motivo".$fechaIni.'_'.date('H:i:s').".xls");
header("Pragma: no-cache");
header("Expires: 0");

require_once('../clases/class.MySQL.php');
require_once('../dompdf/dompdf_config.inc.php');

$db = new MySQL();

/*$idoperacion = $_SESSION['idoperacion'];
$fechaIni = $_POST['fechaIni'];
$fechaFin = $_POST['fechaFin'];*/

//Query para obtener el total general por Motivo
$consultaTotalGeneral = "SELECT 
    SUM(cc.cantidad) AS total, cm.Descripcion AS motivo
FROM
    cambiosmotivos cm
		INNER JOIN
    capturacambios cc ON cm.idCambiosMotivos = cc.idCambiosMotivos
    AND cc.idruta IS NOT NULL
	AND cc.idoperacion = $idoperacion
    AND cc.FechaCambio BETWEEN '$fechaIni' AND '$fechaFin'
GROUP BY motivo
ORDER BY motivo";
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
			      <td><tt>Reporte Indicadores Motivos</tt></td>
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


$html = '<!DOCTYPE html>
	<html>
		<head>
			<meta charset="UTF-8">
			<title>Reporte Indicadores Motivos</title>
		</head>
		<body>
			<center>
				<table width="750" height="112" border="0">
				  <tbody>
				    '.$encabezado.'
				  </tbody>
				</table>
				<hr>
				<table width="750" height="112" border="0">
					<tbody>';

						 do{
							$html .= '
							<tr>
								<td>
									<table border = "0">
										<tr>
											<td colspan="2"></td>
										</tr>
										<tr>
											<td>'.$row['numgrupo'].'</td>
											<td>'.ucwords(strtolower($row['Nombre'])).'</td>
										</tr>';

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
										
											$html.='<tr>
														<td>Ruta'.$rowR['ruta'].'</td>
														<td></td>
													</tr>';
											}while($rowR = $db->fetch_assoc($resultadoR));
										$html.='<tr>
													<td colspan="2" align="center"> </td>
												</tr>
												</table>
												</td>
												<td>
												<table border="1">';

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
											$contador2++;

										$html .= '<tr>
											<td colspan="'.$contador2.'" align="center" bgcolor="#ABABAB">Motivo</td>	
										</tr>
										<tr>
											'.$tdMotivos.'
											<td>Total</td>
										</tr>';

											//preparamos un for con el array de rutas
											$totalt2=0;
											for($i=0;$i<count($arrayRuta);$i++){ 
											$total = 0;
											//Query para saber cuanto contiene por motivo la ruta;
											$html .= '<tr>';
											for($z=0;$z<count($arrayMotivo);$z++) { 
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

												$html .= '<td>'.$rowMotivo['cantidad'].'</td>';
											
												$db->liberar($resultadoMotivo);
											}//cierre de for motivo
											
											$html .= '<td>'.$total.'</td>
													</tr>';
										
											}//cierre de for ruta
										
										$html .= '<tr bgcolor="#c2f0c2">
											'.$tdMotivosTM.'
											<td>'.$totalt2.'</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<br><td><table style="page-break-after:always;"></table><br></td>
							</tr>
							<tr></tr>';
						}while($row = $db->fetch_assoc($resultado));

						$html .='<tr>
							<td></td>
							<td>
								<table border="1">
									<tr>
										'.$tdTotalGeneral.'
										<td>'.$totalTotal.'</td>
									</tr>
								</table>	
							</td>	
						</tr>
					</tbody>
				</table>
			</center>
		</body>
	</html>';

//echo $html;	

//Instanciamos un objeto de la clase DOMPDF.
$mipdf = new DOMPDF();

//Definimos el tamaño y orientación del papel que queremos.
//O por defecto cogerá el que está en el fichero de configuración.
$mipdf->set_paper("A4", "landscape");

//Cargamos el contenido HTML.
$mipdf->load_html(utf8_decode($html));

//Renderizamos el documento PDF.
$mipdf->render();

//Enviamos el fichero PDF al navegador.
$mipdf->stream("rIndicadores_Motivo".$fechaIni."_".date('H:i:s').".pdf");
?>


