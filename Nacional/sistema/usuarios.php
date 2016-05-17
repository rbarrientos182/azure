<?php include('header.php'); 

$consulta = "SELECT u.idUsuarios, u.usuario, u.nombre, u.puesto, u.correo, u.telefono, IF(u.estatus, 'Activo', 'Inactivo') AS estatuss, IF(u.estatus,'label-success','label-important') AS estatusE FROM Usuarios u";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);
?>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="usuarios.php">Usuarios</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-align-justify"></i>Usuarios</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
						  	  <tr>
						  	  	<th colspan="5" style="text-align:left">Agregar Usuario <a href="faUsuarios.php" class="icon icon-darkgray icon-add"></a></th>
						  	  </tr>	
							  <tr>
								  <th>Usuario</th>
								  <th>Nombre</th>
								  <th>Puesto</th>
								  <th>Correo</th>
								  <th>Teléfono</th>
								  <th>Estatus</th>
								  <th>Acciones</th>
							  </tr>
						  </thead>   
						  <tbody>
						  	<?php do{?>
								<tr>
									<td class="center"><?php echo $row['usuario']?></td>
									<td class="center"><?php echo $row['nombre'];?></td>
									<td class="center"><?php echo $row['puesto'];?></td>
									<td class="center"><?php echo $row['correo'];?></td>
									<td class="center"><?php echo $row['telefono'];?></td>									
									<td class="center">
										<span class="label <?php echo $row['estatusE'];?>"><?php echo $row['estatuss']; ?></span>
									</td>
									<td class="center">
										<a class="btn btn-success" href="fPermisosUsuario.php?id=<?php echo $row['idUsuarios']?>">
											<i class="icon icon-white icon-unlocked"></i>  
											Permisos                                            
										</a>
										<a class="btn btn-info" href="fmUsuarios.php?id=<?php echo $row['idUsuarios']; ?>">
											<i class="icon-edit icon-white"></i>  
											Editar                                           
										</a>
										<a class="btn btn-danger" href="dUsuarios.php?id=<?php echo $row['idUsuarios']; ?>">
											<i class="icon-trash icon-white"></i> 
											Eliminar
										</a>
									</td>
								</tr>
							<?php }while($row = $db->fetch_assoc($resultado)); ?>
						  </tbody>
					  </table>            
					</div>
				</div><!--/span-->
			
			</div><!--/row-->   
<?php include('footer.php'); ?>
