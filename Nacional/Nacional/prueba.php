<?php 
require_once("clases/class.MySQL.php");
$mysqli = new MySQL();

	$consulta = "SELECT zona, deposito, gerenteDeposito, jefeEntrega, operadorSistema, telefonoExt, correoGD, correoJE, correoOP, IF(estatus, 'Activo','Inactivo') AS estatusD
	 FROM deposito d INNER JOIN zona z ON d.idZona = z.idZona ORDER BY deposito";
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
   		<link id="bs-css"  href="bootstrap/css/bootstrap-cerulean.css" rel="stylesheet">
   		
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
						<th class="text-center">Zona</th>
						<th class="text-center">Deposito</th>
						<th class="text-center">Gerente</th>
						<th class="text-center">Email Gerente</th>
						<th class="text-center">Jefe Entrega</th>
						<th class="text-center">Email Jefe Entrega</th>
						<th class="text-center">Operador Sistema</th>
						<th class="text-center">Email Operador</th>	
						<th class="text-center">Teléfono Ext</th>
						<th class="text-center">Estatus</th>	
					</tr>
				</thead>
				<tbody>
					<?php
					do{
					 ?>
						<tr>
							<td><?php echo $row['zona'] ?></td>
							<td><?php echo $row['deposito']?></td>
							<td><?php echo $row['gerenteDeposito'] ?></td>
							<td><?php echo $row['correoGD'] ?></td>
							<td><?php echo $row['jefeEntrega'] ?></td>
							<td><?php echo $row['correoJE'] ?></td>
							<td><?php echo $row['operadorSistema'] ?></td>
							<td><?php echo $row['correoOP'] ?></td>
							<td><?php echo $row['telefonoExt'] ?></td>
							<td><?php echo $row['estatusD'] ?></td>
						</tr>
					<?php 
					}while($row = $resultado->fetch_assoc())
					?>
				</tbody>	
			</table>
	</body>
</html>