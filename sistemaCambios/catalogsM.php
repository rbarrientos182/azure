<?php include('header.php'); 

$idoperacion = $_SESSION['idoperacion'];

$consulta = "SELECT pc.idProductoCambio, pc.sku, p.Descripcion, pc.DescripcionInterna FROM ProductosCambios pc INNER JOIN Productos p ON pc.sku = p.sku AND idoperacion = $idoperacion";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);
?>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="catalogsM.php">Catálogo Motivos</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-align-justify"></i>Catálogo Motivos</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
						  	  <!--<tr>
						  	  	<th colspan="5" style="text-align:left">Agregar Usuarios <a href="faUsuarios.php" class="icon icon-darkgray icon-add"></a></th>
						  	  </tr>-->	
							  <tr>
								  <th>Cliente</th>
								  <th>Motivo</th>
								  <th>Producto</th>
								  <th>Cantidad</th>
							  </tr>
						  </thead>   
						  <tbody>
						  	<?php do{?>
								<tr>
									<td class="center"><?php echo $row['sku']?></td>
									<td class="center"><?php echo $row['Descripcion'];?></td>
									<td class="center"><?php echo $row['DescripcionInterna'];?></td>
									<td class="center">
										<a class="btn btn-info" href="fmCatalogoP.php?id=<?php echo $row['idProductoCambio']; ?>">
											<i class="icon-edit icon-white"></i>  
											Editar                                           
										</a>
										<!--<a class="btn btn-danger" href="dUsuarios.php?id=<?php echo $row['idProductoCambio']; ?>">
											<i class="icon-trash icon-white"></i> 
											Eliminar
										</a>-->
									</td>
								</tr>
							<?php }while($row = $db->fetch_assoc($resultado)); ?>
						  </tbody>
					  </table>            
					</div>
				</div><!--/span-->
			
			</div><!--/row-->   
<?php include('footer.php'); ?>