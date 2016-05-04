<?php include('header.php'); 
$idoperacion = $_SESSION['idoperacion'];
$consulta = "SELECT rc.idrutasCambios,rc.ruta,gs.numgrupo, CASE rc.tipo WHEN 1 THEN 'Fijo' WHEN 2 THEN 'Dinamico' END AS tipoRuta, CASE rc.tMercado WHEN 0 THEN 'Tradicional' WHEN 1 THEN 'Moderno' WHEN 2 THEN 'Híbrido' END AS tipoMercado, IF(rc.estatus,'label-success','label-important') AS estatusR, IF(rc.estatus,'Habilitado','Inahabilitado') AS estatuss FROM rutasCambios rc INNER JOIN gruposupervision gs ON gs.idgruposupervision = rc.idgruposupervision AND rc.idoperacion = $idoperacion";
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
								  <th>Ruta</th>
								  <th>Tipo</th>
								  <th>Mercado</th>
								  <th>Grupo Supervisión</th>
								  <th>Estatus</th>
								  <th>Acciones</th>
							  </tr>
						  </thead>   
						  <tbody>
						  	<?php do{?>
							<tr>
								<td><?php echo $row['ruta'];?></td>
								<td class="center"><?php echo $row['tipoRuta'];?></td>
								<td class="center"><?php echo $row['tipoMercado'];?></td>
								<td class="center"><?php echo $row['numgrupo'];?></td>
								<td class="center">
									<span class="label <?php echo $row['estatusR']; ?>"><?php echo $row['estatuss'];?></span>
								</td>
								<td class="center">
									<a class="btn btn-info" href="fmRuta.php?id=<?php echo $row['idrutasCambios'];?>">
										<i class="icon-edit icon-white"></i>  
										Editar                                         
									</a>
									<!--<a class="btn btn-danger" href="dRuta.php?id=<?php echo $row['idrutasCambios'];?>">
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
