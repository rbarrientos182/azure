<?php 

require_once("clases/class.MySQL.php");

$mysqli = new MySQL();

$inicio = $_POST['inicio'];
$fin = $_POST['fin'];


$consulta = "SELECT nombre, direccion, CONCAT(calleizq,' y ',calleder) AS cruce FROM Clientes  ORDER BY nombre LIMIT ".$inicio.", ".$fin;
$resultado = $mysqli->consulta($consulta);
$row = $mysqli->fetch_assoc($resultado);
?>

<!DOCTYPE HTML>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<title>Gepp</title>
		<!-- CSS de Bootstrap -->
   		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
   		<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
   		<script src="bootstrap/js/bootstrap.min.js"></script>
	</head>
	<body>
		<table id="tabla" class="table-striped table-bordered bootstrap-datatable datatable">
			<thead>
				<tr>
					<th class="text-center">Cliente</th>
					<th class="text-center">Dirección</th>
					<th class="text-center">Cruce</th>
				</tr>
			</thead>
			<tbody>
				<?php
				do{
				?>
					<tr>
						<td><?php echo 1;?></td>
						<td><?php echo 2;?></td>
						<td><?php echo 4;?></td>
					</tr>
				<?php 
				}while($row = $resultado->fetch_assoc());
					$mysqli->free();
				?>
			</tbody>	
		</table>
	</body>
</html>