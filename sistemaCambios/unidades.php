<?php include('header.php'); 

$consulta = "SELECT idUnidades,capacidad, CONCAT('P',palets,'/',CASE TipoDePalet WHEN 1 THEN 'Estándar' WHEN 2 THEN 'Otro' END,'/', capacidad)  AS tpalet,
CASE tipo WHEN 1 THEN 'Camión' WHEN 2 THEN 'Camioneta' WHEN 3 THEN 'Moto' WHEN 4 THEN 'Diablo' WHEN 5 THEN 'Otros' END AS tipou
FROM unidades ORDER BY idUnidades";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);
?>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="unidades.php">Unidades</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-align-justify"></i> Unidades</h2>
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
						  	  	  <th colspan="3" style="text-align:left">Agregar Unidad <a href="faUnidad.php" class="icon icon-darkgray icon-add"></a></th>
						  	  </tr>
							  <tr>
								  <th>Tipo Unidad</th>
								  <th>Capacidad</th>
								  <th>Acciones</th>
							  </tr>
						  </thead>   
						  <tbody>
						  	<?php do{?>
							<tr>
								<td class="center"><?php echo $row['tipou'].'/'.$row['tpalet'];?></td>
								<td class="center"><?php echo $row['capacidad']?></td>
								<td class="center">
									<!--<a class="btn btn-success" href="fdRuta.php?id=<?php echo $row['idRuta'];?>&id2=<?php echo $row['idoperacion'];?>">
										<i class="icon-zoom-in icon-white"></i>  
										Detalles                                            
									</a>-->
									<a class="btn btn-info" href="fmUnidad.php?id=<?php echo $row['idUnidades'];?>">
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
