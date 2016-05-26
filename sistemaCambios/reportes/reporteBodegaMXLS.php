<?php

date_default_timezone_set('America/Mexico_City');
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=reporteAdministracion_".$fechaIni.'_'.date('H:i:s').".xls");
header("Pragma: no-cache");
header("Expires: 0");

require_once('../clases/class.MySQL.php');
$db = new MySQL();

///////////////////////////////array dias
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

///////////////////////////Query para obtener el idDeposito
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
  <td><tt>'.$fechaIni.'</tt></td>
</tr>
<tr>
  <td><tt>Fecha Entrega</tt></td>
  <td><tt>'.$fechaEntrega.'</tt></td>
</tr>';
//////////////////////Query para obtener los motivos dados de alta en el deposito
$consultaMo = "SELECT 
    cm.idCambiosMotivos, cm.Descripcion
FROM
    cambiosmotivos cm
		INNER JOIN
    capturacambios cc ON cm.idCambiosMotivos = cc.idCambiosMotivos
	AND cc.idoperacion = $idoperacion
    AND cc.FechaCambio = '$fechaIni'
GROUP BY Descripcion
ORDER BY Descripcion";
$resultadoMo = $db->consulta($consultaMo);
$rowMo = $db->fetch_assoc($resultadoMo);

if($rowMo['idCambiosMotivos']!=''){

	//////////////////////////Creo un array para guardar el id Motivos y formar la tabla
	$arrayMotivos = array();
	$contM = 0;
	do{

		$tdMo .= '<td width="20"><tt>'.$rowMo['Descripcion'].'</tt></td>';
		$arrayMotivos[$contM] = $rowMo['idCambiosMotivos'];
		$contM++;


	}while($rowMo = $db->fetch_assoc($resultadoMo));

	///////////////////////////Query para obtener las rutas, clientes y fecha
	$consulta = "SELECT 
    cc.idruta,
    COUNT(distinct cc.nud) AS ncliente,
    c.nombre AS cliente,
    cc.fechacambio AS fecha,
    cc.cantidad
	FROM
    CapturaCambios cc
        INNER JOIN
    CambiosMotivos cm ON cc.idCambiosMotivos = cm.idCambiosMotivos and idruta!=''
        INNER JOIN
    ProductosCambios pc ON cc.idProductoCambio = pc.idProductoCambio
        INNER JOIN
    UsrCambios uc ON cc.NumEmpleado = uc.NumEmpleado
        INNER JOIN
    Clientes c ON c.nud = cc.nud AND c.idDeposito = $idDeposito
        AND cc.idoperacion = $idoperacion
        AND cc.FechaCambio BETWEEN '$fechaIni' AND '$fechaFin'
	GROUP BY cc.idRuta
	ORDER BY cc.idRuta";

	$resultado = $db->consulta($consulta);
	$row = $db->fetch_assoc($resultado);

	do{
		$sumaMotivos = 0;
		///////////////////////////Inicio un for para sacar los totales por motivo y ruta
		$consulta2 = "SELECT 
		    IF(SUM(cc.cantidad) > 0,
		        SUM(cc.cantidad),
		        0) AS cantM, cm.Descripcion,cm.idCambiosMotivos
		FROM
		    CapturaCambios cc
		        INNER JOIN
		    CambiosMotivos cm ON cc.idCambiosMotivos = cm.idCambiosMotivos
		        AND idruta != ''
		        AND cc.FechaCambio BETWEEN '$fechaIni' AND '$fechaFin'
		        AND cc.idruta = ".$row['idruta']."
				AND cc.idoperacion = $idoperacion
		GROUP BY  cm.Descripcion
		ORDER BY cm.Descripcion";
		$resultado2 = $db->consulta($consulta2);
		$row2 = $db->fetch_assoc($resultado2);
		$contador = 0;
		do{
			for($x=$contador;$x<count($arrayMotivos);$x++){
				if($arrayMotivos[$x]==$row2['idCambiosMotivos']){
					$tdCM .= '<td width="20"><tt>'.$row2['cantM'].'</tt></td>';
					$sumaMotivos = $sumaMotivos + $row2['cantM'];
					$sumaMotivos = $sumaMotivos;
					$x=count($arrayMotivos);
						
				}
				else{
					$tdCM .= '<td width="20"><tt>0</tt></td>';
				}
				$contador++;			
			}
		
		}while($row2 = $db->fetch_assoc($resultado2));

		//relleno las casillas que hicieron falta
		for($y=$contador;$y<count($arrayMotivos);$y++){
			$tdCM .= '<td width="20"><tt>0</tt></td>';
		}
		//echo $tdCM;

		$tdBody  .= '<tr>
					    <td><tt>'.$row['idruta'].'</tt></td>
					    <td><tt>'.$row['ncliente'].'</tt></td>
					    '.$tdCM.'
					    <td><tt>'.$sumaMotivos.'</tt></td>
					</tr>';	
		$tdCM = NULL;
	}while($row = $db->fetch_assoc($resultado));
}//fin de if validacion
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
			      <td width="20"><tt>Ruta</tt></td>
			      <td width="20"><tt>Clientes</tt></td>
			      <?php echo $tdMo; ?>
			      <td width="20"><tt>Total</tt></td>
			      <!--<td width="20"><tt>Cajas Fisicas</tt></td>-->
			    </tr>
			    <?php //echo $consultaMo; ?>
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
