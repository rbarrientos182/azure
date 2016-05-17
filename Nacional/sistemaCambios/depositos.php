<?php include('header.php'); 

$consulta = "SELECT o.idoperacion as idoperacion, r.Region as region, z.Zona as zona, d.iddeposito as iddeposito, d.Deposito as deposito, if(mercado,'Moderno','Tradicional') as Mercado, count(distinct ru.idruta) as Rutas, count(nud) as Clientes FROM region r, zona z, deposito d, operaciones o, ruta ru, clientes c 
where r.idregion = z.idRegion and z.idZona=d.idZona and d.iddeposito=o.iddeposito and o.idoperacion=ru.idoperacion and ru.estatus=1 and c.vpp=ru.idruta and d.iddeposito=c.iddeposito
group by o.idoperacion order by r.idregion, deposito";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);
?>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="#">Inicio</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="#">Depositos</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-align-justify"></i> Depositos</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
						  	  <tr>
						  	  	<th colspan="5" style="text-align:left">Agregar Deposito <a href="faDeposito.php" class="icon icon-darkgray icon-add"></a></th>
						  	  </tr>	
							  <tr>
								  <th>Region</th>
								  <th>Zona</th>
								  <th>No.Deposito</th>
								  <th>Deposito</th>
								  <th>Rutas</th>
								  <th>Clientes en DD</th>
								  <th>Mercado</th>
								  <th>Acciones</th>
							  </tr>
						  </thead>   
						  <tbody>
						  	<?php do{?>
								<tr>
									<td class="center"><?php echo $row['region']?></td>
									<td class="center"><?php echo $row['zona']?></td>
									<td class="center"><?php echo $row['iddeposito'];?></td>
									<td class="center"><?php echo $row['deposito'];?></td>
									<td class="center"><?php echo $row['Rutas'];?></td>
									<td class="center"><?php echo $row['Clientes'];?></td>
									<td class="center"><?php echo $row['Mercado'];?></td>
									
									<td class="center">
										<!--<a class="btn btn-success" href="fdDeposito.php?id=<?php echo $row['idDeposito']?>">
											<i class="icon-zoom-in icon-white"></i>  
											Detalles                                            
										</a>-->
										<a class="btn btn-info" href="fmDeposito.php?id=<?php echo $row['iddeposito']; ?>">
											<i class="icon-edit icon-white"></i>  
											Editar                                           
										</a>
										<a class="btn btn-info ajax-popup-link" href="mapaDeposito.php?id=<?php echo $row['iddeposito']; ?>">
											<i class="icon-map-marker icon-white"></i>  
											Ver en Mapa                                           
										</a>
										<!--<a class="btn btn-danger" href="Edeposito.php?id=<?php echo $row['idDeposito']; ?>">
											<i class="icon-trash icon-white"></i> 
											Eliminar
										--></a>
									</td>
								</tr>
							<?php }while($row = $db->fetch_assoc($resultado)); ?>
						  </tbody>
					  </table>            
					</div>
				</div><!--/span-->
			
			</div><!--/row-->

<?php include('footer.php'); ?>
