<?php include('header.php'); 

$consulta = "SELECT CONCAT('P',u.palets,'/',CASE u.TipoDePalet WHEN 0 THEN 'Estándar' WHEN 1 THEN 'Otro' END,'/',u.capacidad)  AS tpalet, CONCAT(d.deposito,' ',IF(o.mercado,'Moderno','Tradicional')) AS depositom , u.capacidad, u.palets, CASE u.tipo WHEN 1 THEN 'Camión' WHEN 2 THEN 'Camioneta' WHEN 3 THEN 'Moto' WHEN 4 THEN 'Diablo' WHEN 5 THEN 'Otros' END AS tipou,
r.idoperacion, r.idRuta, r.zona, r.Marca, r.numeroEconomico, r.odometro, IF(r.estatus,'label-success','label-important') AS estatusR, IF(r.estatus,'Activo','Inactivo') AS estatuss 
FROM ruta r INNER JOIN operaciones o ON r.idoperacion = o.idoperacion INNER JOIN deposito d ON d.idDeposito = o.idDeposito 
INNER JOIN unidades u ON u.idUnidades = r.idUnidades  ORDER BY r.idRuta";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);
?>


			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="rutas.php">Rutas</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-align-justify"></i> Rutas</h2>
						<div class="box-icon">
							<!--<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>-->
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<!--<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>-->
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
						  	  <tr>
						  	  	<th colspan="4" style="text-align:left">Agregar Ruta <a href="faRuta.php" class="icon icon-darkgray icon-add"></a></th>
						  	  </tr>
							  <tr>
								  <th>Deposito</th>
								  <th>Ruta</th>
								  <th>Capacidad</th>
								  <th>Zona</th>
								  <th>Tipo Unidad</th>
								  <th>Marca</th>
								  <th>Odómetro</th>
								  <th>Número Económico</th>
								  <th>Estatus</th>
								  <th>Acciones</th>
							  </tr>
						  </thead>   
						  <tbody>
						  	<?php do{?>
							<tr>
								<td><?php echo $row['depositom'];?></td>
								<td class="center"><?php echo $row['idRuta'];?></td>
								<td class="center"><?php echo $row['capacidad'];?></td>
								<td class="center"><?php echo $row['zona'];?></td>
								<td class="center"><?php echo $row['tipou'].'/'.$row['tpalet'];?></td>
								<td class="center"><?php echo $row['Marca'];?></td>
								<td class="center"><?php echo $row['odometro'];?></td>
								<td class="center"><?php echo $row['numeroEconomico'];?></td>
								<td class="center">
									<span class="label <?php echo $row['estatusR']; ?>"><?php echo $row['estatuss'];?></span>
								</td>
								<td class="center">
									<!--<a class="btn btn-success" href="fdRuta.php?id=<?php echo $row['idRuta'];?>&id2=<?php echo $row['idoperacion'];?>">
										<i class="icon-zoom-in icon-white"></i>  
										Detalles                                            
									</a>-->
									<a class="btn btn-info" href="fmRuta.php?id=<?php echo $row['idRuta'];?>&id2=<?php echo $row['idoperacion'];?>">
										<i class="icon-edit icon-white"></i>  
										Editar                                         
									</a>
									<!--<a class="btn btn-danger" href="dRuta.php?id=<?php echo $row['idRuta'];?>&id2=<?php echo $row['idoperacion'];?>">
										<i class="icon-trash icon-white"></i> 
										Borrar
									</a>-->
								</td>
							</tr>
							<?php 
							}while($row = $db->fetch_assoc($resultado));?>
						  </tbody>
					  </table>            
					</div>
				</div><!--/span-->
			
			</div><!--/row-->

			
    
<?php include('footer.php'); ?>
