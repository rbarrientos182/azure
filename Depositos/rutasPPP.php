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

$mysqli = new MySQL();

$inicio = $_POST['inicio'];
$fin = $_POST['fin'];
$iddeposito = $_POST['iddeposito'];

 $consulta = "SELECT 
    d.deposito,
    d.iddeposito,
	rr.idruta,
	rr.odometroini,
    rr.odometrofin,
    SUM(rr.clientesProg) as clientes,
    SUM(rr.clientesVP) AS clvp,
    SUM(rr.clientesC) AS clc,
    SUM(rr.clientesVNP) AS clvnp,
    SUM(rr.clientesM2C) AS clm2c,
    SUM(rr.cajasPFP) AS cpfp,
    SUM(rr.cajasPSIOP)  AS cpsiop,
    ROUND(rr.clientesProg * 100 / SUM(rr.clientesM2C),1) AS m2c,
    FORMAT(rr.odometroini-rr.odometrofin,2) AS KM
FROM
deposito d
INNER JOIN
resumen_ruta rr
     ON d.iddeposito = rr.deposito AND
rr.fechaOperacion > CURRENT_DATE
        AND rr.tipoRuta = 3
GROUP BY rr.idruta
ORDER BY rr.idruta
LIMIT ".$inicio.", ".$fin;
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
		<table id="tabla" class="table table-striped table-condensed table-bordered">
			<thead>
				<tr>
					<!--<th class="text-center">Deposito</th>-->
					<th class="text-center">Ruta</th>
					<th class="text-center">Clientes</th>
					<th class="text-center">Clientes V. Programados</th>
					<th class="text-center">Clientes Cerrados</th>
					<th class="text-center">Clientes VNP</th>
					<th class="text-center">Clientes M2C</th>
					<th class="text-center">Cajas Prog F</th>
					<th class="text-center">Cajas SIO</th>
					<th class="text-center">%M2C</th>
					<th class="text-center">%KM</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$count = 0;
				do{
				?>
					<tr>
						<!--<td><?php echo $row['deposito'] ?></td>-->
						<td><?php echo $row['idruta']?></td>
						<td><?php echo $row['clientes']?></td>
						<td><?php echo $row['clvp']?></td>
						<td><?php echo $row['clc'] ?></td>
						<td><?php echo $row['clvnp']?></td>
						<td><?php echo $row['clm2c']?></td>
						<td><?php echo $row['cpfp']?></td>
						<td><?php echo $row['cpsiop']?></td>
						<td><?php echo $row['m2c']?></td>
						<td><?php echo $row['KM']?></td>
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
						</tr>";
			    	}

			    }

				?>
			</tbody>	
		</table>
	</body>
</html>