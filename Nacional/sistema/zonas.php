<?php include('header.php'); 
$consulta = "SELECT z.idZona, z.zona, z.gerenteZona, r.region FROM Zona z, Region r WHERE r.idRegion = z.idRegion ORDER BY z.idZona";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);
?>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="zonas.php">Zonas</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-align-justify"></i>Zonas</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
						  	  <tr>
						  	  	<th colspan="4" style="text-align:left">Agregar Zona<a href="faZona.php" class="icon icon-darkgray icon-add"></a></th>
						  	  </tr>
							  <tr>
								  <th>Id Zona</th>
								  <th>Región</th>
								  <th>Zona</th>
								  <th>Gerente</th>
								  <th>Acciones</th>
							  </tr>
						  </thead>   
						  <tbody>
						  	<?php do{ ?>
							<tr>
								<td><?php echo $row['idZona'];?></td>
								<td class="center"><?php echo $row['region'];?></td>
								<td class="center"><?php echo $row['zona'];?></td>
								<td class="center"><?php echo $row['gerenteZona'];?></td>
								<td class="center">
									<a class="btn btn-info" href="fmZona.php?id=<?php echo $row['idZona'];?>">
										<i class="icon-edit icon-white"></i>  
										Editar                                            
									</a>
									<a class="btn btn-info ajax-popup-link" href="mapaZona.php?id=<?php echo $row['idZona']; ?>">
											<i class="icon-map-marker icon-white"></i>  
											Ver en Mapa                                           
									</a>
									<!--<a class="btn btn-danger" href="dZona.php?id=<?php echo $row['idZona'];?>">
										<i class="icon-trash icon-white"></i> 
										Borrar
									</a>-->
								</td>
							</tr>
							<?php  }while($row = $db->fetch_assoc($resultado));?>
						  </tbody>
					  </table>            
					</div>
				</div><!--/span-->
			
			</div><!--/row-->

			
    
<?php include('footer.php'); ?>
