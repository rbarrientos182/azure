<?php
if (!isset($_SESSION)) 
{
	session_start();
} 

/*header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=reporteSupervisor.xls");
header("Pragma: no-cache");
header("Expires: 0");*/

require_once('../clases/class.MySQL.php');

$db = new MySQL();

$idoperacion = $_SESSION['idoperacion'];
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
echo $consultaDep = "SELECT d.idDeposito, d.deposito, r.region FROM Operaciones o 
INNER JOIN Deposito d ON d.idDeposito = o.idDeposito 
INNER JOIN Zona z ON z.idZona = d.idZona 
INNER JOIN Region r ON r.idRegion = z.idRegion 
WHERE o.idoperacion = ".$idoperacion." LIMIT 1";
$resultadoDep = $db->consulta($consultaDep);
$rowDep = $db->fetch_assoc($resultadoDep);

$idDeposito = $rowDep['idDeposito'];


$encabezado = '<tr>
			      <td width="250"><tt>Gepp</tt></td>
			      <td width="250"><tt>Compañía:</tt></td>
			      <td width="250"><tt>Gepp S de RL de CV</tt></td>
			    </tr>
			    <tr>
			      <td><tt>Reporte de Cambios</tt></td>
			      <td><tt>Deposito:</tt></td>
			      <td><tt>'.$rowDep['idDeposito'].' '.$rowDep['deposito'].'</tt></td>
			    </tr>
			    <tr>
			      <td><tt>Grupos Supervisión:</tt></td>
			      <td><tt>Fecha Preventa</tt></td>
			      <td><tt>'.$fechaPreventa.'</tt></td>
			    </tr>
			    <tr>
			      <td><tt>Fecha Entrega</tt></td>
			      <td><tt>'.$fechaEntrega.'</tt></td>
			    </tr>';
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

				$tdMo .= '<td width="20"><tt>'.$rowMo['Descripcion'].'</tt></td>';
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

				$tdPro .= '<td width="20"><tt>'.$rowPro['DescripcionInterna'].'</tt></td>';
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


					$tdCM .= '<td width="20"><tt>'.$row2['cantM'].'</tt></td>';
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
				$tdCM = NULL;
				$tdCP = NULL; 

			}while($row = $db->fetch_assoc($resultado));

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
			<p>&nbsp;</p>
			<hr>
			<p>&nbsp;</p>
			<table width="750" height="112" border="0">
			  <tbody>
			    <tr>
			      <td width="20"><tt>Ruta</tt></td>
			      <td width="20"><tt>#Clientes</tt></td>
			      <!--'.$tdMo.'-->
			      <!--<td width="20"><tt>Total Pzas</tt></td>-->
			      <!--<td width="20"><tt>Cajas Fisicas</tt></td>-->
			     <?php echo $tdPro ?>
			    </tr>
			    <?php echo $tdBody ?>
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
		</html>
