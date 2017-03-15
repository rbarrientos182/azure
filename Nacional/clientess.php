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
    d.iddeposito,
    op.idoperacion AS numope,
    d.deposito,
    DATE_FORMAT(fecha, '%d/%m/%Y') AS Fecha,
    programadas rprogramadas,
    rutasop.rutasopt - programadas roptimizadas,
    clientes,
    csio,
    FORMAT(Prom_sio, 1) prosio,
    FORMAT(Cfisicas, 1) cgepp,
    FORMAT(prom_fis, 1) progepp,
    FORMAT(equiv, 1) cequi,
    CONCAT(ROUND(M2C, 1), ' %') M2C,
    capacidad,
    FORMAT(km, 1) km
FROM
    deposito d
        LEFT JOIN
    (SELECT
        ord.fecha,
            d.iddeposito,
            d.deposito,
            op.idoperacion,
            ord.idruta,
            COUNT(DISTINCT ord.idruta) programadas,
            COUNT(DISTINCT nud) clientes,
            SUM(csio) Csio,
            SUM(csio) / COUNT(DISTINCT ord.idRuta) Prom_sio,
            SUM(cfisicas) Cfisicas,
            SUM(cfisicas) / COUNT(DISTINCT ord.idRuta) Prom_fis,
            SUM(cequivalentes) Equiv,
            ROUND(SUM(CASE
                WHEN cfisicas < 2 THEN 1
                ELSE 0
            END) * 100 / COUNT(DISTINCT nud), 1) AS M2C,
            capacidad,
            capcamion.km
    FROM
        deposito d
    INNER JOIN operaciones op ON op.iddeposito = d.iddeposito
    LEFT JOIN orden ord ON ord.idoperacion = op.idoperacion
    INNER JOIN (SELECT
        fecha,
            iddeposito,
            CONCAT(ROUND(AVG(capac), 1), ' %') capacidad,
            SUM(km) km
    FROM
        (SELECT
        fecha,
            d.iddeposito,
            ord.idruta,
            SUM(cfisicas) * 100 / capacidad capac,
            km
    FROM
        deposito d
    INNER JOIN operaciones op ON op.iddeposito = d.iddeposito
    LEFT JOIN orden ord ON ord.idoperacion = op.idoperacion
    INNER JOIN ruta r ON r.idruta = ord.idruta
        AND r.idoperacion = ord.idoperacion
    INNER JOIN unidades u ON u.idunidades = r.idunidades
    WHERE
        fecha > CURRENT_DATE
    GROUP BY fecha , d.iddeposito , ord.idruta) capc
    GROUP BY iddeposito) capcamion ON capcamion.iddeposito = d.idDeposito
        AND capcamion.fecha = ord.fecha
    GROUP BY d.deposito) dat ON dat.iddeposito = d.idDeposito
        INNER JOIN
    (SELECT
        d.iddeposito, COUNT(idruta) rutasopt
    FROM
        deposito d
    LEFT JOIN operaciones op ON op.iddeposito = d.iddeposito
    LEFT JOIN ruta r ON r.idoperacion = op.idoperacion
    GROUP BY d.iddeposito) rutasop ON rutasop.iddeposito = d.iddeposito
        INNER JOIN
    operaciones op ON op.iddeposito = d.idDeposito
ORDER BY d.deposito
LIMIT ".$inicio.", ".$fin;
$resultado = $mysqli->consulta($consulta);
$row = $mysqli->fetch_assoc($resultado);
//$resultado = $mysqli->query($consulta);
//$row = $resultado->fetch_assoc();
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
					<th class="text-center">% M2C</th>
					<th class="text-center">% Capacidad</th>
					<th class="text-center">km</th>
					<th class="text-center">Detalle</th>
				</tr>
			</thead>
			<tbody>
				<?php
				do{

					/*$mysqli2 = new mysqli('localhost','gepp','gepp','gepp');

					$idoperacion= $row['numope'];
					//echo '<br>';
					$consulta2 = "SELECT idoperacion, FORMAT(SUM(csio),0) AS vcsio FROM orden WHERE idoperacion = $idoperacion AND fecha > current_date LIMIT 1";
					//$resultado2 =  $mysqli->consulta($consulta2);
					//$row2 = $mysqli->fetch_assoc($resultado2);
					$resultado2 = $mysqli2->query($consulta2);
					$row2 = $resultado2->fetch_assoc();*/
					/*echo $row2['vcsio'];
					echo '<br>';
					echo $row['csio'];
					echo '<br>';]*/
					/*$style = 'active';

					if ($row['csio']==$row2['vcsio'] && $row2['vcsio']!=NULL) {
						$style = 'success';
					}elseif ($row['csio']!=$row2['vcsio']) {
						$style = 'warning';
					}*/
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
						<td><?php echo $row['M2C']?></td>
						<td><?php echo $row['capacidad']?></td>
						<td><?php echo $row['km']?></td>
						<td><a class="btn btn-default btn-xs" href="../dd_deposito/tablarutas.php?idoperacion=<?php echo $idoperacion;?>">Ver Detalles</a></td>
					</tr>
				<?php
				//}while($row = $mysqli->fetch_assoc($resultado));
				//$mysqli->liberar($resultado);
				}while($row = $resultado->fetch_assoc());
			    $mysqli->free();
				?>
			</tbody>
		</table>
	</body>
</html>
