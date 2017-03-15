<?php
// Desactivar toda notificación de error
error_reporting(0);
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
$idoperacion = $_POST['idoperacion'];

//$idoperacion = 2;

echo $consulta = "SELECT 
    r.iddeposito,
    deposito,
    o.idoperacion AS idoperacion,
    o.fecha AS fecha,
    o.idruta AS Ruta,
    COUNT(DISTINCT nud) AS Clientes,
    SUM(csio) AS CSIO,
    ROUND(SUM(cfisicas)) AS cfisicas,
    ROUND(SUM(cequivalentes), 1) AS CEqui,
    IF(ISNULL(ROUND(mnud * 100 / COUNT(DISTINCT nud), 1)),
        0,
        ROUND(mnud * 100 / COUNT(DISTINCT nud), 1)) AS M2C,
    CONCAT(ROUND((SUM(cfisicas) * 100) / capacidad, 1),
            '%') AS Capacidad,
    ROUND(km, 1) AS km
FROM
    orden o
        INNER JOIN
    (SELECT 
        deposito,
            op.idoperacion AS idoperacion,
            op.iddeposito AS iddeposito,
            ru.idruta AS idruta,
            capacidad
    FROM
        ruta ru
    INNER JOIN unidades un ON ru.idunidades = un.idunidades
    INNER JOIN operaciones op ON ru.idoperacion = op.idoperacion
    INNER JOIN deposito dep ON dep.iddeposito = op.iddeposito) r ON o.idruta = r.idruta
        AND o.idoperacion = r.idoperacion
        LEFT JOIN
    (SELECT 
        fecha,
            o.idoperacion AS idoperacion,
            o.idruta AS idruta,
            mnud
    FROM
        orden o
    INNER JOIN Ruta r ON o.idoperacion = r.idoperacion
        AND o.idoperacion = $idoperacion
        AND o.idruta = r.idruta
        AND fecha = DATE_SUB(CURDATE(),INTERVAL $intervalo DAY)
    LEFT JOIN (SELECT 
        idoperacion, idruta, COUNT(nud) AS mnud
    FROM
        orden
    WHERE
        idoperacion = $idoperacion AND fecha = DATE_SUB(CURDATE(),INTERVAL $intervalo DAY)
            AND cfisicas < 2
    GROUP BY idoperacion , idruta) b ON o.idoperacion = b.idoperacion
        AND o.idruta = b.idruta
    WHERE
        fecha = DATE_SUB(CURDATE(),INTERVAL $intervalo DAY)
    GROUP BY o.idoperacion , o.idruta) datos ON datos.idruta = o.idruta
        AND datos.idoperacion = o.idoperacion
WHERE
    o.idoperacion = $idoperacion
        AND o.fecha = DATE_SUB(CURDATE(),INTERVAL $intervalo DAY)
        AND CURRENT_TIME < '13:00:00'
GROUP BY o.fecha , o.idoperacion , o.idruta
LIMIT ".$inicio." , ".$fin;
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
					<!--<th class="text-center">Deposito</th>-->
					<th class="text-center">Ruta</th>
					<th class="text-center">Clientes</th>
					<th class="text-center">Cajas SIO</th>
					<th class="text-center">Cajas Fisicas</th>
					<th class="text-center">M2C</th>
					<th class="text-center">Capacidad</th>
					<th class="text-center">KM</th>
				</tr>
			</thead>
			<tbody>
				<?php
				do{
				?>
					<tr>
						<!--<td><?php echo $row['deposito'] ?></td>-->
						<td><?php echo $row['Ruta']?></td>
						<td><?php echo $row['Clientes']?></td>
						<td><?php echo $row['CSIO'] ?></td>
						<td><?php echo $row['cfisicas']?></td>
						<td><?php echo $row['M2C']?></td>
						<td><?php echo $row['Capacidad']?></td>
						<td><?php echo $row['km']?></td>
					</tr>
				<?php 
				}while($row = $resultado->fetch_assoc());
			    $mysqli->free();
				?>
			</tbody>	
		</table>
	</body>
</html>