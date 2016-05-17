<?php 
require_once("clases/class.MySQL.php");
$mysqli = new MySQL();

	$consulta = "SELECT c.nombre, p.Descripcion, o.secuencia, o.csio, o.cequivalentes FROM Orden o INNER JOIN Productos p ON o.sku = p.sku
				 INNER JOIN Clientes c ON c.nud = o.nud";
	$resultado = $mysqli->consulta($consulta);
    $row = $mysqli->fetch_assoc($resultado);
?>
<!DOCTYPE HTML>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<title>Gepp</title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<!-- CSS de Bootstrap -->
   		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
   		<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
   		
		<script>window.jQuery || document.write('<script src="js/jquery.min.js"><\/script>')</script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/funciones.js"></script>
		<script type="text/javascript" src="js/supersized.3.2.7.min.js"></script>
		<script type="text/javascript" src="theme/supersized.shutter.min.js"></script>
	</head>
	<body>
			<table id="tabla" class="table-striped table-bordered bootstrap-datatable datatable">
				<thead>
					<tr>
						<th class="text-center">Cliente</th>
						<th class="text-center">Producto</th>
						<th class="text-center">Secuencia</th>
						<th class="text-center">C. Sio</th>
						<th class="text-center">C. Equivalentes</th>
					</tr>
				</thead>
				<tbody>
					<?php
					do{
					 ?>
						<tr>
							<td><?php echo $row['nombre'] ?></td>
							<td><?php echo $row['Descripcion']?></td>
							<td><?php echo $row['secuencia']?></td>
							<td><?php echo $row['csio']?></td>
							<td><?php echo $row['cequivalentes']?></td>
						</tr>
					<?php 
					}while($row = $resultado->fetch_assoc())
					?>
				</tbody>	
			</table>
	
	</body>
</html>