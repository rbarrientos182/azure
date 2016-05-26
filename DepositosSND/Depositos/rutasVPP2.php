<?php
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

set_time_limit(0);

require_once("clases/class.MySQL.php");

$mysqli = new MySQL();

$inicio = $_POST['inicio'];
$fin = $_POST['fin'];
$iddeposito = $_POST['iddeposito'];
$consulta = "SELECT 
r.idruta,
r.clientesProg,
CASE r.tipoMercado
WHEN 1 THEN '#E0FFFF'
WHEN 2 THEN '#F0FFF0'
WHEN 3 THEN '#FFFFE0'
WHEN 5 THEN '#FFF5EE'
END AS color,
IF(ISNULL(nudsvnp),0,nudsvnp) AS pppVNP,
IF(ISNULL(clientesVNP),0,clientesVNP) AS vppVNP,
CONCAT(FORMAT((r.clientesvp/r.clientesProg) * 100,1),'%') AS Efectividad_Visita,
CONCAT(FORMAT((r.clientescv/r.clientesProg) * 100,1),'%') AS Efectividad_EntregaClientes,
CONCAT(FORMAT((r.cajasef/r.cajaspfp) * 100,1),'%') AS Efectividad_EntregaCajas,
IF(FORMAT((r.clientesvp/r.clientesProg) * 100,1)<98,'rRojo','rVerde') AS classEfectividadVisita,
IF(FORMAT((r.clientescv/r.clientesProg) * 100,1)<98,'rRojo','rVerde') AS classEntregaClientes,
IF(FORMAT((r.cajasef/r.cajaspfp) * 100,1)<98,'rRojo',IF(FORMAT((r.cajasef/r.cajaspfp) * 100,1)<100,'rVerde','rAmarillo')) AS classEntregaCajas,
r.salidaCedis,
r.llegadaCedis,
IF(TIME_TO_SEC(r.salidaCedis)>TIME_TO_SEC('07:30:00'),'rRojo','rVerde') AS classSalida,
IF(TIME_TO_SEC(r.llegadaCedis)>TIME_TO_SEC('19:00:00'),'rRojo','rVerde') AS classLlegada,
a.cajasfisicas AS fisicasRoadnet,
r.cajaspfp AS fisicasSistema,
r.cajasEF,
(r.cajasEF - r.cajaspfp) AS rechazo,
IF((((r.cajasEF / r.cajaspfp)-1)*100)<-2,'rRojo','rVerde') AS classRechazo,
CONCAT(FORMAT((r.clientesM2C/r.clientesProg) * 100,1),'%') AS M2C,
IF(FORMAT((r.clientesM2C/r.clientesProg) * 100,1)>5,'rRojo','rVerde') AS classm2c,
FORMAT(a.km, 1) AS KM_Teorico,
FORMAT(r.odometrofin-r.odometroini,1) AS KM_Real,
FORMAT(((r.odometrofin-r.odometroini)-a.km),1) AS KM_Dif,
CONCAT(FORMAT((((r.odometrofin-r.odometroini)/km)-1) * 100,1),'%')  AS desviacion,
IF(FORMAT((((r.odometrofin-r.odometroini)/km)-1) * 100,1)>20,'rRojo','rVerde')  AS classDesviacion
FROM resumen_ruta r 
LEFT JOIN (
SELECT b.iddeposito AS iddeposito, fecha, idruta, km, COUNT(nud) AS paradas, SUM(cfisicas) AS cajasFisicas, SUM(csio) AS cajassio 
FROM orden a 
INNER JOIN operaciones b ON a.idoperacion = b.idoperacion 
WHERE fecha = CURRENT_DATE AND iddeposito = $iddeposito 
GROUP BY idruta
) a ON a.iddeposito = r.iddeposito AND a.fecha = r.fechaoperacion  AND r.idruta = a.idruta
LEFT JOIN (
SELECT d.iddeposito, vpp, 
COUNT(o.nud) nudsvnp 
FROM orden o 
INNER JOIN operaciones op ON op.idoperacion = o.idoperacion
INNER JOIN deposito d ON d.iddeposito = op.iddeposito
INNER JOIN clientes c ON o.nud = c.nud AND c.iddeposito = d.idDeposito
WHERE dia NOT LIKE CONCAT('%',(SELECT CONCAT(ELT(WEEKDAY(fecha_preventa) + 1, 'L', 'M', 'R', 'J', 'V', 'S', 'D'))),'%') AND c.iddeposito = $iddeposito
AND fecha = CURRENT_DATE 
GROUP BY d.idDeposito, vpp
) ffrec ON ffrec.iddeposito = r.iddeposito AND ffrec.vpp = r.idruta 
WHERE r.iddeposito = $iddeposito AND r.fechaOperacion = CURRENT_DATE AND tiporuta = 6
LIMIT $inicio ,$fin";
$resultado = $mysqli->consulta($consulta);
$row = $mysqli->fetch_assoc($resultado);
?>
<!DOCTYPE HTML>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<title>Gepp</title>
	</head>
	<body>
		<table id="tabla" class="table table-condensed table-bordered">
			<thead>
				<tr> 
					<th colspan="7" class="text-center">Servicio</th>
					<th colspan="11" class="text-center">Productividad y Eficiencia</th>
				</tr>
				<tr >
					<!--<th class="text-center">Deposito</th>-->
					<th class="text-center">Ruta</th>
					<th class="text-center">Ctes Prog</th>
					<th class="text-center">Ctes VNP Pvta</th>
					<th class="text-center">Ctes VNP Ent</th>
					<th class="text-center">Efectividad<br> Visita</th>
					<th class="text-center">Efectividad <br>Entrega Clientes</th>
					<!--<th class="text-center">Efectividad <br>Entrega Cajas</th>-->
					<th class="text-center">Salida CEDIS</th>
					<th class="text-center">Llegada CEDIS</th>
					<!--<th class="text-center">Cajas Prog.</th>-->
					<!--<th class="text-center">Cajas Ent.</th>-->
					<th class="text-center">Rechazo</th>
					<th class="text-center">% M2C</th>
					<!--<th class="text-center">Re-Visitas</th>-->
					<th class="text-center">KM Teorico</th>
					<th class="text-center">KM Real</th>
					<th class="text-center">Dif. +/-</th>
					<th class="text-center">% Desviacion</th>
				</tr>
			</thead>
			<tbody>
				<?php
				do{
				?>
					<tr style='background-color:<?php echo $row['color']?>'>
						<!--<td><?php echo $row['deposito'] ?></td>-->
						<td><?php echo $row['idruta'];?></td>
						<td><?php echo $row['clientesProg'];?></td>
						<td><?php echo $row['pppVNP'];?></td>
						<td><?php echo $row['vppVNP'];?></td>
						<td class="<?php echo $row['classEfectividadVisita']?>"><?php echo $row['Efectividad_Visita'];?></td>
						<td class="<?php echo $row['classEntregaClientes']?>"><?php echo $row['Efectividad_EntregaClientes'];?></td>
						<!--<td class="<?php echo $row['classEntregaCajas']?>"><?php echo $row['Efectividad_EntregaCajas'];?></td>-->
						<td class="<?php echo $row['classSalida'];?>"><?php echo $row['salidaCedis'];?></td>
						<td class="<?php echo $row['classLlegada'];?>"><?php echo $row['llegadaCedis'];?></td>
						<!--<td><?php echo $row['fisicasSistema'];?></td>-->
						<!--<td><?php echo $row['cajasEF'];?></td>-->
						<td class="<?php echo $row['classRechazo'];?>"><?php echo $row['rechazo'];?></td>
						<td class="<?php echo $row['classm2c']?>"><?php echo $row['M2C'];?></td>
						<!--<td><?php ?></td>-->
						<td><?php echo $row['KM_Teorico'];?></td>
						<td><?php echo $row['KM_Real']; ?></td>
						<td><?php echo $row['KM_Dif']; ?></td>
						<td class="<?php echo $row['classDesviacion'];?>"><?php echo $row['desviacion'];?></td>
					</tr>
				<?php 
				$count++;
				}while($row = $mysqli->fetch_assoc($resultado));
			    $mysqli->liberar($resultado);
			    if ($count < 15){
			    	for ($i=$count; $i < 16 ; $i++) { 
				    	echo "<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<!--<td></td>
							<td></td>
							<td></td>
							<td></td>-->
							<td></td>
						</tr>";
			    	}
			    }

			        $consulta2 = "SELECT COUNT(idruta),
					FORMAT(SUM(clientesProg),0) AS cprog,
					IF(ISNULL(FORMAT(SUM(pppVNP),0)),0,FORMAT(SUM(pppVNP),0)) AS tpppVNP,
					FORMAT(SUM(vppVNP),0) AS tvppVNP,
					CONCAT(FORMAT(AVG(Efectividad_Visita),1),'%') AS evisita,
					CONCAT(FORMAT(AVG(Efectividad_EntregaClientes),1),'%') AS eentrega,
					CONCAT(FORMAT(AVG(Efectividad_EntregaCajas),1),'%') AS eentregac, 
					SEC_TO_TIME(AVG(salidaCedis)) AS salidaCedis,
					SEC_TO_TIME(AVG(llegadaCedis)) AS llegadaCedis,
					FORMAT(SUM(fisicasSistema),0) AS cajaspfp,
					FORMAT(SUM(cajasEF),0) AS cajasef,
					FORMAT(SUM(rechazo),0) AS rechazo,
					CONCAT(FORMAT(AVG(M2C),1),'%') AS m2c,
					FORMAT(SUM(KM_Teorico),1) AS KM_Teorico,
					FORMAT(SUM(KM_Real),1) AS KM_Real,
					FORMAT(SUM(KM_Dif),1) AS KM_Dif,
					CONCAT(FORMAT(AVG(desviacion),1),'%') AS desviacion
					FROM 
					(
					SELECT 
					r.iddeposito,
					r.idruta,
					r.clientesProg,
					nudsvnp AS pppVNP,
					clientesVNP AS vppVNP,
					CONCAT(FORMAT((r.clientesvp/r.clientesProg) * 100,1),'%') AS Efectividad_Visita,
					CONCAT(FORMAT((r.clientescv/r.clientesProg) * 100,1),'%') AS Efectividad_EntregaClientes,
					CONCAT(FORMAT((r.cajasef/r.cajaspfp) * 100,1),'%') AS Efectividad_EntregaCajas,
					TIME_TO_SEC(r.salidaCedis) AS salidaCedis,
					TIME_TO_SEC(r.llegadaCedis) AS llegadaCedis,
					a.cajasfisicas AS fisicasRoadnet,
					r.cajaspfp AS fisicasSistema,
					r.cajasEF,
					(r.cajasEF - r.cajaspfp) AS rechazo,
					CONCAT(FORMAT((r.clientesM2C/r.clientesProg) * 100,1),'%') AS M2C,
					FORMAT(a.km, 1) AS KM_Teorico,
					FORMAT(r.odometrofin-r.odometroini,1) AS KM_Real,
					FORMAT(((r.odometrofin-r.odometroini)-a.km),1) AS KM_Dif,
					CONCAT(FORMAT((((r.odometrofin-r.odometroini)/km)-1) * 100,1),' %')  AS desviacion 
					FROM resumen_ruta r  
					LEFT JOIN (
					SELECT b.iddeposito AS iddeposito, fecha, idruta, km, COUNT(nud) AS paradas, SUM(cfisicas) AS cajasFisicas, SUM(csio) AS cajassio 
					FROM orden a 
					INNER JOIN operaciones b ON a.idoperacion = b.idoperacion 
					WHERE fecha = CURRENT_DATE AND iddeposito = $iddeposito 
					GROUP BY idruta
					) a ON a.iddeposito=r.iddeposito AND a.fecha=r.fechaoperacion AND r.idruta=a.idruta
					LEFT JOIN (
					SELECT d.iddeposito, vpp, 
					COUNT(o.nud) nudsvnp 
					FROM orden o 
					INNER JOIN operaciones op ON op.idoperacion = o.idoperacion
					INNER JOIN deposito d ON d.iddeposito = op.iddeposito
					INNER JOIN clientes c ON o.nud = c.nud AND c.iddeposito = d.idDeposito
					WHERE dia NOT LIKE CONCAT('%',(SELECT CONCAT(ELT(WEEKDAY(fecha_preventa) + 1, 'L', 'M', 'R', 'J', 'V', 'S', 'D'))),'%') AND c.iddeposito = $iddeposito
					AND fecha = CURRENT_DATE 
					GROUP BY d.idDeposito, vpp
					) ffrec ON ffrec.iddeposito = r.iddeposito AND ffrec.vpp = r.idruta 
					WHERE r.iddeposito = $iddeposito AND r.fechaOperacion = CURRENT_DATE AND tiporuta = 6 LIMIT $inicio, $fin
					) tt
					GROUP BY iddeposito";
					$resultado2 = $mysqli->consulta($consulta2);
					$row2 = $mysqli->fetch_assoc($resultado2);
/*-----------------------------------------------------------------------------------------------------*/
					$consulta3 = "SELECT COUNT(idruta),
					FORMAT(SUM(clientesProg),0) AS cprog,
					IF(ISNULL(FORMAT(SUM(pppVNP),0)),0,FORMAT(SUM(pppVNP),0)) AS tpppVNP,
					FORMAT(SUM(vppVNP),0) AS tvppVNP,
					CONCAT(FORMAT(AVG(Efectividad_Visita),1),'%') AS evisita,
					CONCAT(FORMAT(AVG(Efectividad_EntregaClientes),1),'%') AS eentrega,
					CONCAT(FORMAT(AVG(Efectividad_EntregaCajas),1),'%') AS eentregac, 
					SEC_TO_TIME(AVG(salidaCedis)) AS salidaCedis,
					SEC_TO_TIME(AVG(llegadaCedis)) AS llegadaCedis,
					FORMAT(SUM(fisicasSistema),0) AS cajaspfp,
					FORMAT(SUM(cajasEF),0) AS cajasef,
					FORMAT(SUM(rechazo),0) AS rechazo,
					CONCAT(FORMAT(AVG(M2C),1),'%') AS m2c,
					FORMAT(SUM(KM_Teorico),1) AS KM_Teorico,
					FORMAT(SUM(KM_Real),1) AS KM_Real,
					FORMAT(SUM(KM_Dif),1) AS KM_Dif,
					CONCAT(FORMAT(AVG(desviacion),1),'%') AS desviacion
					FROM 
					(
					SELECT 
					r.iddeposito,
					r.idruta,
					r.clientesProg,
					nudsvnp AS pppVNP,
					clientesVNP AS vppVNP,
					CONCAT(FORMAT((r.clientesvp/r.clientesProg) * 100,1),'%') AS Efectividad_Visita,
					CONCAT(FORMAT((r.clientescv/r.clientesProg) * 100,1),'%') AS Efectividad_EntregaClientes,
					CONCAT(FORMAT((r.cajasef/r.cajaspfp) * 100,1),'%') AS Efectividad_EntregaCajas,
					TIME_TO_SEC(r.salidaCedis) AS salidaCedis,
					TIME_TO_SEC(r.llegadaCedis) AS llegadaCedis,
					a.cajasfisicas AS fisicasRoadnet,
					r.cajaspfp AS fisicasSistema,
					r.cajasEF,
					(r.cajasEF - r.cajaspfp) AS rechazo,
					CONCAT(FORMAT((r.clientesM2C/r.clientesProg) * 100,1),'%') AS M2C,
					FORMAT(a.km, 1) AS KM_Teorico,
					FORMAT(r.odometrofin-r.odometroini,1) AS KM_Real,
					FORMAT(((r.odometrofin-r.odometroini)-a.km),1) AS KM_Dif,
					CONCAT(FORMAT((((r.odometrofin-r.odometroini)/km)-1) * 100,1),' %')  AS desviacion 
					FROM resumen_ruta r  
					LEFT JOIN (
					SELECT b.iddeposito AS iddeposito, fecha, idruta, km, COUNT(nud) AS paradas, SUM(cfisicas) AS cajasFisicas, SUM(csio) AS cajassio 
					FROM orden a 
					INNER JOIN operaciones b ON a.idoperacion = b.idoperacion 
					WHERE fecha = CURRENT_DATE AND iddeposito = $iddeposito 
					GROUP BY idruta
					) a ON a.iddeposito=r.iddeposito AND a.fecha=r.fechaoperacion AND r.idruta=a.idruta
					LEFT JOIN (
					SELECT d.iddeposito, vpp, 
					COUNT(o.nud) nudsvnp 
					FROM orden o 
					INNER JOIN operaciones op ON op.idoperacion = o.idoperacion
					INNER JOIN deposito d ON d.iddeposito = op.iddeposito
					INNER JOIN clientes c ON o.nud = c.nud AND c.iddeposito = d.idDeposito
					WHERE dia NOT LIKE CONCAT('%',(SELECT CONCAT(ELT(WEEKDAY(fecha_preventa) + 1, 'L', 'M', 'R', 'J', 'V', 'S', 'D'))),'%') AND c.iddeposito = $iddeposito
					AND fecha = CURRENT_DATE 
					GROUP BY d.idDeposito, vpp
					) ffrec ON ffrec.iddeposito = r.iddeposito AND ffrec.vpp = r.idruta 
					WHERE r.iddeposito = $iddeposito AND r.fechaOperacion = CURRENT_DATE AND tiporuta = 6 
					) tt
					GROUP BY iddeposito";
					$resultado3 = $mysqli->consulta($consulta3);
					$row3 = $mysqli->fetch_assoc($resultado3);
			    ?>
				<tr class="trSubTotal">
					<td>SubTotal</td>
					<td><?php echo $row2['cprog'];?></td>
					<td><?php echo $row2['tpppVNP']?></td>
					<td><?php echo $row2['tvppVNP'];?></td>
					<td><?php echo $row2['evisita'];?></td>
					<td><?php echo $row2['eentrega'];?></td>
				    <!--<td><?php echo $row2['eentregac'];?></td>-->
					<td><?php echo $row2['salidaCedis'];?></td>
					<td><?php echo $row2['llegadaCedis'];?></td>
					<!--<td><?php echo $row2['cajaspfp'];?></td>-->
					<!--<td><?php echo $row2['cajasef'];?></td>-->
					<td><?php echo $row2['rechazo'];?></td>
					<td><?php echo $row2['m2c'];?></td>
					<!--<td><?php ?></td>-->
					<td><?php echo $row2['KM_Teorico']?></td>
					<td><?php echo $row2['KM_Real'];?></td>
					<td><?php echo $row2['KM_Dif']?></td>
					<td><?php echo $row2['desviacion']?></td>
				</tr>
				<tr class="trTotal">
					<td>Total</td>
					<td><?php echo $row3['cprog'];?></td>
					<td><?php echo $row3['tpppVNP']?></td>
					<td><?php echo $row3['tvppVNP'];?></td>
					<td><?php echo $row3['evisita'];?></td>
					<td><?php echo $row3['eentrega'];?></td>
				    <!--<td><?php echo $row3['eentregac'];?></td>-->
					<td><?php echo $row3['salidaCedis'];?></td>
					<td><?php echo $row3['llegadaCedis'];?></td>
					<!--<td><?php echo $row3['cajaspfp'];?></td>-->
					<!--<td><?php echo $row3['cajasef'];?></td>-->
					<td><?php echo $row3['rechazo'];?></td>
					<td><?php echo $row3['m2c'];?></td>
					<!--<td><?php ?></td>-->
					<td><?php echo $row3['KM_Teorico']?></td>
					<td><?php echo $row3['KM_Real'];?></td>
					<td><?php echo $row3['KM_Dif']?></td>
					<td><?php echo $row3['desviacion']?></td>
				</tr>
			</tbody>	
		</table>
	</body>
</html>