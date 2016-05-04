<?php 
require_once("clases/class.MySQL.php");
$mysqli = new MySQL();

$inicio = $_POST['inicio'];
$fin = $_POST['fin'];

//$inicio = 1;
//$fin = 10;


$consulta = "SELECT c.nombre, p.Descripcion, o.secuencia, o.csio, o.cequivalentes FROM Orden o INNER JOIN Productos p ON o.sku = p.sku
		INNER JOIN Clientes c ON c.nud = o.nud LIMIT ".$inicio.", ".$fin;
$resultado = $mysqli->consulta($consulta);
$row = $mysqli->fetch_assoc($resultado);
?>

<!DOCTYPE HTML>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<title>Gepp</title>
  		<script>window.jQuery || document.write('<script src="js/jquery.min.js"><\/script>')</script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
	</head>
	<body>
		<table id="tabla" class="table-striped table-bordered bootstrap-datatable datatable">
			<thead>
					<tr>
						<th class="text-center">Cajas SIO</th>
						<th class="text-center">Cajas Equivalentes</th>
						<th class="text-center">Secuencia</th>
					</tr>
			</thead>
			<tbody>
				<?php
				do{
				?>
					<tr>
						<td><?php echo $row['csio'] ?></td>
						<td><?php echo $row['cequivalentes']?></td>
						<td><?php echo $row['secuencia']?></td>
					</tr>
				<?php 
				}while($row = $resultado->fetch_assoc());
				$mysqli->free();
				?>
			</tbody>	
		</table>
	</body>
</html>