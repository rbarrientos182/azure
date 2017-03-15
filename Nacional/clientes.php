<?php
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

set_time_limit(0);

require_once("clases/class.MySQL.php");

$mysqli = new MySQL();
//$mysqli = new mysqli('localhost','gepp','gepp','gepp');


$inicio = $_POST['inicio'];
$fin = $_POST['fin'];

$consulta = "SELECT
    deposito,
    COUNT(oc.idruta) AS rprogramadas,
    rutasopt,
    rutasopt - COUNT(oc.idruta) AS roptimizadas,
    SUM(ctesprog) AS clientes,
    SUM(csio) AS csio,
    FORMAT(AVG(csio), 1) AS prosio,
    SUM(cfisicas) AS cgepp,
    FORMAT(AVG(cfisicas), 1) AS progepp,
    FORMAT(AVG(km), 1) AS km
FROM
    orden_concentrado oc
        INNER JOIN
    operaciones o ON oc.idoperacion = o.idoperacion
        INNER JOIN
    deposito d ON o.iddeposito = d.idDeposito
        INNER JOIN
    (SELECT
        d.iddeposito, COUNT(idruta) AS rutasopt
    FROM
        deposito d
    LEFT JOIN ruta r ON d.idDeposito = r.iddeposito
    GROUP BY d.iddeposito) AS rutasop ON rutasop.iddeposito = d.iddeposito
WHERE
    fecha_preventa = CURRENT_DATE
GROUP BY deposito
ORDER BY deposito
LIMIT ".$inicio.", ".$fin;
$resultado = $mysqli->consulta($consulta);
$row = $mysqli->fetch_assoc($resultado);

//echo $consulta;
?>
<!DOCTYPE HTML>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<title>Gepp</title>
	</head>
	<body>
		<table id="tabla" class="table table-striped table-condensed table-bordered">
			<thead>
				<tr>
					<th class="text-center">Deposito</th>
					<th class="text-center">Rutas Prog.</th>
					<th class="text-center">Rutas Opt.</th>
					<th class="text-center">Clientes</th>
					<th class="text-center">Cajas SIO</th>
					<th class="text-center">Prom. SIO</th>
					<th class="text-center">Cajas Fisicas</th>
					<th class="text-center">Prom. Fisicas</th>
					<!--<th class="text-center">% M2C</th>
					<th class="text-center">% Capacidad</th>-->
					<th class="text-center">km</th>
					<!--<th class="text-center">Detalle</th>-->
				</tr>
			</thead>
			<tbody>
				<?php
				do{
				?>


					<tr>
						<td><?php echo $row['deposito'] ?></td>
						<td><?php echo $row['rprogramadas']?></td>
						<td><?php echo $row['roptimizadas']?></td>
						<td><?php echo $row['clientes'] ?></td>
						<td><?php echo $row['csio']?></td>
						<td><?php echo $row['prosio']?></td>
						<td><?php echo $row['cgepp']?></td>
						<td><?php echo $row['progepp']?></td>
						<!--<td><?php echo $row['M2C']?></td>
						<td><?php echo $row['capacidad']?></td>-->
						<td><?php echo $row['km']?></td>
						<!--<td><a class="btn btn-default btn-xs" href="../dd_deposito/tablarutas.php?idoperacion=<?php echo $idoperacion;?>">Ver Detalles</a></td>-->
					</tr>
				<?php
				}while($row = $resultado->fetch_assoc());
			    $mysqli->free();
				?>
			</tbody>
		</table>
	</body>
</html>
