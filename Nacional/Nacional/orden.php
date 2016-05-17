<?php
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
$mysqli = NULL;

require_once("clases/class.MySQL.php");
$mysqli = new MySQL();

  $inicio = $_POST['inicio'];
  $fin = $_POST['fin'];



$consulta = "SELECT  deposito.iddeposito, operaciones.idoperacion AS numope, deposito.Deposito AS Deposito, Fecha, rprogramadas, roptimizadas, Clientes, csio, cgepp, cequi, M2C,capacidad  FROM ruta inner join operaciones ON ruta.idoperacion=operaciones.idoperacion INNER JOIN deposito ON operaciones.iddeposito=deposito.iddeposito LEFT JOIN 
(SELECT Deposito, dd.idoperacion AS numoperacion,  date_format(fecha, '%d/%m/%Y') AS Fecha,  COUNT(distinct Ruta) AS rprogramadas,((SELECT COUNT(idruta) FROM Ruta WHERE dd.idoperacion=ruta.idoperacion AND dd.fecha > current_date)-COUNT(distinct Ruta)) AS roptimizadas, format(sum(clientes),0) AS Clientes, format(sum(csio),0) AS csio, format(sum(cgepp),1) AS cgepp, format(sum(cequi),1) AS cequi, concat(round(avg(m2c),1),' %') AS M2C, concat(round(avg(capacidad),1),' %') AS capacidad FROM 
(
SELECT r.iddeposito, deposito, o.idoperacion AS idoperacion, o.fecha AS fecha, o.idruta AS Ruta, COUNT(distinct nud) AS Clientes,  SUM(csio) AS CSIO ,round(SUM(csio * conversion),1) AS CGepp, round(SUM(cequivalentes),1) AS CEqui, round(mnud*100/count(distinct nud),1) AS M2C,  round((sum(csio * conversion)*100)/capacidad,1) AS Capacidad FROM orden o INNER JOIN productos p ON o.sku=p.sku INNER JOIN
(SELECT deposito, op.idoperacion AS idoperacion, op.iddeposito AS iddeposito,  ru.idruta AS idruta,  capacidad  FROM ruta ru INNER JOIN unidades un ON ru.idunidades=un.idunidades INNER JOIN operaciones op ON ru.idoperacion=op.idoperacion INNER JOIN deposito dep ON dep.iddeposito=op.iddeposito) r ON o.idruta=r.idruta AND o.idoperacion=r.idoperacion INNER JOIN 
(SELECT fecha, ord.idoperacion AS idoperacion, r.idruta AS idruta, COUNT(distinct hh.nud) AS mnud FROM ruta r INNER JOIN orden ord ON r.idruta=ord.idruta AND r.idoperacion=ord.idoperacion AND fecha > current_date LEFT JOIN
(SELECT o.idoperacion AS idoperacion, o.idruta AS idruta, nud ,SUM(csio),  SUM(csio*conversion) FROM orden o INNER JOIN productos p ON p.sku = o.sku AND fecha > current_date GROUP BY idoperacion, idruta, nud , fecha HAVING SUM(CSIO * conversion) < 2 ) hh ON r.idruta=hh.idruta AND r.idoperacion=hh.idoperacion WHERE fecha > current_date  GROUP BY fecha, hh.idoperacion, r.idruta) datos ON datos.idruta=o.idruta AND datos.idoperacion=o.idoperacion WHERE o.fecha > current_date GROUP BY o.fecha, o.idoperacion, o.idruta
) dd  GROUP BY idoperacion
) cc ON ruta.idoperacion=cc.numoperacion GROUP BY ruta.idoperacion ORDER BY deposito.Deposito
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
		<table id="tabla" class="table table-condensed table-bordered">
			<thead>
					<tr>
						<th class="text-center">% M2C</th>
						<th class="text-center">% Capacidad</th>
					</tr>
			</thead>
			<tbody>
				<?php
				do{
					$mysqli2 = new mysqli('localhost','gepp','gepp','gepp');
					//echo 'cmayor';
					$idoperacion= $row['numope'];
					//echo '<br>';
					$consulta2 = "SELECT idoperacion, FORMAT(SUM(csio),0) AS vcsio FROM orden WHERE idoperacion = $idoperacion AND fecha > current_date LIMIT 1";
					$resultado2 = $mysqli2->query($consulta2);
					$row2 = $resultado2->fetch_assoc();

					/*echo $row2['vcsio'];
					echo '<br>';
					echo $row['csio'];
					echo '<br>';]*/
					$style = 'active';

					if ($row['csio']==$row2['vcsio'] && $row2['vcsio']!=NULL) { 
						$style = 'success';
					}elseif ($row['csio']!=$row2['vcsio']) {
						$style = 'warning';
					}
				?>
					<tr class="<?php echo $style;?>">
						<td><?php echo $row['M2C']?></td>
						<td><?php echo $row['capacidad']?></td>
					</tr>
				<?php 
				}while($row = $resultado->fetch_assoc());
				//$mysqli->free();
				?>
			</tbody>	
		</table>
	</body>
</html>