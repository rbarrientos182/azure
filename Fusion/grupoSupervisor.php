<?php
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
set_time_limit(0);

require_once("clases/class.MySQL.php");
require_once("clases/class.Utilidades.php");

$mysqli = new MySQL();
$uti = new Utilidades();

$intervalo = $uti->obtenerIntervalo();
$inicio = $_POST['inicio'];
$fin = $_POST['fin'];
$iddeposito = $_POST['iddeposito'];
$consulta = "SELECT DISTINCT
    COUNT(rr.idruta) AS totalRuta,
    SUM(clientesProg) AS clientesProg,
    SUM(clientesvp) AS clientesvp,
    grupo,
    salida,
    llegada,
    CONCAT(FORMAT(AVG((rr.clientesvp / rr.clientesProg) * 100),
                1),
            '%') AS Efectividad_Visita,
    CONCAT(FORMAT(AVG((rr.clientescv / rr.clientesProg) * 100),
                1),
            '%') AS Efectividad_EntregaClientes,
    CONCAT(FORMAT(AVG((rr.cajasef / rr.cajaspfp) * 100),
                1),
            '%') AS Efectividad_EntregaCajas,
    IF(FORMAT(AVG((rr.clientesvp / rr.clientesProg) * 100),
            1) < 98,
        'rRojo',
        'rVerde') AS classEfectividadVisita,
    IF(FORMAT(AVG((rr.clientescv / rr.clientesProg) * 100),
            1) < 98,
        'rRojo',
        'rVerde') AS classEntregaClientes,
    IF(FORMAT(AVG((rr.cajasef / rr.cajaspfp) * 100),
            1) < 98,
        'rRojo',
        IF(FORMAT(AVG((rr.cajasef / rr.cajaspfp) * 100),
                1) < 100,
            'rVerde',
            'rAmarillo')) AS classEntregaCajas,
    AVG((clientescv / clientesprog)) AS EfectividadDeEntrega,
    SEC_TO_TIME(AVG(TIME_TO_SEC(salidaCedis))) AS salidaCedis,
    SEC_TO_TIME(AVG(TIME_TO_SEC(llegadaCedis))) AS llegadaCedis,
    FORMAT(SUM(km), 1) AS KM_Teorico,
    FORMAT(SUM((odometrofin - odometroini)),
        1) AS KM_Real,
    FORMAT(SUM((odometrofin - odometroini) - km),
        1) AS KM_Dif,
    CONCAT(FORMAT(AVG((((rr.odometrofin - rr.odometroini) / km) - 1) * 100),
                1),
            '%') AS desviacion,
    FORMAT(AVG((odometrofin - odometroini) - km),
        1) AS Dif,
    IF(FORMAT(AVG((((rr.odometrofin - rr.odometroini) / km) - 1) * 100),
            1) > 20,
        'rRojo',
        'rVerde') AS classDesviacion,
    CASE rr.tipoMercado
        WHEN 1 THEN '#E0FFFF'
        WHEN 2 THEN '#F0FFF0'
        WHEN 3 THEN '#FFFFE0'
        WHEN 5 THEN '#FFF5EE'
    END AS color,
    IF(TIME_TO_SEC(AVG(rr.salidaCedis)) > TIME_TO_SEC(salida),
        'rRojo',
        'rVerde') AS classSalida,
    IF(TIME_TO_SEC(AVG(rr.llegadaCedis)) > TIME_TO_SEC(llegada),
        'rRojo',
        'rVerde') AS classLlegada
FROM
    resumen_ruta rr
        INNER JOIN
    ruta ru ON ru.iddeposito = rr.iddeposito
        AND ru.idRuta = rr.idRuta
        INNER JOIN
    horariotablero ht ON ht.iddeposito = ru.iddeposito
        AND ht.idRuta = ru.idruta
        INNER JOIN
    operaciones op ON op.iddeposito = rr.iddeposito
        LEFT JOIN
    orden_concentrado ord ON rr.idruta = ord.idruta
        AND op.idoperacion = ord.idoperacion
        AND fecha = DATE_SUB(CURDATE(),INTERVAL $intervalo DAY)
WHERE
    fechaoperacion = DATE_SUB(CURDATE(),INTERVAL $intervalo DAY)
        AND rr.iddeposito = $iddeposito
        AND rr.tiporuta = 6
GROUP BY grupo";
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
					<th colspan="4" class="text-center">Servicio</th>
					<th colspan="8" class="text-center">Productividad y Eficiencia</th>
				</tr>
				<tr>
					<th class="text-center">GS</th>
					<th class="text-center">Total Rutas</th>
					<th class="text-center">Ctes Prog</th>
					<th class="text-center">Ctes V Prog</th>
					<th class="text-center">Efectividad<br> Visita</th>
					<th class="text-center">Efectividad <br>Entrega Clientes</th>
					<th class="text-center">Salida CEDIS</th>
					<th class="text-center">Llegada CEDIS</th>
					<th class="text-center">KM Teorico</th>
					<th class="text-center">KM Real</th>
					<th class="text-center">Dif. +/-</th>
					<th class="text-center">% Desviacion</th>
				</tr>
			</thead>
			<tbody>
				<?php
				do{
					$grupo = $row['grupo'];

					$consulta2 = "SELECT DISTINCT
              (rr.idruta),
              clientesProg,
              clientesvp,
              grupo,
              salida,
              llegada,
              CONCAT(FORMAT((rr.clientesvp / rr.clientesProg) * 100,
                          1),
                      '%') AS Efectividad_Visita,
              CONCAT(FORMAT((rr.clientescv / rr.clientesProg) * 100,
                          1),
                      '%') AS Efectividad_EntregaClientes,
              CONCAT(FORMAT((rr.cajasef / rr.cajaspfp) * 100,
                          1),
                      '%') AS Efectividad_EntregaCajas,
              IF(FORMAT((rr.clientesvp / rr.clientesProg) * 100,
                      1) < 98,
                  'rRojo',
                  'rVerde') AS classEfectividadVisita,
              IF(FORMAT((rr.clientescv / rr.clientesProg) * 100,
                      1) < 98,
                  'rRojo',
                  'rVerde') AS classEntregaClientes,
              IF(FORMAT((rr.cajasef / rr.cajaspfp) * 100,
                      1) < 98,
                  'rRojo',
                  IF(FORMAT((rr.cajasef / rr.cajaspfp) * 100,
                          1) < 100,
                      'rVerde',
                      'rAmarillo')) AS classEntregaCajas,
              (clientescv / clientesprog) AS EfectividadDeEntrega,
              salidaCedis,
              llegadaCedis,
              IF(km IS NULL, FORMAT(0,1), FORMAT(km, 1)) AS KM_Teorico,
              FORMAT((odometrofin - odometroini), 1) AS KM_Real,
              IF((odometrofin - odometroini) - km IS NULL,
                  0,
                  FORMAT((odometrofin - odometroini) - km,
                      1)) AS KM_Dif,
              IF((odometrofin - odometroini) - km IS NULL,
                      0,
                      (odometrofin - odometroini) - km) AS Dif,
              CONCAT(FORMAT((((rr.odometrofin - rr.odometroini) / km) - 1) * 100,
                          1),
                      '%') AS desviacion,
              CONCAT((((rr.odometrofin - rr.odometroini) / km) - 1) * 100) AS desviacionReal,
              IF(FORMAT((((rr.odometrofin - rr.odometroini) / km) - 1) * 100,
                      1) > 20,
                  'rRojo',
                  'rVerde') AS classDesviacion,
              CASE rr.tipoMercado
                  WHEN 1 THEN '#E0FFFF'
                  WHEN 2 THEN '#F0FFF0'
                  WHEN 3 THEN '#FFFFE0'
                  WHEN 5 THEN '#FFF5EE'
              END AS color,
              IF(TIME_TO_SEC(rr.salidaCedis) > TIME_TO_SEC(salida),
                  'rRojo',
                  'rVerde') AS classSalida,
              IF(TIME_TO_SEC(rr.llegadaCedis) > TIME_TO_SEC(llegada),
                  'rRojo',
                  'rVerde') AS classLlegada
          FROM
              resumen_ruta rr
                  INNER JOIN
              ruta ru ON ru.iddeposito = rr.iddeposito
                  AND ru.idRuta = rr.idRuta
                  INNER JOIN
              horariotablero ht ON ht.iddeposito = ru.iddeposito
                  AND ht.idRuta = ru.idruta
                  INNER JOIN
              operaciones op ON op.iddeposito = rr.iddeposito
                  LEFT JOIN
              orden_concentrado ord ON rr.idruta = ord.idruta
                  AND op.idoperacion = ord.idoperacion
                  AND fecha = DATE_SUB(CURDATE(),INTERVAL $intervalo DAY)
          WHERE
              fechaoperacion = DATE_SUB(CURDATE(),INTERVAL $intervalo DAY)
                  AND rr.iddeposito = $iddeposito
                  AND rr.tiporuta = 6
          GROUP BY grupo
          ORDER BY grupo , rr.idruta";
					$resultado2 = $mysqli->consulta($consulta2);
					$row2 = $mysqli->fetch_assoc($resultado2);


					$desv = $row2['desviacion'];
					$classDesv = $row2['classDesviacion'];
					//validacion del % de desviacion
					$claseDif = NULL;
					if($row2['Dif'] <=-20 || $row2['Dif'] >=200){
						$desv = "Revisar km";
						$claseDif = 'rRojo';
						$classDesv = 'rRojo';
						$row['KM_Dif']='';
						$row['KM_Real']='';

					}
				?>
					<tr style='background-color:<?php echo $row['color']?>'>
						<td><?php echo $row['grupo'];?></td>
						<td><?php echo $row['totalRuta'];?></td>
						<td><?php echo $row['clientesProg'];?></td>
						<td><?php echo $row['clientesvp'];?></td>
						<td class="<?php echo $row['classEfectividadVisita']?>"><?php echo $row['Efectividad_Visita'];?></td>
						<td class="<?php echo $row['classEntregaClientes']?>"><?php echo $row['Efectividad_EntregaClientes'];?></td>
						<td class="<?php echo $row['classSalida'];?>"><?php echo $row['salidaCedis'];?></td>
						<td class="<?php echo $row['classLlegada'];?>"><?php echo $row['llegadaCedis'];?></td>
						<td><?php echo $row2['KM_Teorico'];?></td>
						<td class="<?php //echo $claseDif;?>"><?php echo $row2['KM_Real']?></td>
						<td class="<?php //echo $claseDif;?>"><?php echo $row2['KM_Dif']; ?></td>
						<td class="<?php echo $classDesv;?>"><?php echo $desv;?></td>
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
						</tr>";
			    	}
			    }
/*-----------------------------------------------------------------------------------------------------*/
					$consulta3 = "SELECT DISTINCT
					    COUNT((rr.idruta)),
					    FORMAT(SUM(clientesprog), 0) AS cprog,
					    IF(ISNULL(FORMAT(SUM(clientesvp), 0)),
					        0,
					        FORMAT(SUM(clientesvp), 0)) AS tpppVNP,
					    CONCAT(FORMAT(AVG((rr.clientesvp / rr.clientesProg) * 100),
					                1),
					            '%') AS evisita,
					    CONCAT(FORMAT(AVG((rr.clientescv / rr.clientesProg) * 100),
					                1),
					            '%') AS eentrega,
					    CONCAT(FORMAT(AVG((rr.cajasef / rr.cajaspfp) * 100),
					                1),
					            '%') AS eentregac,
					    (clientescv / clientesprog) AS EfectividadDeEntrega,
					    SEC_TO_TIME(AVG(TIME_TO_SEC(salidaCedis))) AS salidaCedis,
					    SEC_TO_TIME(AVG(TIME_TO_SEC(llegadaCedis))) AS llegadaCedis,
					    FORMAT(SUM(km), 1) AS KM_Teorico,
					    FORMAT(SUM((odometrofin - odometroini)),
					        1) AS KM_Real,
						FORMAT(SUM((odometrofin - odometroini) - km),1) AS KM_Dif,
					    CONCAT(FORMAT(AVG((((rr.odometrofin - rr.odometroini) / km) - 1) * 100),
					                1),
					            '%') AS desviacion
					FROM
					    resumen_ruta rr
					        LEFT JOIN
					    (SELECT DISTINCT
					        (idruta), iddeposito, op.idoperacion, km
					    FROM
					        orden ord
					    INNER JOIN Operaciones op ON ord.idoperacion = op.idoperacion
					    WHERE
					        fecha = DATE_SUB(CURDATE(),INTERVAL $intervalo DAY)
					            AND op.iddeposito = $iddeposito) a ON rr.idruta = a.idruta
					        AND rr.iddeposito = a.iddeposito
					WHERE
					    rr.iddeposito = $iddeposito
					        AND fechaOperacion = DATE_SUB(CURDATE(),INTERVAL $intervalo DAY)
					        AND tiporuta = 6
					        AND ((odometrofin - odometroini) -km) BETWEEN -20 AND  200
					GROUP BY rr.iddeposito";
					$resultado3 = $mysqli->consulta($consulta3);
					$row3 = $mysqli->fetch_assoc($resultado3);


					$consulta4 = "SELECT DISTINCT
              COUNT(rr.idruta) AS totalrutas,
              SUM(clientesProg) AS clientesProg,
              SUM(clientesvp) AS clientesvp,
              grupo,
              salida,
              llegada,
              CONCAT(FORMAT(AVG((rr.clientesvp / rr.clientesProg) * 100),
                          1),
                      '%') AS Efectividad_Visita,
              CONCAT(FORMAT(AVG((rr.clientescv / rr.clientesProg) * 100),
                          1),
                      '%') AS Efectividad_EntregaClientes,
              CONCAT(FORMAT(AVG((rr.cajasef / rr.cajaspfp) * 100),
                          1),
                      '%') AS Efectividad_EntregaCajas,
              IF(FORMAT(AVG((rr.clientesvp / rr.clientesProg) * 100),
                      1) < 98,
                  'rRojo',
                  'rVerde') AS classEfectividadVisita,
              IF(FORMAT(AVG((rr.clientescv / rr.clientesProg) * 100),
                      1) < 98,
                  'rRojo',
                  'rVerde') AS classEntregaClientes,
              IF(FORMAT(AVG((rr.cajasef / rr.cajaspfp) * 100),
                      1) < 98,
                  'rRojo',
                  IF(FORMAT(AVG((rr.cajasef / rr.cajaspfp) * 100),
                          1) < 100,
                      'rVerde',
                      'rAmarillo')) AS classEntregaCajas,
              AVG((clientescv / clientesprog)) AS EfectividadDeEntrega,
              SEC_TO_TIME(AVG(TIME_TO_SEC(salidaCedis))) AS salidaCedis,
              SEC_TO_TIME(AVG(TIME_TO_SEC(llegadaCedis))) AS llegadaCedis,
              FORMAT(SUM(km), 1) AS KM_Teorico,
              FORMAT(SUM((odometrofin - odometroini)),
                  1) AS KM_Real,
              FORMAT(SUM((odometrofin - odometroini) - km),
                  1) AS KM_Dif,
              CONCAT(FORMAT(AVG((((rr.odometrofin - rr.odometroini) / km) - 1) * 100),
                          1),
                      '%') AS desviacion,
              FORMAT(AVG((odometrofin - odometroini) - km),
                  1) AS Dif,
              IF(FORMAT(AVG((((rr.odometrofin - rr.odometroini) / km) - 1) * 100),
                      1) > 20,
                  'rRojo',
                  'rVerde') AS classDesviacion,
              CASE rr.tipoMercado
                  WHEN 1 THEN '#E0FFFF'
                  WHEN 2 THEN '#F0FFF0'
                  WHEN 3 THEN '#FFFFE0'
                  WHEN 5 THEN '#FFF5EE'
              END AS color,
              IF(TIME_TO_SEC(AVG(rr.salidaCedis)) > TIME_TO_SEC(salida),
                  'rRojo',
                  'rVerde') AS classSalida,
              IF(TIME_TO_SEC(AVG(rr.llegadaCedis)) > TIME_TO_SEC(llegada),
                  'rRojo',
                  'rVerde') AS classLlegada
          FROM
              resumen_ruta rr
                  INNER JOIN
              ruta ru ON ru.iddeposito = rr.iddeposito
                  AND ru.idRuta = rr.idRuta
                  INNER JOIN
              horariotablero ht ON ht.iddeposito = ru.iddeposito
                  AND ht.idRuta = ru.idruta
                  INNER JOIN
              operaciones op ON op.iddeposito = rr.iddeposito
                  LEFT JOIN
              orden_concentrado ord ON rr.idruta = ord.idruta
                  AND op.idoperacion = ord.idoperacion
                  AND fecha = DATE_SUB(CURDATE(),INTERVAL $intervalo DAY)
          WHERE
              fechaoperacion = DATE_SUB(CURDATE(),INTERVAL $intervalo DAY)
                  AND rr.iddeposito = $iddeposito
                  AND rr.tiporuta = 6";
					$resultado4 = $mysqli->consulta($consulta4);
					$row4 = $mysqli->fetch_assoc($resultado4);
			    ?>
				<tr class="trTotal">
					<td>Total</td>
					<td><?php echo $row4['totalrutas'];?></td>
					<td><?php echo $row4['clientesProg'];?></td>
					<td><?php echo $row4['clientesvp']?></td>
					<td><?php echo $row4['Efectividad_Visita'];?></td>
					<td><?php echo $row4['Efectividad_EntregaClientes'];?></td>
					<td><?php echo $row4['salidaCedis'];?></td>
					<td><?php echo $row4['llegadaCedis'];?></td>
					<td><?php echo $row3['KM_Teorico']?></td>
					<td><?php echo $row3['KM_Real'];?></td>
					<td><?php echo $row3['KM_Dif']?></td>
					<td><?php echo $row3['desviacion']?></td>
				</tr>
			</tbody>
		</table>
	</body>
</html>
