<?php include('header.php'); 
$consulta = "SELECT idRegion, region, director, correo FROM Region ORDER BY idRegion";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);
?>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="regiones.php">Regiones</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-align-justify"></i> Regiones</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
						  	  <tr>
						  	  	<!-- <th colspan="4" style="text-align:left">Agregar Región <a href="faRegion.php" class="icon icon-darkgray icon-add"></a></th> -->
						  	  </tr>
							  <tr>
								  
								  <th>Región</th>
								  <th>Director</th>
								  <th>Email</th>
								  <th>Acciones</th>
							  </tr>
						  </thead>   
						  <tbody>
						  	<?php do{ ?>
							<tr>
								
								<td class="center"><?php echo $row['region'];?></td>
								<td class="center"><?php echo $row['director'];?></td>
								<td class="center"><?php echo $row['correo'];?></td>
								<td class="center">
									<a class="btn btn-info" href="fmRegion.php?id=<?php echo $row['idRegion'];?>">
										<i class="icon-edit icon-white"></i>  
										Editar                                            
									</a>
									<a class="btn btn-info ajax-popup-link" href="mapaRegiones.php?id=<?php echo $row['idRegion']; ?>">
											<i class="icon-map-marker icon-white"></i>  
											Ver en Mapa                                           
									</a>
									<!--<a class="btn btn-danger" href="dRegion.php?id=<?php echo $row['idRegion'];?>">
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
