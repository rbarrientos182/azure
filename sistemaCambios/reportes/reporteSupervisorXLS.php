<?php
date_default_timezone_set('America/Mexico_City');
header("Content-type: application/vnd.ms-excel");
header("Content-type: application/x-msexcel");
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; Filename=reporteSupervisor".date('Y-m-d').".xls");
header("Pragma: no-cache"); 
header("Expires: 0");

if (!isset($_SESSION)) 
{
	session_start();
} 

require_once('../clases/class.MySQL.php');

$db = new MySQL();

$idoperacion = $_SESSION['idoperacion'];
$numempleado = $_SESSION['NumEmpleado'];
$nivel = $_SESSION['nivel'];
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
			      <td><tt>Reporte de Cambios</tt></td>
			    </tr>
			    <tr>
			      <td><tt>Deposito:</tt></td>
			      <td><tt>'.$rowDep['idDeposito'].' '.$rowDep['deposito'].'</tt></td>
			    </tr>
			    <tr>
			      <td><tt>Fecha Preventa</tt></td>
			      <td><tt>'.$fechaPreventa.'</tt></td>
			    </tr>
			    <tr>
			      <td><tt>Fecha Entrega</tt></td>
			      <td><tt>'.$fechaEntrega.'</tt></td>
			    </tr>';

			/** Query para obtener los productos en los cambios **/
			//preguntamos si es supervisor
			if($nivel==1){
				$consultaPro = "SELECT 
				cc.idProductoCambio,
				pc.DescripcionInterna,
				COUNT(ru.ruta) AS cuantos
				FROM
				CapturaCambios cc
				INNER JOIN
				productoscambios pc ON cc.idProductoCambio = pc.idProductoCambio
				INNER JOIN
				UsrCambios us ON cc.idoperacion = us.idoperacion
				AND cc.numempleado = us.numempleado
				INNER JOIN
				rutascambios ru ON ru.idoperacion = cc.idoperacion
				AND ru.ruta = us.ppp
				inner join
				gruposupervision gp ON gp.idoperacion = ru.idoperacion
				AND gp.idgruposupervision = ru.idgruposupervision
				WHERE
				fechacambio = '$fechaPreventa' AND cc.idoperacion = $idoperacion AND gp.numempleado = 50104987
				GROUP BY pc.idProductoCambio";
			}
			//si no preguntamos si es admin
			elseif($nivel==4) {
				$consultaPro = "SELECT 
				cc.idProductoCambio,
				pc.DescripcionInterna,
				COUNT(ru.ruta) AS cuantos
				FROM
				CapturaCambios cc
				INNER JOIN
				productoscambios pc ON cc.idProductoCambio = pc.idProductoCambio
				INNER JOIN
				UsrCambios us ON cc.idoperacion = us.idoperacion
				AND cc.numempleado = us.numempleado
				INNER JOIN
				rutascambios ru ON ru.idoperacion = cc.idoperacion
				AND ru.ruta = us.ppp
				inner join
				gruposupervision gp ON gp.idoperacion = ru.idoperacion
				AND gp.idgruposupervision = ru.idgruposupervision
				WHERE
				fechacambio = '$fechaPreventa' AND cc.idoperacion = $idoperacion
				GROUP BY pc.idProductoCambio";
			}
			$resultadoPro = $db->consulta($consultaPro);
			$rowPro = $db->fetch_assoc($resultadoPro);

			if($rowPro['cuantos']!=0)
			{
				/** Creo un array para guardar el id producto cambio **/
				$arrayProductos = array();
				$contP = 0;

				do{

					$tdPro .= '<td width="20"><tt>'.$rowPro['DescripcionInterna'].'</tt></td>';
					$arrayProductos[$contP] = $rowPro['idProductoCambio'];
					$contP++;

				}while($rowPro = $db->fetch_assoc($resultadoPro));
				/** Query para obtener las rutas, cuantos clientes y total de piezas por rutas**/
				if($nivel==1){
					$consulta = "SELECT 
					    ppp AS idruta,
					    COUNT(DISTINCT nud) AS ncliente,
					    SUM(cantidad) AS totalc
					FROM
					    CapturaCambios cc
					        INNER JOIN
					    UsrCambios us ON cc.idoperacion = us.idoperacion
					        AND cc.numempleado = us.numempleado
					        INNER JOIN
					    rutascambios ru ON ru.idoperacion = cc.idoperacion
					        AND ru.ruta = us.ppp
					        INNER JOIN
					    gruposupervision gp ON gp.idoperacion = ru.idoperacion
					        AND gp.idgruposupervision = ru.idgruposupervision
					WHERE
					    gp.numempleado = $numempleado
					        AND fechacambio = '$fechaPreventa'
					        AND cc.idoperacion = $idoperacion
					GROUP BY ppp
					ORDER BY ppp";
				}
				elseif($nivel==4) {
					$consulta = "SELECT 
					    ppp AS idruta,
					    COUNT(DISTINCT nud) AS ncliente,
					    SUM(cantidad) AS totalc
					FROM
					    CapturaCambios cc
					        INNER JOIN
					    UsrCambios us ON cc.idoperacion = us.idoperacion
					        AND cc.numempleado = us.numempleado
					        INNER JOIN
					    rutascambios ru ON ru.idoperacion = cc.idoperacion
					        AND ru.ruta = us.ppp
					WHERE
					    fechacambio = '$fechaPreventa'
					        AND cc.idoperacion = $idoperacion
					GROUP BY ppp
					ORDER BY ppp";	
				}
				$resultado = $db->consulta($consulta);
				$row = $db->fetch_assoc($resultado);

				do{

					/** Inicio un for para sacar los totales por producto y ruta **/
					for ($i=0;$i<count($arrayProductos);$i++){ 

							$consulta3 = "SELECT 
							    IF(SUM(cc.cantidad) > 0,
							        SUM(cc.cantidad),
							        0) AS cantP
							FROM
							    CapturaCambios cc
							        INNER JOIN
							    ProductosCambios pc ON cc.idProductoCambio = pc.idProductoCambio
							    INNER JOIN usrcambios u ON  cc.NumEmpleado = u.NumEmpleado
							WHERE
							    cc.idoperacion = $idoperacion
							AND cc.FechaCambio = '$fechaPreventa'
							AND u.ppp = ".$row['idruta']."
							AND pc.idProductoCambio =".$arrayProductos[$i]." LIMIT 1";
							$resultado3 = $db->consulta($consulta3);
							$row3 = $db->fetch_assoc($resultado3);
							$db->liberar($resultado3);
							$tdCP .= '<td width="20"><tt>'.$row3['cantP'].'</tt></td>';

						}

					$tdBody  .= '<tr>
								    <td><tt>'.$row['idruta'].'</tt></td>
								    <td><tt>'.$row['ncliente'].'</tt></td>
								    <!--'.$tdCM.'-->
								    <!--<td><tt>'.$row['totalC'].'</tt></td>-->
								    <!--<td><tt>.125</tt></td>-->
								    '.$tdCP.'
								</tr>';	
					//$tdCM = NULL;
					$tdCP = NULL; 
				}while($row = $db->fetch_assoc($resultado));
				//echo 'salio while';
			}// fin de if validacion
			//echo 'salio';
?>
	<!doctype html>
		<html>
		<head>
		<meta charset="UTF-8">
		<title>Documento sin título</title>
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
			      <td width="20"><tt>Ruta PPP</tt></td>
			      <td width="20"><tt>#Clientes</tt></td>
			      <!--'.$tdMo.'-->
			      <!--<td width="20"><tt>Total Pzas</tt></td>-->
			      <!--<td width="20"><tt>Cajas Fisicas</tt></td>-->
			      <?php echo $tdPro; ?>
			    </tr>
			    <?php echo $tdBody; ?>
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
		</center>
		</body>
		</html>
